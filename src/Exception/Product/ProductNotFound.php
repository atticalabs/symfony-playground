<?php

declare(strict_types=1);

namespace App\Exception\Product;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductNotFound extends BadRequestHttpException
{
    private const MESSAGE = 'Product with ID %s does not exist';

    public function __construct(string $id)
    {
        throw new self(\sprintf(self::MESSAGE, $id));
    }
}
