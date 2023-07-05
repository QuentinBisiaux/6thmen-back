<?php

namespace ContainerBfrSDCh;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_Security_RequestMatcher_HawAXwsService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.security.request_matcher.HawAXws' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\ChainRequestMatcher
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/RequestMatcherInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/ChainRequestMatcher.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/RequestMatcher/PathRequestMatcher.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/RequestMatcher/HostRequestMatcher.php';

        return $container->privates['.security.request_matcher.HawAXws'] = new \Symfony\Component\HttpFoundation\ChainRequestMatcher([($container->privates['.security.request_matcher._LA_AHr'] ??= new \Symfony\Component\HttpFoundation\RequestMatcher\PathRequestMatcher('^/')), ($container->privates['.security.request_matcher.95UdEsw'] ??= new \Symfony\Component\HttpFoundation\RequestMatcher\HostRequestMatcher('admin.6thmen.com'))]);
    }
}
