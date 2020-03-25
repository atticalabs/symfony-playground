<?php

use App\Entity\User;

class UserRepository //extends AbstractRepository
{
    private static array $repo = array("Jorge", "Pedro");

    /**
     * @param string $userName
     * 
     * @return string
     */
    public static function findByFirstName(string $userName): string
    {
        $result = array_search($userName, UserRepository::$repo);

        if (!is_bool($result))
            return UserRepository::$repo[$result];
        else
            return "NOT_FOUND";
    }
}
