<?php
session_start();
header('Content-Type: application/json');

require_once '../functions/chat_functions.php';

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action) {
    case 'create':
        $title = $_POST['title'] ?? 'New Chat';
        $result = createChat($_SESSION['user_id'], $title);
        echo json_encode($result);
        break;

    case 'get_chats':
        $result = getUserChats($_SESSION['user_id']);
        echo json_encode($result);
        break;

    case 'delete':
        $chat_id = $_POST['chat_id'] ?? '';
        if(empty($chat_id)) {
            echo json_encode(['success' => false, 'message' => 'Chat ID is required']);
            exit;
        }

        $result = deleteChat($chat_id, $_SESSION['user_id']);
        echo json_encode($result);
        break;

    case 'rename':
        $chat_id = $_POST['chat_id'] ?? '';
        $new_title = $_POST['new_title'] ?? '';
        
        if(empty($chat_id) || empty($new_title)) {
            echo json_encode(['success' => false, 'message' => 'Chat ID and new title are required']);
            exit;
        }

        $result = renameChat($chat_id, $_SESSION['user_id'], $new_title);
        echo json_encode($result);
        break;

    case 'add_message':
        $chat_id = $_POST['chat_id'] ?? '';
        $message = $_POST['message'] ?? '';
        $sender = $_POST['sender'] ?? 'user';

        if(empty($chat_id) || empty($message)) {
            echo json_encode(['success' => false, 'message' => 'Chat ID and message are required']);
            exit;
        }

        $result = addMessage($chat_id, $message, $sender);
        echo json_encode($result);
        break;

    case 'get_messages':
        $chat_id = $_GET['chat_id'] ?? '';
        if(empty($chat_id)) {
            echo json_encode(['success' => false, 'message' => 'Chat ID is required']);
            exit;
        }

        $result = getChatMessages($chat_id, $_SESSION['user_id']);
        echo json_encode($result);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>
