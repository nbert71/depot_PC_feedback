<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\Feedback;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Scalar;

/**
 * @method Feedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    // /**
    //  * @return Feedback[] Returns an array of Feedback objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Feedback
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Feedback[]
     */
    public function findAllNew(): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.valid = true')
            ->orderBy('f.createdAt', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Query
     */
    public function findbyuser(User $user): Query
    {
        return $this->createQueryBuilder('f')
            ->where('f.author = :user')
            ->setParameter('user', $user)
            ->orderBy('f.createdAt', 'DESC')
            ->getQuery();
    }

    /**
     * @return Scalar
     */
    public function countNbFbUserOnline(User $user)
    {
        return $this->createQueryBuilder('f')
            ->where('f.author = :user')
            ->andwhere('f.valid = true')
            ->setParameter('user', $user)
            ->select("COUNT(f)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Scalar
     */
    public function countNbFbUserModerate(User $user)
    {
        return $this->createQueryBuilder('f')
            ->where('f.author = :user')
            ->andwhere('f.valid = false')
            ->setParameter('user', $user)
            ->select("COUNT(f)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Scalar
     */
    public function countNbFbOnline()
    {
        return $this->createQueryBuilder('f')
            ->andwhere('f.valid = true')
            ->select("COUNT(f)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Feedback[]
     */
    public function findnonvalid(): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.valid = false')
            ->orderBy('f.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Scalar
     */
    public function countNbFbModerate()
    {
        return $this->createQueryBuilder('f')
            ->andwhere('f.valid = false')
            ->select("COUNT(f)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Query
     */
    public function getFbDate($course): Query
    {
        return $this->createQueryBuilder('f')
            ->where('f.course = :course')
            ->setParameter('course', $course)
            ->orderBy('f.createdAt', 'DESC')
            ->getQuery();
    }
}
