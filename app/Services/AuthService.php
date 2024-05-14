<?php
namespace App\Services;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\AuthJob; 
class AuthService
{
    public function __construct(private AuthJob $authJob)
    {
    }

    public function register($name, $email, $password, $account_type)
    {
        $user = $this->authJob->createUser([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'account_type' => $account_type
        ]);

        if (!$user) {
            return [
                'message' => 'User registration failed',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }

        return [
            'message' => 'User registered successfully',
            'status' => Response::HTTP_CREATED,
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'account_type' => $user->account_type,
                'token' => $user->createToken('auth_token')->plainTextToken
            ]
        ];
    }

    public function login($email, $password)
    {
        $user = $this->authJob->getUserByEmail($email);

        if (!$user || !\Hash::check($password, $user->password)) {
            return [
                'message' => 'Invalid credentials',
                'status' => Response::HTTP_UNAUTHORIZED,
                'data' => []
            ];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'User logged in successfully',
            'status' => Response::HTTP_OK,
            'data' => ['token' => $token]
        ];
    } 
}