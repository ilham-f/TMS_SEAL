<?php

require_once 'vendor/autoload.php';
require_once 'api/auth.php';
require_once 'api/project.php';
require_once 'api/task.php';
require_once 'api/user.php';

// Create instances of the classes
$auth = new auth();
$project = new project();
$task = new task();
$user = new user();

$url = ($_SERVER['REQUEST_URI']);
$method = $_SERVER['REQUEST_METHOD'];

// Basic routing logic
switch ($url) {

    // Auth URLs
    case '/login':
        if ($method === 'POST') {
            $auth->login();
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;

    case '/register':
        if ($method === 'PUT') {
            // echo json_encode(['message' => 'Test endpoint reached']);
            $auth->register();
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;

    // Project URLs
    case '/projects':
        if ($method === 'GET') {
            $project->getAllProject();
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;

    case '/project':
        if ($method === 'POST') {
            $project->addNewProject();
        } elseif ($method === 'PUT') {
            $project->updateProject();
        } elseif ($method === 'DELETE') {
            $project->deleteProject();
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;

    // Task URLs
    case '/tasks':
        if ($method === 'GET') {
            $task->getAllTask();
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;

    case '/task':
        if ($method === 'POST') {
            $task->addNewTask();
        } elseif ($method === 'PUT') {
            $task->updateTask();
        } elseif ($method === 'DELETE') {
            $task->deleteTask();
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;

    // User URLs
    case '/userdetails':
        if ($method === 'GET') {
            $user->getUserDetails();
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;

    case '/user':
        if ($method === 'POST') {
            $user->updateUser();
        } elseif ($method === 'DELETE') {
            $user->deleteUser();
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;

    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['message' => 'Endpoint not found']);
        break;
}

?>
