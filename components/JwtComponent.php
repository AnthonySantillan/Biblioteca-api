<?php
namespace components;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtComponent
{
    private $key = 'clave-secreta';

    public function generateToken($userId)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 1800;

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'uid' => $userId,
        ];

        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }
}
