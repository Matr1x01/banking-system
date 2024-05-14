<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(public AuthService $authService)
    {
    }
    public function register(RegisterRequest $request)
    {
        $response = $this->authService->register($request->name, $request->email, $request->password, $request->account_type);
        return JsonResponder::respond($response['message'], $response['status'], $response['data']);
    }
    public function login(LoginRequest $request)
    {
        $response = $this->authService->login($request->email, $request->password);
        return JsonResponder::respond($response['message'], $response['status'], $response['data']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return JsonResponder::respond('User logged out successfully', Response::HTTP_OK);
    }
}
