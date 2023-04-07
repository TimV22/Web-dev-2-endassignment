<?php

namespace Controllers;

use Config\JWTConfig;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Controller
{
    protected function checkForJwt(): ?object
    {
        // Check for token header
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $this->respondWithError(401, "No token provided");
        }

        // Read JWT from header
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        // Strip the part "Bearer " from the header
        $arr = explode(" ", $authHeader);
        $jwt = $arr[1];

        // Decode JWT
        require_once __DIR__ . '/../Config/JWTConfig.php';
        $secretKey = JWTConfig::JWTSECTETKEY;

        if ($jwt) {
            try {
                return JWT::decode($jwt, new Key($secretKey, 'HS256'));
            } catch (Exception $e) {
                $this->respondWithError(401, $e->getMessage());
            }
        }
        $this->respondWithError(401, "No valid token provided");
        return null;
    }

    protected function respond($data): void
    {
        $this->respondWithCode(200, $data);
    }

    protected function respondWithError($httpCode, $message): void
    {
        $data = array('errorMessage' => $message);
        $this->respondWithCode($httpCode, $data);
    }

    private function respondWithCode($httpCode, $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpCode);
        echo json_encode($data);
        exit();
    }

    protected function createObjectFromPostedJson($className): ?object
    {
        try {

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $object = new $className();
            foreach ($data as $key => $value) {
                if (is_object($value) || !property_exists(new $className, $key)) {
                    continue;
                }
                $object->{$key} = $value;
            }
            return $object;
        } catch (Exception) {
            $this->respondWithError(400, "Cannot create object from posted json");
            return null;
        }
    }
}
