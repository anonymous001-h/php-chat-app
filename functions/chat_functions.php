<?php
require_once '../config/database.php';

function createChat($user_id, $title = 'New Chat') {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    try {
        $query = "INSERT INTO chats SET user_id=:user_id, title=:title";
        $stmt = $conn->prepare($query);
        
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":title", $title);
        
        if($stmt->execute()) {
            return ['success' => true, 'chat_id' => $conn->lastInsertId(), 'message' => 'Chat created successfully'];
        }
        return ['success' => false, 'message' => 'Failed to create chat'];
    } catch (PDOException $e) {
        error_log("Create chat error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error'];
    }
}

function getUserChats($user_id) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    try {
        $query = "SELECT id, title, created_at, updated_at FROM chats WHERE user_id = :user_id ORDER BY updated_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        $chats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ['success' => true, 'chats' => $chats];
    } catch (PDOException $e) {
        error_log("Get chats error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error'];
    }
}

function deleteChat($chat_id, $user_id) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    try {
        $query = "DELETE FROM chats WHERE id = :chat_id AND user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':chat_id', $chat_id);
        $stmt->bindParam(':user_id', $user_id);
        
        if($stmt->execute()) {
            return ['success' => true, 'message' => 'Chat deleted successfully'];
        }
        return ['success' => false, 'message' => 'Failed to delete chat'];
    } catch (PDOException $e) {
        error_log("Delete chat error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error'];
    }
}

function renameChat($chat_id, $user_id, $new_title) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    try {
        $query = "UPDATE chats SET title = :title WHERE id = :chat_id AND user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':title', $new_title);
        $stmt->bindParam(':chat_id', $chat_id);
        $stmt->bindParam(':user_id', $user_id);
        
        if($stmt->execute()) {
            return ['success' => true, 'message' => 'Chat renamed successfully'];
        }
        return ['success' => false, 'message' => 'Failed to rename chat'];
    } catch (PDOException $e) {
        error_log("Rename chat error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error'];
    }
}

function addMessage($chat_id, $message, $sender) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    try {
        $query = "INSERT INTO messages SET chat_id=:chat_id, message=:message, sender=:sender";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':chat_id', $chat_id);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':sender', $sender);
        
        if($stmt->execute()) {
            return ['success' => true, 'message' => 'Message added successfully'];
        }
        return ['success' => false, 'message' => 'Failed to add message'];
    } catch (PDOException $e) {
        error_log("Add message error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error'];
    }
}

function getChatMessages($chat_id, $user_id) {
    $conn = getDatabaseConnection();
    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed'];
    }
    
    try {
        // Verify chat belongs to user
        $verify_query = "SELECT id FROM chats WHERE id = :chat_id AND user_id = :user_id";
        $verify_stmt = $conn->prepare($verify_query);
        $verify_stmt->bindParam(':chat_id', $chat_id);
        $verify_stmt->bindParam(':user_id', $user_id);
        $verify_stmt->execute();
        
        if($verify_stmt->rowCount() == 0) {
            return ['success' => false, 'message' => 'Unauthorized access'];
        }

        $query = "SELECT message, sender, created_at FROM messages WHERE chat_id = :chat_id ORDER BY created_at ASC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':chat_id', $chat_id);
        $stmt->execute();
        
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ['success' => true, 'messages' => $messages];
    } catch (PDOException $e) {
        error_log("Get messages error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error'];
    }
}
?>
