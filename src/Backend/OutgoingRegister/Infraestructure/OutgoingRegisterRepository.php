<?php

namespace Mateu\Backend\OutgoingRegister\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\OutgoingRegister\Domain\Entity\OutgoingRegister;
use Mateu\Backend\OutgoingRegister\Domain\OutgoingRegisterRepositoryInterface;

class OutgoingRegisterRepository extends ServiceEntityRepository implements OutgoingRegisterRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutgoingRegister::class);
    }

    public function getPaginatedOutgoingRegisters(array $data)
    {
        $start = $data['start'] ? $data['start'] : 0;
        $limit = $data['length'] ? $data['length'] : 10;
        $search = $data['search']['value'];

        list($orderBy, $order) = $this->getOrderByData($data);

        $qb = $this->createQueryBuilder('out_r');


        switch ($orderBy) {
            case 'type':
                $qb->orderBy("out_r.outType", $order);
                break;
            case 'destination':
                $qb->orderBy("out_r.destination", $order);
                break;
            case 'animalsCount':
                $qb->orderBy('out_r.animalsCount', $order);
                break;
            default:
                $qb->orderBy("out_r.createdAt", $order);
        }

        if ($search) {
            $qb->innerJoin('out_r.outType', 'outType');

            $qb->where(
                $qb->expr()->orX(
                    $qb->expr()->like('outType.name','?1'),
                    $qb->expr()->like('out_r.destination', '?1')
                )
            )->setParameter('1', '%'.$search.'%');
        }

        $query = $qb->getQuery();

        $paginator = $this->paginate($query, $start, $limit);

        $result = [];

        $result['data'] = array_map(function ($element) {
            /**
             * @var OutgoingRegister $element
             */
            return [
                'type' =>$element->getOutType()->getName(),
                'destination' => $element->getDestination(),
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