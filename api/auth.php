<?php
// Add debugging at the top
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

session_start();
header('Content-Type: application/json');

require_once '../functions/user_functions.php';

// Debug: Log all received data
error_log("POST data: " . print_r($_POST, true));
error_log("Request method: " . $_SERVER['REQUEST_METHOD']);

$action = $_POST['action'] ?? '';

// Debug: Log the action
error_log("Action received: " . $action);

switch($action) {
    case 'login':
        $email = $_POST['loginEmail'] ?? $_POST['email'] ?? '';
        $password = $_POST['loginPassword'] ?? $_POST['password'] ?? '';

        // Debug: Log email and password (remove password logging in production)
        error_log("Login attempt - Email: " . $email . ", Password length: " . strlen($password));

        if(empty($email) || empty($password)) {
            error_log("Empty email or password - Email: '$email', Password: '$password'");
            echo json_encode(['success' => false, 'message' => 'Email and password are required']);
            exit;
        }

        $result = loginUser($email, $password);
        if($result['success']) {
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['email'] = $email; // Store email in session
            
            // Include email in response
            $result['email'] = $email;
        }
        echo json_encode($result);
        break;

    case 'register':
        $username = $_POST['signupName'] ?? $_POST['username'] ?? '';
        $email = $_POST['signupEmail'] ?? $_POST['email'] ?? '';
        $password = $_POST['signupPassword'] ?? $_POST['password'] ?? '';

        error_log("Registration attempt - Username: " . $username . ", Email: " . $email);

        if(empty($username) || empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            exit;
        }

        if(emailExists($email)) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            exit;
        }

        if(usernameExists($username)) {
            echo json_encode(['success' => false, 'message' => 'Username already exists']);
            exit;
        }

        $result = registerUser($username, $email, $password);
        echo json_encode($result);
        break;

    case 'logout':
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Logout successful']);
        break;

    case 'check_session':
        if(isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => true, 
                'logged_in' => true, 
                'username' => $_SESSION['username'],
                'email' => $_SESSION['email'] ?? $_SESSION['username']
            ]);
        } else {
            echo json_encode(['success' => true, 'logged_in' => false]);
        }
        break;

    default:
        error_log("Invalid action received: " . $action);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>
