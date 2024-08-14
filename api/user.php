<?php
require_once 'db.php';
require_once 'auth/middleware.php';

header('Content-Type: application/json');

class user extends db {

    // Get user details
    public function getUserDetails(){
        $user_id = isAuthenticated();
        
        $query = "SELECT id, username, email, avatar FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $user_id);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo json_encode($user);
        } else {
            echo json_encode(['message' => 'User not found']);
        }
    }

    // Update user details
    public function updateUser() {
        $user_id = isAuthenticated();

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            $upload_dir = 'avatars/';
            $file_name = basename($_FILES['avatar']['name']);
            $target_file = $upload_dir . $file_name;
    
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
                $avatar_path = $target_file;
            } else {
                echo json_encode(['message' => 'File upload failed']);
                exit();
            }
        } else {
            echo json_encode(['message' => 'No file uploaded']);
            exit();
        }
    
        $username = $_POST['username'];
        $email = $_POST['email'];
    
        // Update user data in the database
        $query = "UPDATE users SET username = :username, email = :email, avatar = :avatar WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':avatar', $avatar_path);
        $stmt->bindParam(':id', $user_id);
    
        if ($stmt->execute()) {
            echo json_encode(['message' => 'User updated successfully']);
        } else {
            echo json_encode(['message' => 'User could not be updated']);
        }
    }    

    // Delete user
    public function deleteUser() {
        $user_id = isAuthenticated();
    
        // Retrieve the avatar path from the database
        $query = "SELECT avatar FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Check if user exists and get the avatar path
        if ($user) {
            $avatarPath = $user['avatar'];
    
            // Delete the user record from the database
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $user_id);
    
            if ($stmt->execute()) {
                // If user was successfully deleted, remove the avatar file if it exists
                if (!empty($avatarPath) && file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
                echo json_encode(['message' => 'User deleted successfully']);
            } else {
                echo json_encode(['message' => 'Failed to delete user']);
            }
        } else {
            echo json_encode(['message' => 'User not found']);
        }
    }    
}

?>
