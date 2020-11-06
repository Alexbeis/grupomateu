<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;

class IncomingRegisterRepository extends ServiceEntityRepository implements IncomingRegisterRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IncomingRegister::class);
    }

    public function save(IncomingRegister $incomingRegister)
    {
        $this->_em->persist($incomingRegister);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function getPaginatedIncomingRegisters(array $data)
    {
        $start = $data['start'] ? $data['start'] : 0;
        $limit = $data['length'] ? $data['length'] : 10;
        $search = $data['search']['value'];

        list($orderBy, $order) = $this->getOrderByData($data);

        $qb = $this->createQueryBuilder('ir');

        switch ($orderBy) {
            case 'type':
                $qb->orderBy("ir.inType", $order);
                break;
            case 'procedence':
                $qb->orderBy("ir.procedence", $order);
                break;
            case 'animalsCount':
                $qb->orderBy('ir.animalsCount', $order);
                break;
            default:
                $qb->orderBy("ir.createdAt", $order);
        }

        if ($search) {
            $qb->innerJoin('ir.inType', 'inType');

            $qb->where(
                $qb->expr()->orX(
                    $qb->expr()->like('inType.name','?1'),
                    $qb->expr()->like('ir.procedence', '?1')
                )
            )->setParameter('1', '%'.$search.'%');
        }

        $query = $qb->getQuery();

        $paginator = $this->paginate($query, $start, $limit);

        $result = [];

        $result['data'] = array_map(function ($element) {
            return [
                'type' =>$element->getInType()->getName(),
                'procedence' => $element->getProcedence(),
                'animalsCount' => $element->getAnimalsCount(),
                'createdAt' => $element->getCreatedAt()->format('d-m-y'),
                'createdBy' => $element->getCreatedBy()->getUsername(),
                'uuid' => $element->getUuid()
            ];
        }, $paginator->getQuery()->execute());

        return array_merge(
            $result,
            [
                'recordsTotal' => $paginator->count(),
                'recordsFiltered' => $paginator->count()
            ]
        );
    }

    private function paginate(Query $query, int $start, int $limit)
    {
        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($start)
            ->setMaxResults($limit);

        return $paginator;
    }

    private function getOrderByData($data)
    {
        $order = $data['order'][0]['dir'];
        $orderByindex = $data['order'][0]['column'];

        $orderBy = $data['columns'][$orderByindex]['data'];

        return [$orderBy, $order];
    }

}
