<?php

namespace App\Http\Controllers;

use App\Services\Google\GoogleClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthLoginGoogleController extends Controller
{
    /**
     * Initializes the class with a google client service instance.
     * 
     * @param GoogleClientService $googleClientService
     */
    public function __construct(public GoogleClientService $googleClientService) {}

    public function getGoogleAuthUtl(): JsonResponse
    {
        $authUrl = $this->googleClientService->generateGoogleAuthUtl();

        return response()->json([
            'success'  => true,
            'auth_url' => $authUrl
        ], 200);

    }

    /**
     * Process returns callbacl from google
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function getGoogleAuthCallback(Request $request): JsonResponse|RedirectResponse
    {

        $googleToken = $request->only('code', 'credential');

        if ( empty($googleToken['code']) && empty($googleToken['credential']) ) {
            return response()->json([
                'success' => false,
                'message' => 'Google Access code is required',
            ], 400);
        }

        return $this->googleClientService->handlerAuthenticate(googleToken: $googleToken);
    }

}

