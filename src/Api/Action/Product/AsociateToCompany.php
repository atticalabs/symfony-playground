<?php

namespace App\Api\Action\Product;

use App\Api\Action\RequestTransformer;
use App\Service\Company\CompanyService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AsociateToCompany
{
    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * @Route("/product/asociate",methods={"POST"},name="Associcate product to company")
     */
    public function __invoke(Request $request): JsonResponse
    {
        $productId = RequestTransformer::getRequiredField($request, 'productId');
        $companyId = RequestTransformer::getRequiredField($request, 'companyId');

        $this->companyService->addProductToCompany($companyId, $productId);

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }
}
