<?php
require_once '../config/database.php';

class Chat {
    private $conn;
    private $chats_table = "chats";
    private $messages_table = "messages";

    public $id;
    public $user_id;
    public $title;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->chats_table . " SET user_id=:user_id, title=:title";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":title", $this->title);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function getUserChats($user_id) {
        $query = "SELECT id, title, created_at, updated_at FROM " . $this->chats_table . " WHERE user_id = :user_id ORDER BY updated_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($chat_id, $user_id) {
        $query = "DELETE FROM " . $this->chats_table . " WHERE id = :chat_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chat_id', $chat_id);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    public function rename($chat_id, $user_id, $new_title) {
        $query = "UPDATE " . $this->chats_table . " SET title = :title WHERE id = :chat_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $new_title);
        $stmt->bindParam(':chat_id', $chat_id);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    public function addMessage($chat_id, $message, $sender) {
        $query = "INSERT INTO " . $this->messages_table . " SET chat_id=:chat_id, message=:message, sender=:sender";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chat_id', $chat_id);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':sender', $sender);
        return $stmt->execute();
    }

    public function getMessages($chat_id, $user_id) {
        // Verify chat belongs to user
        $verify_query = "SELECT id FROM " . $this->chats_table . " WHERE id = :chat_id AND user_id = :user_id";
        $verify_stmt = $this->conn->prepare($verify_query);
        $verify_stmt->bindParam(':chat_id', $chat_id);
        $verify_stmt->bindParam(':user_id', $user_id);
        $verify_stmt->execute();
        
        if($verify_stmt->rowCount() == 0) {
            return false;
        }

        $query = "SELECT message, sender, created_at FROM " . $this->messages_table . " WHERE chat_id = :chat_id ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chat_id', $chat_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
