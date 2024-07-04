<?php

namespace App\Services\Register;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterService
{
    use ApiResponseTrait;

/********************************************************************************************/

    public function register($request)
    {
        DB::beginTransaction();
        try{
            $requestData = $request->validated();

            $user = User::create($requestData);

            DB::commit();

            $accessToken = $this->createAccessToken($user);

            return  $accessToken;

        }catch(Throwable $exception)
        {
            DB::rollback();
            return $this->handleError($exception);
        }

    }

    /********************************************************************************************/
    public function createAccessToken($user)
    {
        $accessToken = $user->createToken('#$_auth_token_@#',
        ['expires_in' => config('sanctum.expiration')])->plainTextToken;
        return $accessToken;
    }

    /********************************************************************************************/

    protected function handleError(Throwable $exception)
    {
        $message = $exception->getMessage();
        return $this->apiError(message:$message, code:500);
    }

}

