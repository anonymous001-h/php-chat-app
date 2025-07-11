<?php
require_once '../config/database.php';

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        try {
            $query = "INSERT INTO " . $this->table_name . " SET username=:username, email=:email, password=:password";
            $stmt = $this->conn->prepare($query);

            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);

            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);

            if($stmt->execute()) {
                return true;
            } else {
                error_log("Registration failed - execute returned false");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Registration PDO Error: " . $e->getMessage());
            throw new Exception("Database error during registration: " . $e->getMessage());
        }
    }

    public function login() {
        $query = "SELECT id, username, email, password FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row && password_verify($this->password, $row['password'])) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            return true;
        }
        return false;
    }

    public function emailExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function usernameExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>
