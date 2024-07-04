<?php

namespace App\Services\login;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService
{
    use ApiResponseTrait;

    /********************************************************************************************/

    public function login($request)
    {
        $requestData = $request->validated();
        $user = $this->findUserByEmail($requestData);
        $auth_user = $this->authUser($user);
        $accessToken = $this->createAccessToken($auth_user);

        return $this->apiSuccess('access_token',$accessToken, 200);
    }

    /********************************************************************************************/
    public function findUserByEmail($requestData)
    {
        $user = User::where('email',$requestData['email'])->first();
        return $user;
    }

    /********************************************************************************************/
    public function authUser($user)
    {
        Auth::login($user);
        $authUser = Auth::user();
        return $authUser;
    }
    /********************************************************************************************/
    public function createAccessToken($user)
    {
        $accessToken = $user->createToken('#$_my_app_token_@#', ['expires_in' => config('sanctum.expiration')])->plainTextToken;
        return $accessToken;
    }
}

