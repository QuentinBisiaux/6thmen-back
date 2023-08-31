<?php

namespace App\Security\Api;

use App\Entity\Library\User;
use App\Exception\Api\NoBearerException;
use App\Exception\Api\UserDoesNotExistException;
use App\Repository\Library\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\Request;

class JWTAuth
{

    public function __construct
    (
        private JWTEncoderInterface $JWTEncoder,
        private UserRepository $userRepository
    )
    {}

    public function getUserFromRequest(Request $request): ?User
    {
        $authHeader = $request->headers->get('authorization');
        if(is_null($authHeader)) throw new NoBearerException('Il faut se connecter avec Twitter pour accéder a cette fonctionnalité.');
        $token = str_replace("Bearer ", "", $authHeader);
        $decoded = $this->JWTEncoder->decode($token);
        $user = $this->userRepository->findOneById($decoded['id']);
        if(!$user) throw new UserDoesNotExistException('Il y a une erreur avec la connection, essaie de te déconnecter, reconnecter et recommencer l\'opération');
        return $user;
    }

}