<?php

namespace App\Controller\Api;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Entity\Library\User;
use App\Entity\Library\UserProfile;
use App\Service\EncryptionService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/api/login')]
class SecurityController extends AbstractController
{

    public function __construct
    (
        private EntityManagerInterface $entityManager,
        private EncryptionService $encryptionService,
        private string $consumerKey,
        private string $consumerSecret
    )
    {}

    #[Route('/twitter', name: 'login_twitter', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function twitterLogin(HttpClientInterface $httpClient): JsonResponse
    {
        $connection = new TwitterOAuth(
            $this->consumerKey,
            $this->consumerSecret,
        );
/*        $connection = new TwitterOAuth(
            'amtPWHZkZWVnSWV0bnc0SE5aclY6MTpjaQ',
            'bIMWYg2gkWth9M6thfM_I3Y5Jve3yNfBeI_bCYlvQkUS8jPzo6'
        );*/
        $content = $connection->oauth('oauth/request_token', []);
        return $this->json(['authUrl' => 'https://api.twitter.com/oauth/authorize?oauth_token=' . $content['oauth_token']]);
    }


    #[Route('/twitter/callback', name: 'login_twitter_callback', methods: ['POST'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function twitterCallback(Request $request, AuthenticationSuccessHandler $authenticationSuccessHandler): Response
    {
        $content = $request->getContent();
        $data = json_decode($content, true);

        $oauthToken = $data['oauth_token'] ?? null;
        $oauthVerifier = $data['oauth_verifier'] ?? null;

        if (!$oauthToken || !$oauthVerifier) {
            return  $this->json(['error' => 'Invalid request body'], 400);
        }

        // Exchange the OAuth token and verifier for an access token
        $tokens = $this->exchangeAccessToken($oauthToken, $oauthVerifier);

        // Retrieve the user's data from Twitter using the access token
        $userData = $this->getUserData($tokens);

        // Save the user's data to your database or session
        $user = $this->manageUserData($userData);

        // Generate an authentication token for the user
        return $authenticationSuccessHandler->handleAuthenticationSuccess($user);
    }

    private function exchangeAccessToken(string $oauthToken, string $oauthVerifier): array
    {
        $connection = new TwitterOAuth(
            'pVxqp6s1JU1piXSH8HFvYgFIQ',
            'TPHhOWpHNr5fkxY0IShujhKrUIqGOlirNmtHreWMMGnQCeFVCR'
        );
        try {
            return $connection->oauth('oauth/access_token', ["oauth_token" => $oauthToken, "oauth_verifier" => $oauthVerifier]);
        } catch (\Exception $exception) {
            dump($exception);
        }
        return [];
    }

    private function getUserData(array $tokens): \stdClass
    {
        $connection = new TwitterOAuth(
            'pVxqp6s1JU1piXSH8HFvYgFIQ',
            'TPHhOWpHNr5fkxY0IShujhKrUIqGOlirNmtHreWMMGnQCeFVCR',
            $tokens['oauth_token'],
            $tokens['oauth_token_secret']
        );
        return $connection->get('account/verify_credentials');
    }

    private function manageUserData(\stdClass $userData): User
    {
        $user = $this->createOrFindUser($userData->id_str);
        $userProfile = $user->getProfile();
        if (is_null($userProfile)) {
            $userProfile = new UserProfile();
        }
        $userProfile->setUsername($userData->screen_name);
        $userProfile->setName($userData->name);
        $userProfile->setLocation($userData->location);
        $userProfile->setProfileImageUrl($userData->profile_image_url_https);
        $userDataArray = json_decode(json_encode($userData), true);
        $userProfile->setRawData($userDataArray, $this->encryptionService);
        $userProfile->setUser($user);
        $userProfile->setCreatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($userProfile);

        $user->setProfile($userProfile);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    private function createOrFindUser(string $idStr): ?User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneByTwitterId($this->encryptionService->deterministicEncrypt($idStr));
        if ($user instanceof User) return $user;
        $newUser = new User();
        $newUser->setTwitterId($this->encryptionService->deterministicEncrypt($idStr));
        $newUser->setCreatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($newUser);
        $this->entityManager->flush();
        return $newUser;
    }
/* FOR FUTURE DEVELOPMENT
    #[Route('/register', name: 'api_register_plain', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $requiredFields = ['email', 'username', 'password', 'verifyPassword'];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errorRequiredEmpty[] = sprintf('Il manque le champs : %s', $field);
            }
        }
        if(!empty($errorRequiredEmpty)) {
            return $this->json(
                [
                    'errors' => $errorRequiredEmpty,
                    'request'=> $request,
                    'data'   => $data
                ]
                , Response::HTTP_BAD_REQUEST);
        }

        if ($data['password'] !== $data['verifyPassword']) {
            return $this->json(['errors' => 'Le mot de passe et sa confirmation ne correspondent pas'], Response::HTTP_BAD_REQUEST);
        }

        if(!$this->userRepository->findOneByUsername($data['username']))
        {
            return $this->json(['errors' => 'Username existe déjà'], Response::HTTP_BAD_REQUEST);
        }
        if(!$this->userRepository->findOneByEmail($data['email']))
        {
            return $this->json(['errors' => 'L\'email existe déjà'], Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);

        $encodedPassword = $this->hasher->hashPassword($user, $data['password']);
        $user->setPassword($encodedPassword);

        $this->userRepository->save($user, true);

        $token = $this->jwtManager->create($user);

        return $this->json(['user' => $user, 'token' => $token], Response::HTTP_CREATED, [], ['groups' => 'read:user']);
    }


    #[Route('/login', name: 'api_login_plain', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $requiredFields = ['emailOrUsername', 'password'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return new Response(sprintf('Missing or empty field: %s', $field), Response::HTTP_BAD_REQUEST);
            }
        }

        $user = $this->userRepository->findOneBy([
            'email' => $data['emailOrUsername'],
        ]);
        if(!$user) {
            $user = $this->userRepository->findOneBy([
                'username' => $data['emailOrUsername'],
            ]);
        }

        if (!$user || !$this->hasher->isPasswordValid($user, $data['password'])) {
            // Invalid credentials, return an error response
            return new Response('Invalid email/username or password', Response::HTTP_UNAUTHORIZED);
        }

        // Generate a JWT token
        $token = $this->jwtManager->create($user);

        // Return the token as a response
        return new Response(['token' => $token]);
    }
*/
}