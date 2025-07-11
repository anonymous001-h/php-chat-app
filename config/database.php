<?php
function getDatabaseConnection() {
    $host = 'localhost';
    $db_name = 'chat_app';
    $username = 'root';
    $password = '';
    
    try {
        $dsn = "mysql:host=" . $host . ";dbname=" . $db_name . ";charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $conn = new PDO($dsn, $username, $password, $options);
        
        // Test the connection
        $conn->query('SELECT 1');
        
        return $conn;
        
    } catch(PDOException $exception) {
        error_log("Database Connection Error: " . $exception->getMessage());
        return false;
    }
}
?>
