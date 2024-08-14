<?php
require_once 'auth/token.php';

function isAuthenticated() {
    $headers = apache_request_headers();

    if (isset($headers['Authorization'])) {
        $matches = [];
        preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches);

        if (isset($matches[1])) {
            $user_id = token::validateToken($matches[1]);

            if ($user_id) {
                return $user_id;
            }
        }
    }

    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(['message' => 'Unauthorized']);
    exit();
}