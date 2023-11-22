<?php

namespace App\Security\Api;

use App\Entity\Library\User;
use App\Exception\Api\NoBearerException;
use App\Exception\Api\UserDoesNotExistException;
use App\Repository\Library\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\HttpFoundation\Request;

readonly class JWTAuth
{

    public function __construct
    (
        private JWTEncoderInterface $JWTEncoder,
        private UserRepository      $userRepository
    )
    {}

    public function getUserFromRequest(Request $request): ?User
    {
        $authHeader = $request->headers->get('authorization');
        if(is_null($authHeader)) throw new NoBearerException('Il faut se connecter avec Twitter pour accéder a cette fonctionnalité.');
        $token = str_replace("Bearer ", "", $authHeader);
        try {
            $decoded = $this->JWTEncoder->decode($token);
        } catch(JWTDecodeFailureException $decodeFailureException) {
            throw new \Exception ('Pour ta sécurité, il faut se reconnecter', 500);
        }
        $user = $this->userRepository->findOneById($decoded['id']);
        if(!$user) throw new UserDoesNotExistException('Il y a une erreur avec la connection, essaie de te déconnecter, reconnecter et recommencer l\'opération');
        return $user;
    }

}