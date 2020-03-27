<?php

namespace App\Query;

class GetUserQuery
{
    /** @var string */
    private $firstName;

    /**
     * User constructor.
     * @param string $firstName
     */
    public function __construct(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get the value of firstName
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
}
