<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\Feedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\AST\Functions\AvgFunction;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @return Course[]
     */
    public function findBestCourses(): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin(Feedback::class, 'f', 'WITH', 'c.id = f.course')
            ->select('c.id', 'c.name', 'avg(f.overall)')
            ->groupBy('c.name', 'c.id')
            ->orderBy('avg(f.overall)', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Query
     */
    public function findCourseIdQuery($course_id): Query
    {
        return $this->createQueryBuilder('c')
            ->where('c.id = :course_id')
            ->setParameter('course_id', $course_id)
            ->getQuery();
    }

    /**
     * @return Course[]
     */
    public function findLatestCourses($course_id)
    {
        return $this->createQueryBuilder('c')
            ->where('c.id = :course_id')
            ->innerJoin(Feedback::class, 'f', 'WITH', 'c.id = f.course')
            ->setParameter('course_id', $course_id)
            ->orderBy('f.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }



    // /**
    //  * @return Course[] Returns an array of Course objects
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
    public function findOneBySomeField($value): ?Course
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
