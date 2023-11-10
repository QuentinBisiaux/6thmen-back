<?php

namespace App\Controller\Api;

use App\Entity\Library\User;
use App\Exception\Api\NoBearerException;
use App\Exception\Api\UserDoesNotExistException;
use App\Security\Api\JWTAuth;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ApiController extends AbstractController
{
    public function __construct
    (
        private JWTAuth $JWTAuth,
    )
    {}
    protected function tryToConnectUser(Request $request): User
    {
        try {
            return $this->JWTAuth->getUserFromRequest($request);
        } catch (NoBearerException $bearerException) {
            throw new \Exception($bearerException->getMessage(), Response::HTTP_UNAUTHORIZED );
        } catch (UserDoesNotExistException $userException) {
            throw new \Exception($userException->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (\Exception $e) {
            throw new AccessDeniedException($e->getMessage());
        }
    }

}