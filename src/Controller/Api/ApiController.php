<?php

namespace App\Controller\Api;

use App\Entity\Library\User;
use App\Exception\Api\NoBearerException;
use App\Exception\Api\UserDoesNotExistException;
use App\Security\Api\JWTAuth;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    public function __construct
    (
        private JWTAuth $JWTAuth,
    )
    {}
    protected function tryToConnecUser(Request $request): User
    {
        try {
            return $this->JWTAuth->getUserFromRequest($request);
        } catch (NoBearerException $bearerException) {
            throw new \Exception($bearerException->getMessage(), 401);
        } catch (UserDoesNotExistException $userException) {
            throw new \Exception($userException->getMessage(), 403);
        }
    }

}