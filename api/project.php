<?php
require_once 'db.php';
require_once 'auth/middleware.php';

header('Content-Type: application/json');

class project extends db {

    // Get all project
    public function getAllProject(){
        $user_id = isAuthenticated();
        
        $query = "SELECT * FROM projects";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($projects);
    }
    
    // Add new project
    public function addNewProject(){
        $user_id = isAuthenticated();
        
        $data = json_decode(file_get_contents("php://input"));
    
        // Check if all required fields are provided
        if (!empty($data->name) && !empty($data->description)) {
            $query = "INSERT INTO projects (name, description) VALUES (:name, :description)";
            $stmt = $this->db->prepare($query);
    
            $stmt->bindParam(":name", $data->name);
            $stmt->bindParam(":description", $data->description);
    
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Project created successfully']);
            } else {
                echo json_encode(['message' => 'Project could not be created']);
            }
        } else {
            echo json_encode(['message' => 'All fields are required']);
        }
    }
    
    // Update a project
    public function updateProject(){
        $user_id = isAuthenticated();
        
        $data = json_decode(file_get_contents("php://input"));
    
        // Check if all required fields are provided
        if (isset($data->project_id) && !empty($data->project_id) &&
            isset($data->name) && !empty($data->name) &&
            isset($data->description) && !empty($data->description)) {
            
            $query = "UPDATE projects SET name = :name, description = :description WHERE id = :project_id";
            $stmt = $this->db->prepare($query);
    
            $stmt->bindParam(":name", $data->name);
            $stmt->bindParam(":description", $data->description);
            $stmt->bindParam(":project_id", $data->project_id);
    
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Project updated successfully']);
            } else {
                echo json_encode(['message' => 'Failed to update project']);
            }
        } else {
            echo json_encode(['message' => 'All fields are required']);
        }
    }
    
    // Delete a project
    public function deleteProject(){
        $user_id = isAuthenticated();
        
        $data = json_decode(file_get_contents("php://input"));
    
        // Check if the ID is provided
        if (isset($data->project_id) && !empty($data->project_id)) {
            $query = "DELETE FROM projects WHERE id = :project_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":project_id", $data->project_id);
            
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Project deleted successfully']);
            } else {
                echo json_encode(['message' => 'Failed to delete project']);
            }
        } else {
            echo json_encode(['message' => 'Project ID is required']);
        }
    }
}

?>
