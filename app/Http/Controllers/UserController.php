<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Jobs\SendWelcomeEmailJob;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(public UserService $userService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {

        $users = $this->userService->getAllUsers();

        return response()->json([
            'success' => true,
            'users'   => $users,
        ], 200);
    }

    public function show(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        if ( empty($token) ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token',
                'token'   => $token,
            ], 401);
        }

        $user = $this->userService->findUserByToken(token: $token);

        return response()->json([
            'success' => true,
            'user'    => $user,
        ], 200);

    }

    /**
     *  Update the specified resource in storage.
     * @param UserRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UserRequest $request, string $id): JsonResponse
    {
        $userData = $request->validated();

        $user = $this->userService->updateUser(userData: $userData, id: $id);

        SendWelcomeEmailJob::dispatch($user);

        return response()->json([
            'success' => true,
            'user'    => $user,
        ], 200);

    }
}

