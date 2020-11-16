<?php

namespace Mateu\Backend\Annex\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;
use Mateu\Backend\Annex\Domain\Entity\Annex;

class AnnexRepository extends ServiceEntityRepository implements AnnexRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annex::class);
    }

    public function save(Annex $annex)
    {
        $this->_em->persist($annex);
    }

    public function getTotals()
    {
        $qb = $this->createQueryBuilder('annex');
        $qb->select('count(annex.id)');
        $total = $qb->getQuery()->getSingleScalarResult();

        return $total;
    }

    public function getAnnexGroupedByExplotation()
    {
        $qb = $this->createQueryBuilder('annex');
        $query = $qb
            ->select('annex', 'e.code', 'e.name')
            ->join('annex.animal','a')
            ->join('a.explotation', 'e')
            ->orderBy('e.code')
            ->getQuery();

        $result = [];
        foreach ($query->getResult() as $item) {
            $result[$item['code']][] = $item[0] ;
        }

        return $result;
    }

    public function getGroupedByExplotation()
    {
        $qb = $this->createQueryBuilder('annex');
        $query = $qb->select('e.code', 'e.name','COUNT(annex.id) as count')
            ->join('annex.animal', 'a')
            ->join('a.explotation', 'e')
            ->groupBy('e.id')
            ->getQuery();

        return $query->getResult();

    }

    public function existsSupressedByExplotation($expCode)
    {
        $qb = $this->createQueryBuilder('annex');
        $query = $qb->select('annex', 'a')
            ->join('annex.animal', 'a')
            ->join('a.explotation', 'e')
            ->leftJoin('a.supression', 's')
            ->andWhere('e.code = :expcode')
            ->andWhere('s.id IS NOT null')
            ->setParameter('expcode', $expCode)
            ->getQuery();


        return $query->getResult();

    }

    public function getAnnexedAnimalsByExplotationCode($expCode)
    {
        $qb = $this->createQueryBuilder('annex');
        $query = $qb->select('annex', 'a')
            ->join('annex.animal', 'a')
            ->join('a.explotation', 'e')
            ->andWhere('e.code = :expcode')
            ->setParameter('expcode', $expCode)
            ->getQuery();


        return $query->getResult();
    }

    public function deleteAnnexedByExplotationCode($code)
    {
        $qb = $this->createQueryBuilder('annex');
        $query = $qb->select('annex')
            ->join('annex.animal', 'a')
            ->join('a.explotation', 'e')
            ->andWhere('e.code = :expcode')
            ->setParameter(':expcode', $code)
            ->getQuery();

        $arrayIds = array_map(
            function($element) {
                return $element['id'];
            }, $query->getArrayResult()
        );

        $queryDelete = $this->createQueryBuilder('annex')
            ->where('annex.id in (:ids)')
            ->setParameter('ids', $arrayIds)
            ->delete()
            ->getQuery();


        return $queryDelete->execute();

    }

    public function exists(string $crotal)
    {
        return null !== $this->findByAnimalCrotal($crotal);
    }

    public function remove($annex)
    {
        $this->_em->remove($annex);
    }
}