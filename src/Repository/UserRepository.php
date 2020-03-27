<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class UserRepository extends ServiceEntityRepository
{
    private $user1;

    private array $repo;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $userName
     * 
     * @return string
     */
    public function findByFirstName(string $userName): string
    {
        $user1 = new User();
        $user1->setFirstName("Jorge");
        $user1->setId(1);

        $repo = array($user1);

        $result = array_search($userName, UserRepository::$repo);

        if (!is_bool($result))
            return UserRepository::$repo[$result];
        else
            return "NOT_FOUND";
    }
}
