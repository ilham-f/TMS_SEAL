<?php
require_once 'db.php';
require_once 'auth/token.php';

header('Content-Type: application/json');

class auth extends db {
    
    public function login(){
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->email) && !empty($data->password)) {
            $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $data->email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($data->password, $user['password'])) {
                $token = token::generateToken($user['id']);
                echo json_encode(['message' => 'Login successful', 'token' => $token]);
            } else {
                echo json_encode(['message' => 'Login failed']);
            }
        } else {
            echo json_encode(['message' => 'Incomplete data']);
        }
    }

    public function register() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->username) && !empty($data->email) && !empty($data->password)) {
            $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->db->prepare($query);
        
            $stmt->bindParam(":username", $data->username);
            $stmt->bindParam(":email", $data->email);
            $stmt->bindParam(":password", password_hash($data->password, PASSWORD_BCRYPT));
        
            if ($stmt->execute()) {
                echo json_encode(['message' => 'User registered successfully']);
            } else {
                echo json_encode(['message' => 'User could not be registered']);
            }
        } else {
            echo json_encode(['message' => 'Incomplete data']);
        }
    }

}
?>
