<?php
require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;

class token {
    private static $secret_key = "27D02";
    private static $algorithm = "HS256";

    public static function generateToken($user_id) {
        $payload = [
            'iss' => "localhost", 
            'sub' => $user_id,   
            'iat' => time(),      
            'exp' => time() + (60 * 60)
        ];

        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    public static function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new \Firebase\JWT\Key(self::$secret_key, self::$algorithm));
            return $decoded->sub;
        } catch (Exception $e) {
            echo "Token validation error: " . $e->getMessage();
            return false;
        }
    }
}
