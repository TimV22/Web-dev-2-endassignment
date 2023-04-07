<?php

namespace Controllers;

use Config\JWTConfig;
use Firebase\JWT\JWT;
use Services\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function login(): void
    {
        $user = $this->createObjectFromPostedJson('Models\User');
        if ($user) {
            $user = $this->userService->login($user->email, hash('sha256', $user->password));
            if ($user) {
                //respond with JWT Token
                $response = $this->createJWTToken($user);

                $this->respond($response);
            } else {
                $this->respondWithError(401, "Invalid email or password");
            }
        } else {
            $this->respondWithError(400, "Invalid request");
        }
    }

    private function createJWTToken($user): array
    {
        require_once __DIR__ . '/../Config/JWTConfig.php';
        $secretKey = JWTConfig::JWTSECTETKEY;

        $now = strtotime("now");

        $payload = array(
            "iss" => "http://localhost",
            "aud" => "http://localhost",
            "iat" => $now,
            "nbf" => $now,
            "exp" => ($now + 5400),//expires after 1.5 hours
            "data" => array(
                "username" => $user->username,
                "email" => $user->email,
                "id" => $user->id,
                "role" => $user->role,
            )
        );

        $jwt = JWT::encode($payload, $secretKey, "HS256");

        return array(
            "message" => "Successful login.",
            "jwt" => $jwt,
            "username" => $user->username,
            "expiresAt" => ($now + 5400)
        );
    }

    public function register(): void
    {
        $user = $this->createObjectFromPostedJson('Models\User');

        if ($this->userService->userExists($user->email)) {
            $this->respondWithError(401, "User with this email already exists");
        }

        if ($user && $user->password && $user->email && $user->username) {
            $user->password = hash('sha256', $user->password);
            $user->role = 2;
            $user = $this->userService->register($user);
            if ($user) {
                $response = array(
                    "message" => "Successful registration.",
                    "user" => array(
                        "id" => $user->id,
                        "username" => $user->username,
                        "email" => $user->email,
                    )
                );
                $this->respond($response);
            } else {
                $this->respondWithError(401, "Invalid data");
            }
        } else {
            $this->respondWithError(400, "Invalid request");
        }
    }


}
