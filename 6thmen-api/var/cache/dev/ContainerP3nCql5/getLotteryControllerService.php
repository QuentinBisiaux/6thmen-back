<?php

namespace ContainerP3nCql5;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getLotteryControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\LotteryController' shared autowired service.
     *
     * @return \App\Controller\LotteryController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/LotteryController.php';

        $container->services['App\\Controller\\LotteryController'] = $instance = new \App\Controller\LotteryController(($container->services['event_dispatcher'] ?? self::getEventDispatcherService($container)));

        $instance->setContainer(($container->privates['.service_locator.O2p6Lk7'] ?? $container->load('get_ServiceLocator_O2p6Lk7Service'))->withContext('App\\Controller\\LotteryController', $container));

        return $instance;
    }
}
