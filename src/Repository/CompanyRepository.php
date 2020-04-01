<?php

namespace App\Repository;

use App\Entity\Company;
use App\Repository\BaseRepository;

class CompanyRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Company::class;
    }

    public function save(Company $company): void
    {
        $this->saveEntity($company);
    }

    public function findOneByName(string $name): ?Company
    {
        /** @var Company $company */
        $company = $this->objectRepository->findOneBy(['name' => $name]);

        return $company;
    }


    public function findOneById(string $id): ?Company
    {
        /** @var Company $company */
        $company = $this->objectRepository->findOneBy(['id' => $id]);

        return $company;
    }
}
