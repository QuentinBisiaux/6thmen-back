<?php

namespace ContainerBfrSDCh;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_6HaNt6EService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.6HaNt6E' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.6HaNt6E'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'league' => ['privates', '.errored..service_locator.6HaNt6E.App\\Entity\\Library\\League', NULL, 'Cannot autowire service ".service_locator.6HaNt6E": it needs an instance of "App\\Entity\\Library\\League" but this type has been excluded in "config/services.yaml".'],
            'leagueRepository' => ['privates', 'App\\Repository\\Library\\LeagueRepository', 'getLeagueRepositoryService', true],
        ], [
            'league' => 'App\\Entity\\Library\\League',
            'leagueRepository' => 'App\\Repository\\Library\\LeagueRepository',
        ]);
    }
}