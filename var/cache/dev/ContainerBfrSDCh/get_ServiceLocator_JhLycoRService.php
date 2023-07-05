<?php

namespace ContainerBfrSDCh;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_JhLycoRService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.jhLycoR' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.jhLycoR'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'leagueRepository' => ['privates', 'App\\Repository\\Library\\LeagueRepository', 'getLeagueRepositoryService', true],
        ], [
            'leagueRepository' => 'App\\Repository\\Library\\LeagueRepository',
        ]);
    }
}