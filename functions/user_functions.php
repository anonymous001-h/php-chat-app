<?php
require_once '../config/database.php';

function registerUser($username, $email, $password) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    try {
        // Clean input data
        $username = htmlspecialchars(strip_tags($username));
        $email = htmlspecialchars(strip_tags($email));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users SET username=:username, email=:email, password=:password";
        $stmt = $conn->prepare($query);
        
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        
        if($stmt->execute()) {
            return ['success' => true, 'message' => 'Registration successful'];
        } else {
            error_log("Registration failed - execute returned false");
            return ['success' => false, 'message' => 'Registration failed'];
        }
    } catch (PDOException $e) {
        error_log("Registration PDO Error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error during registration: ' . $e->getMessage()];
    }
}

function loginUser($email, $password) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    try {
        $query = "SELECT id, username, email, password FROM users WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row && password_verify($password, $row['password'])) {
            return [
                'success' => true, 
                'message' => 'Login successful',
                'user_id' => $row['id'],
                'username' => $row['username'],
                'email' => $row['email']
            ];
        }
        return ['success' => false, 'message' => 'Invalid email or password'];
    } catch (PDOException $e) {
        error_log("Login PDO Error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error during login'];
    }
}

function emailExists($email) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return false;
    }
    
    try {
        $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Email check error: " . $e->getMessage());
        return false;
    }
}

function usernameExists($username) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return false;
    }
    
    try {
        $query = "SELECT id FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Username check error: " . $e->getMessage());
        return false;
    }
}

function getUserInfo($user_id) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    try {
        $query = "SELECT id, username, email FROM users WHERE id = :user_id LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            return [
                'success' => true,
                'user' => [
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'email' => $row['email']
                ]
            ];
        }
        return ['success' => false, 'message' => 'User not found'];
    } catch (PDOException $e) {
        error_log("Get user info error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error'];
    }
}
?>
