<?php

namespace App\Security\Admin;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AdminAccessDeniedHandler implements AccessDeniedHandlerInterface
{

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {}

    public function handle(Request $request, AccessDeniedException $accessDeniedException): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('admin_login'));
    }
}