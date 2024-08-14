<?php
require_once 'db.php';
require_once 'auth/middleware.php';

header('Content-Type: application/json');

class task extends db {

    // Get all task
    public function getAllTask(){
        $user_id = isAuthenticated();

        $query = "SELECT tasks.*, projects.name AS project_name 
                FROM tasks 
                LEFT JOIN projects ON tasks.project_id = projects.id 
                WHERE tasks.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($tasks);
    }

    // Add new task
    public function addNewTask(){
        $user_id = isAuthenticated();
        
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->title) && !empty($data->project_id)) {
            $query = "INSERT INTO tasks (project_id, user_id, title, description, due_date) 
                    VALUES (:project_id, :user_id, :title, :description, :due_date)";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(":project_id", $data->project_id);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":title", $data->title);
            $stmt->bindParam(":description", $data->description);
            $stmt->bindParam(":due_date", $data->due_date);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Task created successfully']);
            } else {
                echo json_encode(['message' => 'Task could not be created']);
            }
        } else {
            echo json_encode(['message' => 'Incomplete data']);
        }
    }

    // Update task
    public function updateTask() {
        $user_id = isAuthenticated();
        
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->title)) {
            $query = "UPDATE tasks 
                      SET title = :title, description = :description, due_date = :due_date 
                      WHERE id = :task_id AND user_id = :user_id";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(":title", $data->title);
            $stmt->bindParam(":description", $data->description);
            $stmt->bindParam(":due_date", $data->due_date);
            $stmt->bindParam(":task_id", $data->task_id);
            $stmt->bindParam(":user_id", $user_id);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Task updated successfully']);
            } else {
                echo json_encode(['message' => 'Task could not be updated']);
            }
        } else {
            echo json_encode(['message' => 'Incomplete data']);
        }
    }

    // Delete task
    public function deleteTask() {
        $user_id = isAuthenticated();

        $data = json_decode(file_get_contents("php://input"));
        
        $query = "DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(":task_id", $data->task_id);
        $stmt->bindParam(":user_id", $user_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Task deleted successfully']);
        } else {
            echo json_encode(['message' => 'Task could not be deleted']);
        }
    }
}

?>
