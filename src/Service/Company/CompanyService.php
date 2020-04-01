<?php

namespace App\Service\Company;

use App\Repository\CompanyRepository;
use App\Repository\ProductRepository;
use App\Exception\Company\CompanyNotFound;
use App\Exception\Product\ProductNotFound;

class CompanyService
{
    private CompanyRepository $companyRepository;

    private ProductRepository $productRepository;

    public function __construct(CompanyRepository $companyRepository, ProductRepository $productRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->productRepository = $productRepository;
    }

    public function addProductToCompany(string $companyId, string $productId): void
    {
        $company = $this->companyRepository->findOneById($companyId);

        if ($company == null)
            throw new CompanyNotFound($companyId);

        $product = $this->productRepository->findOneById($productId);

        if ($product == null)
            throw new ProductNotFound($productId);

        $company->addProduct($product);

        $this->companyRepository->save($company);
    }
}
