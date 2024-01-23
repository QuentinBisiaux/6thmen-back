<?php

namespace App\Domain\Auth;

use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Exception\NoBearerException;
use App\Domain\Auth\Exception\UserDoesNotExistException;
use App\Domain\Auth\Repository\UserRepository;
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

    public function getUserFromRequest(Request $request): User
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