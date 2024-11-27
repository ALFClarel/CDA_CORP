<?php
namespace App\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Security\Core\Exception\ProviderNotFoundException;

class UserProviderResolver
{
    private ServiceLocator $serviceLocator;

    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Récupère un UserProvider en fonction de la clé fournie.
     *
     * @param string $providerKey
     * @return UserProviderInterface
     * @throws ProviderNotFoundException
     */
    public function getProvider(string $providerKey): UserProviderInterface
    {
        if (!$this->serviceLocator->has($providerKey)) {
            throw new ProviderNotFoundException(sprintf('UserProvider "%s" not found.', $providerKey));
        }

        return $this->serviceLocator->get($providerKey);
    }
}
