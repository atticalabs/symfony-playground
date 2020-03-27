<?php

namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Dto\UserDto;
use App\Query\GetUserQuery;
use App\Query\GetUserQueryHandler;

class MobileDeviceDataProvider implements ItemDataProviderInterface
{
    /** @var  GetUserQueryHandler */
    private $getUserQueryHandler;

    /**
     * MobileDeviceWriteSubscriber constructor.
     *
     * @param GetUserQueryHandler $getMobileDeviceQueryHandler
     */
    public function __construct(GetUserQueryHandler $getMobileDeviceQueryHandler)
    {
        $this->getMobileDeviceQueryHandler = $getMobileDeviceQueryHandler;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     *
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null): bool
    {
        return UserDto::class === $resourceClass;
    }

    /**
     * @param string $resourceClass
     * @param int|string $id
     * @param string|null $operationName
     * @param array $context
     * @return UserDto
     *
     * @throws ResourceClassNotSupportedException
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        if (!$this->supports($resourceClass, $operationName)) {
            throw new ResourceClassNotSupportedException();
        }

        /** @var \AppBundle\Entity\MobileDevice $mobileDevice */
        $user = $this->getUserQueryHandler->handle(new GetUserQuery($id));

        $dtoUser = new UserDto();
        $dtoUser->setFirtName($user->getFirstName());

        return $dtoUser;
    }
}
