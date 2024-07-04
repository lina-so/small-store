<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Services\login\LoginService;
use App\Http\Requests\Login\LoginRequest;
use App\Services\Register\RegisterService;
use App\Http\Requests\Register\RegisterRequest;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public  $registerService,$loginService;

    public function __construct(RegisterService $registerService,LoginService $loginService)
    {
        $this->registerService = $registerService;
        $this->loginService = $loginService;
    }
    /*--------------------- signUp----------------------------*/
    /************************************************************************/
    public function signUp(RegisterRequest $request)
    {
        $data = $this->registerService->register($request);
        return $this->apiSuccess('Registration successful',$data, 201);

    }
    /*-----------------------login------------------*/
    public function login(LoginRequest $request)
    {
        $data = $this->loginService->login($request);
        return $data;
    }
}
