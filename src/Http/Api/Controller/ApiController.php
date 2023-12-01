<?php

namespace App\Http\Api\Controller;

use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Exception\NoBearerException;
use App\Domain\Auth\Exception\UserDoesNotExistException;
use App\Domain\Auth\JWTAuth;
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