<?php

declare(strict_types=1);

namespace App\Exception\Company;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CompanyNotFound extends BadRequestHttpException
{
    private const MESSAGE = 'Company with ID %s does not exist';

    public function __construct(string $id)
    {
        throw new self(\sprintf(self::MESSAGE, $id));
    }
}
