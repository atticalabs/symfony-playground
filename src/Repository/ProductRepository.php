<?php

namespace App\Repository;

use App\Entity\Product;

class ProductRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Product::class;
    }

    public function save(Product $company): void
    {
        $this->saveEntity($company);
    }

    public function findOneById(string $id): ?Product
    {
        /** @var Product $company */
        $prod = $this->objectRepository->findOneBy(['id' => $id]);

        return $prod;
    }
}
