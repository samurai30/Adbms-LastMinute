<?php

namespace App\Repository;

use App\Entity\Subjects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Subjects|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subjects|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subjects[]    findAll()
 * @method Subjects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subjects::class);
    }

    public function getSubject($value){
        $results = $this->createQueryBuilder('c')
            ->where('c.course = :val')
            ->setParameter('val',$value)
            ->getQuery()
            ->getResult();

        $subjectArray = [];
        foreach ($results as $result){
            $subjectArray += [$result->getSubName() => $result->getId()];
        }
        return $subjectArray;


    }

    // /**
    //  * @return Subjects[] Returns an array of Subjects objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subjects
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
