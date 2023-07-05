<?php

namespace ContainerBfrSDCh;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Zq_7dLService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.Zq.7d_L' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.Zq.7d_L'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'country' => ['privates', '.errored..service_locator.Zq.7d_L.App\\Entity\\Library\\Country', NULL, 'Cannot autowire service ".service_locator.Zq.7d_L": it needs an instance of "App\\Entity\\Library\\Country" but this type has been excluded in "config/services.yaml".'],
            'countryRepository' => ['privates', 'App\\Repository\\Library\\CountryRepository', 'getCountryRepositoryService', true],
        ], [
            'country' => 'App\\Entity\\Library\\Country',
            'countryRepository' => 'App\\Repository\\Library\\CountryRepository',
        ]);
    }
}