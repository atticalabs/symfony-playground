<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $firtName;

    /**
     * Get the value of firtName
     *
     * @return  string
     */
    public function getFirtName()
    {
        return $this->firtName;
    }

    /**
     * Set the value of firtName
     *
     * @param  string  $firtName
     *
     * @return  self
     */
    public function setFirtName(string $firtName)
    {
        $this->firtName = $firtName;

        return $this;
    }
}
