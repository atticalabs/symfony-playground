<?php

namespace App\Query;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;


class GetUserQueryHandler
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param GetUserQuery $userQuery
     * @return \App\Entity\User|null
     * @throws EntityNotFoundException
     */
    public function handle(GetUserQuery $userQuery)
    {
        $user = $this->userRepository->findByFirstName($userQuery->getFirstName());

        if ($user) {
            throw new EntityNotFoundException('UserNotFounded');
        }

        return $user;
    }
}
