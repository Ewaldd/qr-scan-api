<?php

namespace App\Services;

use App\Exceptions\WrongLoginDataException;
use App\Models\User;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    public function createUser(array $data): User
    {
        $user = User::query()->create($data);

        $user->accessToken = self::generateUserToken($user);

        return $user;
    }

    private static function generateUserToken(User $user): string
    {
        return $user->createToken(config('app.name'))->plainTextToken;
    }

    /**
     * @throws WrongLoginDataException
     */
    public function checkCredentials(array $data): User
    {
        if (auth()->attempt($data)) {
            /** @var User $user */
            $user = auth()->user();
            $user->accessToken = self::generateUserToken($user);

            return $user;
        } else {
            throw new WrongLoginDataException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
    }
}
