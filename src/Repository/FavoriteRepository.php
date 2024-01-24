<?php

namespace App\Repository;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Favorite;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Favorite>
 *
 * @method Favorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favorite[]    findAll()
 * @method Favorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorite::class);
    }
    
    public function isRoomFavorite(User $user, Room $room): bool
    {
        return $this->createQueryBuilder('f') // f for favorite
            ->andWhere('f.traveler = :user') // f.traveler is the user who favorited the room
            ->andWhere(':room MEMBER OF f.rooms') // f.rooms is the collection of rooms favorited by the user
            ->setParameter('user', $user) // :user is the user who is logged in
            ->setParameter('room', $room) // :room is the room we want to check if it's favorited by the user
            ->getQuery() // get the query
            ->getOneOrNullResult() !== null; // if the query returns a result, it means the room is favorited by the user
    }

//    /**
//     * @return Favorite[] Returns an array of Favorite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Favorite
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}