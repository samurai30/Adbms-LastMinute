<?php

namespace App\Repository;

use App\Entity\Chapters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Chapters|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chapters|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chapters[]    findAll()
 * @method Chapters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChaptersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Chapters::class);
    }

    public function getChapters($value){
        $results = $this->createQueryBuilder('c')
            ->select('c, cc')
            ->leftJoin('c.subject', 'cc')
            ->where('cc.course = :val')
            ->setParameter('val',$value)
            ->getQuery()
            ->getResult();


        $chapterArray = [];
        foreach ($results as $result){
            $chapterArray += [$result->getChapterName() => $result->getId()];
        }
        return $chapterArray;
    }

    public function getChapBySub($value){
        $results = $this->createQueryBuilder('c')
            ->select('c, cc')
            ->leftJoin('c.subject','cc')
            ->where('cc.subName = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
        $chapterArray = [];
        foreach ($results as $result){
            $chapterArray += [$result->getChapterName() => $result->getChapterName()];
        }
        return $chapterArray;
    }
    // /**
    //  * @return Chapters[] Returns an array of Chapters objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Chapters
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
