<?php

namespace App\Http\Controllers;

use App\Exceptions\WrongLoginDataException;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        public AuthService $authService = new AuthService()
    )
    {
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = $this->authService->createUser($request->validated());

        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->checkCredentials($request->validated());
            return response()->json(new UserResource($user), Response::HTTP_OK);
        } catch (WrongLoginDataException $exception) {
            return response()
                ->json(
                    $exception->getMessage(), $exception->getCode()
                );
        }
    }
}
