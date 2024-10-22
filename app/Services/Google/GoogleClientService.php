<?php

namespace App\Services\Google;

use App\Services\Contracts\IGoogleClientService;
use Google\Client;
use App\Services\Google\GoogleAuthConfService;
use App\Services\Google\GoogleOAuth2Service;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class GoogleClientService implements IGoogleClientService
{
    /**
     * Google client
     * 
     * @var Client $googleClient
     */
    protected $googleClient;

    /**
     * User data
     * 
     * @var array $userData
     */
    protected array $userData;

    /**
     * Access token
     * 
     * @var string $token
     */
    protected string $token;

    /**
     * User already registrate
     * 
     * @var bool $alreadyRegistrate
     */
    protected bool $alreadyRegistered;

    /**
     * Constructor to initialize the Google Client
     *
     * @param GoogleAuthConfService $client
     */
    public function __construct(
        private GoogleAuthConfService $client,
        protected UserService $userService,
        protected GoogleOAuth2Service $oauth2client
    ) {
        $this->googleClient = $this->client->setupGoogleClient();
    }

    /**
     * Generate Google OAuth 2.0 authorization URL
     * 
     * @return string
     */
    public function generateGoogleAuthUtl(): string
    {

        try {

            return $this->googleClient->createAuthUrl();

        } catch ( \Exception $e ) {

            return $this->handleAuthenticationError($e);
        }
    }

    /**
     * Handles the google authentication process
     * 
     
     */
    public function handlerAuthenticate(array $googleToken)
    {
        try {

            if ( !empty($googleToken['code']) ) {
                $code = $googleToken['code'];

                $this->userData = $this->getUserGoogleDataOauht2(googleToken: $code);
                $this->token    = $this->userData['access_token'];

            } else {
                $credential = $googleToken['credential'];

                $this->userData = $this->getUserGoogleData(googleToken: $credential);
                $this->token    = $credential;

            }

            return $this->checkUser();

        } catch ( \Exception $e ) {
            return $this->handleAuthenticationError($e);
        }
    }

    /**
     * Check if the user already has registered
     * 
     * @return RedirectResponse
     */
    public function checkUser(): RedirectResponse
    {
        $user = $this->userService->findUserByEmail($this->userData['email']);

        if ( !$user || !isset($user->registration_finished) ) {
            $this->userService->updateOrCreateUser(userData: $this->userData, token: $this->token);
        }

        $alreadyRegistrate = isset($user->registration_finished);

        return $this->redirectToFront(token: $this->token, alreadyRegistrate: $alreadyRegistrate);
    }

    /**
     * Collects user data from google 
     * This token is provided when authentication is done via the front-end SDK
     * 
     * @param string $googleToken
     * @throws \Exception
     * @return array|\Exception
     */
    private function getUserGoogleData(string $googleToken): array
    {

        $googleUserData = $this->googleClient->verifyIdToken($googleToken);

        if ( !$googleUserData ) {
            throw new \Exception('Invalid google access code');
        }

        return $googleUserData;
    }

    /**
     * Collects user data from google 
     * This token is provided when the authentication URL is generated
     * via Api
     * 
     * @param string $googleToken
     * @return array|JsonResponse
     */
    public function getUserGoogleDataOauht2(string $googleToken): array|JsonResponse
    {
        try {

            return $this->oauth2client->getUserOAuth2($googleToken);

        } catch ( \Exception $e ) {
            return $this->handleAuthenticationError($e);
        }
    }

    /**
     * Redirects the user to the front-end app
     * 
     * @param string $googleToken
     * @return RedirectResponse
     */
    private function redirectToFront(string $token, bool $alreadyRegistrate): RedirectResponse
    {

        $frontUrl   = config('services.front.url');
        $redirectTo = $alreadyRegistrate ? "$frontUrl/dashboard" : "$frontUrl?token=$token";

        return redirect()->away($redirectTo);
    }

    /**
     * Handles authentication error
     * 
     * @param \Exception $e
     * @return JsonResponse
     */
    private function handleAuthenticationError(\Exception $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Authentication error occurred',
            'error'   => $e->getMessage(),
            'line'    => $e->getLine(),
        ], 400);
    }

}

