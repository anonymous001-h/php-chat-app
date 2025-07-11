<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASTRO</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="img/astro.png">

    <style>
        :root {
            --primary-color: #10a37f;
            --secondary-color: #343541;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--light-bg);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* Main App Container - Flexbox Layout */
        .app-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background-color: var(--secondary-color);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .new-chat-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 8px;
            padding: 12px 16px;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .new-chat-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .conversations-list {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem 0;
        }

        .conversation-item {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 16px;
            margin: 4px 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: none;
            width: calc(100% - 16px);
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
        }

        .conversation-item {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 16px;
            margin: 4px 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: none;
            width: calc(100% - 16px);
            text-align: left;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .conversation-content {
            flex: 1;
            min-width: 0;
        }

        .conversation-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
        }

        .conversation-actions {
            display: flex;
            gap: 4px;
            opacity: 0;
            transition: opacity 0.2s;
            margin-left: 8px;
        }

        .conversation-item:hover .conversation-actions {
            opacity: 1;
        }

        .conversation-action-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: rgba(255, 255, 255, 0.7);
            border-radius: 4px;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .conversation-action-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .conversation-action-btn.delete-btn:hover {
            background: rgba(220, 53, 69, 0.8);
            color: white;
        }

        /* Rename input styles */
        .rename-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            width: 100%;
            outline: none;
        }

        .rename-input:focus {
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.15);
        }

        .conversation-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .conversation-item.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .conversation-meta {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 2px;
        }

        .conversation-delete {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(220, 53, 69, 0.8);
            border: none;
            color: white;
            border-radius: 4px;
            width: 24px;
            height: 24px;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .conversation-item:hover .conversation-delete {
            display: flex;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .settings-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 16px;
            width: 100%;
            text-align: left;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .settings-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow: hidden;
            position: relative;
        }

        .header {
            height: var(--header-height);
            background: white;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            flex-shrink: 0;
            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .hamburger-menu {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #6c757d;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .hamburger-menu:hover {
            background: #f8f9fa;
            color: #495057;
        }

        .chat-area {
            flex: 1;
            overflow-y: auto;
            padding: 2rem 0;
            position: relative;
            scroll-behavior: smooth;
        }

        /* Scroll to bottom button */
        .scroll-to-bottom {
            position: fixed;
            bottom: 120px;
            right: 30px;
            width: 48px;
            height: 48px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            z-index: 1000;
            font-size: 1.2rem;
        }

        .scroll-to-bottom:hover {
            background: #0d8c6d;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .scroll-to-bottom.show {
            display: flex;
            animation: slideInUp 0.3s ease;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-screen {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 60vh;
            text-align: center;
            padding: 2rem;
        }

        .welcome-title {
            font-size: 3rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .welcome-subtitle {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .example-prompts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            max-width: 900px;
            width: 100%;
        }

        .example-prompt {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .example-prompt:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .message-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .message {
            display: flex;
            gap: 1rem;
            padding: 1.5rem 0;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
        }

        .user-avatar {
            background: var(--primary-color);
            color: white;
        }

        .ai-avatar {
            background: var(--secondary-color);
            color: white;
        }

        .message-content {
            flex: 1;
            line-height: 1.6;
            min-width: 0;
        }

        .user-message {
            background: rgba(16, 163, 127, 0.1);
            padding: 1rem 1.25rem;
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
        }

        .ai-message {
            background: #f8f9fa;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            border-left: 4px solid var(--secondary-color);
        }

        .message-timestamp {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 0.5rem;
            opacity: 0.7;
        }

        .code-block {
            background: #1e1e1e;
            border-radius: 8px;
            margin: 1rem 0;
            overflow: hidden;
        }

        .code-header {
            background: #2d2d2d;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
            font-size: 0.875rem;
        }

        .code-content {
            padding: 1rem;
            color: #f8f8f2;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            overflow-x: auto;
        }

        .copy-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .copy-btn:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 0;
        }

        .typing-dots {
            display: flex;
            gap: 4px;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary-color);
            animation: pulse 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes pulse {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        .input-area {
            padding: 1.5rem;
            background: white;
            border-top: 1px solid #e9ecef;
            flex-shrink: 0;
        }

        .input-container {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            background: white;
            transition: border-color 0.2s;
        }

        .input-container:focus-within {
            border-color: var(--primary-color);
        }

        .message-input {
            width: 100%;
            min-height: 60px;
            max-height: 200px;
            padding: 1rem 4rem 1rem 1rem;
            border: none;
            border-radius: 12px;
            resize: none;
            font-size: 1rem;
            line-height: 1.5;
            outline: none;
        }

        .input-actions {
            position: absolute;
            right: 1rem;
            bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .attach-btn {
            background: none;
            color: #6c757d;
        }

        .attach-btn:hover {
            background: #f8f9fa;
            color: #495057;
        }

        .send-btn {
            background: var(--primary-color);
            color: white;
        }

        .send-btn:hover:not(:disabled) {
            background: #0d8c6d;
        }

        .send-btn:disabled {
            background: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
        }

        .file-preview-area {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .file-preview {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f8f9fa;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
        }

        .file-remove-btn {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-remove-btn:hover {
            color: #dc3545;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .auth-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .login-btn {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color) !important;
        }

        .login-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .signup-btn {
            background: var(--primary-color);
            color: white;
        }

        .signup-btn:hover {
            background: #0d8c6d;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid #e9ecef;
            color: #6c757d;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .logout-btn:hover {
            background: #f8f9fa;
            color: #495057;
        }

        /* Settings Modal Enhancements */
        .settings-tabs {
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 1.5rem;
        }

        .settings-tab {
            background: none;
            border: none;
            padding: 0.75rem 1rem;
            color: #6c757d;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
        }

        .settings-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .settings-section {
            margin-bottom: 2rem;
        }

        .settings-section h5 {
            margin-bottom: 1rem;
            color: var(--secondary-color);
            font-weight: 600;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-label {
            flex: 1;
        }

        .setting-label h6 {
            margin: 0 0 0.25rem 0;
            font-weight: 500;
        }

        .setting-label small {
            color: #6c757d;
        }

        .range-container {
            margin: 1rem 0;
        }

        .range-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-range {
            width: 100%;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.875rem;
        }

        /* Mobile Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Dark theme */
        [data-theme="dark"] {
            --light-bg: #1a1a1a;
            --dark-bg: #2d2d2d;
        }

        [data-theme="dark"] body {
            background-color: var(--dark-bg);
            color: #e9ecef;
        }

        [data-theme="dark"] .header {
            background: var(--dark-bg);
            border-bottom-color: #495057;
        }

        [data-theme="dark"] .input-area {
            background: var(--dark-bg);
            border-top-color: #495057;
        }

        [data-theme="dark"] .input-container {
            background: #343a40;
            border-color: #495057;
        }

        [data-theme="dark"] .message-input {
            background: #343a40;
            color: #e9ecef;
        }

        [data-theme="dark"] .ai-message {
            background: #343a40;
        }

        [data-theme="dark"] .example-prompt {
            background: #343a40;
            border-color: #495057;
            color: #e9ecef;
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main-content {
                width: 100%;
            }

            .hamburger-menu {
                display: block !important;
            }

            .example-prompts {
                grid-template-columns: 1fr;
            }

            .welcome-title {
                font-size: 2.5rem;
            }

            .auth-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .auth-btn {
                padding: 0.375rem 1rem;
                font-size: 0.875rem;
            }

            .user-info {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-end;
            }

            .scroll-to-bottom {
                right: 20px;
                bottom: 100px;
            }
        }

        @media (max-width: 767.98px) {
            .welcome-title {
                font-size: 2rem;
            }

            .welcome-subtitle {
                font-size: 1.1rem;
            }

            .example-prompts {
                padding: 0 1rem;
            }

            .message {
                padding: 1rem 0;
            }

            .message-avatar {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }

            .input-area {
                padding: 1rem;
            }

            .header {
                padding: 0 1rem;
            }

            .brand {
                font-size: 1.25rem;
            }

            .auth-buttons {
                gap: 0.25rem;
            }

            .auth-btn {
                padding: 0.25rem 0.75rem;
                font-size: 0.8rem;
            }

            .scroll-to-bottom {
                width: 40px;
                height: 40px;
                right: 15px;
                bottom: 90px;
                font-size: 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .welcome-title {
                font-size: 1.75rem;
            }

            .example-prompt {
                padding: 1rem;
            }

            .message-container {
                padding: 0 0.5rem;
            }

            .input-area {
                padding: 0.75rem;
            }

            .input-container {
                border-radius: 8px;
            }

            .message-input {
                padding: 0.75rem 3.5rem 0.75rem 0.75rem;
                min-height: 50px;
            }

            .input-actions {
                right: 0.75rem;
                bottom: 0.75rem;
            }

            .action-btn {
                width: 32px;
                height: 32px;
            }
        }

        /* Desktop - Show sidebar by default */
        @media (min-width: 992px) {
            .hamburger-menu {
                display: none !important;
            }
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }

        .account-info {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .account-field {
            margin-bottom: 1rem;
        }

        .account-field:last-child {
            margin-bottom: 0;
        }

        .account-field .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            display: block;
        }

        .account-value {
            color: #6c757d;
            font-size: 0.95rem;
            padding: 0.5rem 0;
        }

        [data-theme="dark"] .account-info {
            background: #343a40;
        }

        [data-theme="dark"] .account-field .form-label {
            color: #e9ecef;
        }

        [data-theme="dark"] .account-value {
            color: #adb5bd;
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main App Container -->
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <button class="new-chat-btn" id="newChatBtn">
                    <i class="bi bi-plus-lg"></i>
                    New Chat
                </button>
            </div>
            
            <div class="conversations-list" id="conversationsList">
                <!-- Conversations will be populated here -->
            </div>
            
            <div class="sidebar-footer">
                <button class="settings-btn" id="settingsBtn">
                    <i class="bi bi-gear"></i>
                    Settings
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <div class="brand">
                    <button class="hamburger-menu d-lg-none" id="hamburgerMenu">
                        <i class="bi bi-list"></i>
                    </button>
                    <span>ASTRO</span>
                </div>
                
                <div class="auth-section" id="authSection">
                    <!-- Auth buttons or user info will be populated here -->
                </div>
            </header>

            <!-- Chat Area -->
            <div class="chat-area" id="chatArea">
                <!-- Welcome Screen -->
                <div class="welcome-screen" id="welcomeScreen">
                    <h1 class="welcome-title">ASTRO</h1>
                    <p class="welcome-subtitle">How can I assist you today?</p>
                    
                    <div class="example-prompts">
                        <div class="example-prompt" data-prompt="Write a detailed blog post about artificial intelligence and its impact on healthcare in 2025.">
                            <h5>Write a blog post</h5>
                            <p class="text-muted">About AI in healthcare in 2025</p>
                        </div>
                        <div class="example-prompt" data-prompt="Explain quantum computing to a 10-year-old in a fun and engaging way.">
                            <h5>Explain a concept</h5>
                            <p class="text-muted">Quantum computing for a child</p>
                        </div>
                        <div class="example-prompt" data-prompt="Write a Python function that generates the Fibonacci sequence up to n terms using recursion.">
                            <h5>Code assistance</h5>
                            <p class="text-muted">Python Fibonacci sequence function</p>
                        </div>
                        <div class="example-prompt" data-prompt="Create a 7-day meal plan for a vegetarian diet focused on protein intake and weight management.">
                            <h5>Get recommendations</h5>
                            <p class="text-muted">Vegetarian meal plan for fitness</p>
                        </div>
                    </div>
                </div>

                <!-- Message Container -->
                <div class="message-container" id="messageContainer" style="display: none;">
                    <!-- Messages will be populated here -->
                </div>
            </div>

            <!-- Scroll to Bottom Button -->
            <button class="scroll-to-bottom" id="scrollToBottomBtn">
                <i class="bi bi-arrow-down"></i>
            </button>

            <!-- Input Area -->
            <div class="input-area">
                <div class="input-container">
                    <div class="file-preview-area" id="filePreviewArea" style="display: none;">
                        <!-- File previews will be populated here -->
                    </div>
                    
                    <textarea class="message-input" id="messageInput" placeholder="Message ASTRO..." rows="1"></textarea>
                    <input type="file" id="fileInput" multiple style="display: none;" accept="*/*">
                    
                    <div class="input-actions">
                        <button class="action-btn attach-btn" id="attachBtn" title="Attach file">
                            <i class="bi bi-paperclip"></i>
                        </button>
                        <button class="action-btn send-btn" id="sendBtn" disabled>
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalTitle">Log in to ASTRO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="authMessage"></div>
                    <!-- Login Form -->
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Log in</button>
                        <div class="text-center mt-3">
                            <small>Don't have an account? <a href="#" id="showSignup">Sign up</a></small>
                        </div>
                    </form>

                    <!-- Signup Form -->
                    <form id="signupForm" style="display: none;">
                        <div class="mb-3">
                            <label for="signupName" class="form-label">Username</label>
                            <input type="text" class="form-control" id="signupName" required>
                        </div>
                        <div class="mb-3">
                            <label for="signupEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="signupEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="signupPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="signupPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign up</button>
                        <div class="text-center mt-3">
                            <small>Already have an account? <a href="#" id="showLogin">Log in</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Settings Tabs -->
                    <div class="settings-tabs">
                        <button class="settings-tab active" data-tab="general">General</button>
                        <button class="settings-tab" data-tab="ai">AI Model</button>
                        <button class="settings-tab" data-tab="appearance">Appearance</button>
                        <button class="settings-tab" data-tab="account">Account</button>
                        <button class="settings-tab" data-tab="data">Data</button>
                    </div>

                    <!-- General Settings -->
                    <div class="tab-content" id="generalTab">
                        <div class="settings-section">
                            <div class="setting-item">
                                <div class="setting-label">
                                    <h6>Auto-save conversations</h6>
                                    <small>Automatically save conversations to database</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="autoSaveSwitch" checked>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-label">
                                    <h6>Show timestamps</h6>
                                    <small>Display timestamps for each message</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="timestampsSwitch">
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-label">
                                    <h6>Context History Length</h6>
                                    <small>Number of previous messages to include for AI context</small>
                                </div>
                                <select class="form-select" id="contextLengthSelect" style="width: 120px;">
                                    <option value="5">5 messages</option>
                                    <option value="10" selected>10 messages</option>
                                    <option value="15">15 messages</option>
                                    <option value="20">20 messages</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- AI Model Settings -->
                    <div class="tab-content" id="aiTab" style="display: none;">
                        <div class="settings-section">
                            <div class="mb-3">
                                <label for="modelSelect" class="form-label">AI Model</label>
                                <select class="form-select" id="modelSelect">
                                    <option value="gemini-2.0-flash">Gemini 2.0 Flash</option>
                                    <option value="gemini-1.5-pro">Gemini 1.5 Pro</option>
                                    <option value="gemini-1.5-flash">Gemini 1.5 Flash</option>
                                </select>
                            </div>
                            
                            <div class="range-container">
                                <div class="range-label">
                                    <span>Temperature</span>
                                    <span id="temperatureValue">0.7</span>
                                </div>
                                <input type="range" class="form-range" id="temperatureRange" min="0" max="1" step="0.1" value="0.7">
                                <small class="text-muted">Controls randomness in responses (0 = focused, 1 = creative)</small>
                            </div>
                            
                            <div class="range-container">
                                <div class="range-label">
                                    <span>Max Tokens</span>
                                    <span id="maxTokensValue">2048</span>
                                </div>
                                <input type="range" class="form-range" id="maxTokensRange" min="256" max="4096" step="256" value="2048">
                                <small class="text-muted">Maximum length of AI responses</small>
                            </div>
                        </div>
                    </div>

                    <!-- Appearance Settings -->
                    <div class="tab-content" id="appearanceTab" style="display: none;">
                        <div class="settings-section">
                            <div class="mb-3">
                                <label for="themeSelect" class="form-label">Theme</label>
                                <select class="form-select" id="themeSelect">
                                    <option value="light">Light</option>
                                    <option value="dark">Dark</option>
                                    <option value="system">System</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Account Settings -->
                    <div class="tab-content" id="accountTab" style="display: none;">
                        <div class="settings-section">
                            <h5>Account Information</h5>
                            <div class="account-info">
                                <div class="account-field">
                                    <label class="form-label">Username</label>
                                    <div class="account-value" id="accountUsername">-</div>
                                </div>
                                <div class="account-field">
                                    <label class="form-label">Email</label>
                                    <div class="account-value" id="accountEmail">-</div>
                                </div>
                                <div class="account-field">
                                    <label class="form-label">Password</label>
                                    <div class="account-value">••••••••</div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-outline-danger" id="accountLogoutBtn">
                                    <i class="bi bi-box-arrow-right"></i> Log Out
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Settings -->
                    <div class="tab-content" id="dataTab" style="display: none;">
                        <div class="settings-section">
                            <h5>Conversation History</h5>
                            <p class="text-muted">Your conversation history is stored securely in our database.</p>
                            
                            <div class="d-flex gap-2 mb-4">
                                <button class="btn btn-outline-primary" id="exportBtn">
                                    <i class="bi bi-download"></i> Export Conversations
                                </button>
                                <button class="btn btn-outline-danger" id="clearHistoryBtn">
                                    <i class="bi bi-trash"></i> Clear History
                                </button>
                            </div>

                            <h5>Storage Info</h5>
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <div class="stat-number" id="conversationCount">0</div>
                                    <div class="stat-label">Conversations</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-number" id="messageCount">0</div>
                                    <div class="stat-label">Total Messages</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Application State
        let conversations = [];
        let currentConversationId = null;
        let isProcessing = false;
        let isLoggedIn = false;
        let loggedInUser = null;
        let attachedFiles = [];
        let isUserScrolling = false;
        let scrollTimeout = null;
        let settings = {
            theme: 'system',
            model: 'gemini-2.0-flash',
            temperature: 0.7,
            maxTokens: 2048,
            autoSave: true,
            showTimestamps: false,
            contextLength: 10
        };

        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const hamburgerMenu = document.getElementById('hamburgerMenu');
        const newChatBtn = document.getElementById('newChatBtn');
        const conversationsList = document.getElementById('conversationsList');
        const welcomeScreen = document.getElementById('welcomeScreen');
        const messageContainer = document.getElementById('messageContainer');
        const chatArea = document.getElementById('chatArea');
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const attachBtn = document.getElementById('attachBtn');
        const fileInput = document.getElementById('fileInput');
        const filePreviewArea = document.getElementById('filePreviewArea');
        const authSection = document.getElementById('authSection');
        const settingsBtn = document.getElementById('settingsBtn');
        const scrollToBottomBtn = document.getElementById('scrollToBottomBtn');

        // Modals
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        const settingsModal = new bootstrap.Modal(document.getElementById('settingsModal'));

        // Initialize Application
        function initApp() {
            checkSession();
            setupEventListeners();
            loadSettings();
            applyTheme();
            setupScrollHandling();
        }

        // Check user session
        async function checkSession() {
            try {
                const response = await fetch('../api/auth.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=check_session'
                });
                const data = await response.json();
                
                if (data.success && data.logged_in) {
                    isLoggedIn = true;
                    loggedInUser = { 
                        username: data.username,
                        email: data.email || data.username // fallback to username if email not provided
                    };
                    updateAuthSection();
                    await loadConversations();
                } else {
                    isLoggedIn = false;
                    loggedInUser = null;
                    updateAuthSection();
                }
            } catch (error) {
                console.error('Session check failed:', error);
                updateAuthSection();
            }
        }

        // Load settings from localStorage
        function loadSettings() {
            const storedSettings = localStorage.getItem('astro-settings');
            if (storedSettings) {
                try {
                    const parsed = JSON.parse(storedSettings);
                    settings = { ...settings, ...parsed };
                    updateSettingsUI();
                } catch (error) {
                    console.error('Error loading settings:', error);
                }
            }
        }

        // Save settings to localStorage
        function saveSettings() {
            try {
                localStorage.setItem('astro-settings', JSON.stringify(settings));
            } catch (error) {
                console.error('Error saving settings:', error);
            }
        }

        // Setup scroll handling for auto-scroll and scroll-to-bottom button
        function setupScrollHandling() {
            chatArea.addEventListener('scroll', handleScroll);
            scrollToBottomBtn.addEventListener('click', scrollToBottom);
        }

        function handleScroll() {
            const { scrollTop, scrollHeight, clientHeight } = chatArea;
            const isAtBottom = scrollTop + clientHeight >= scrollHeight - 50;
            
            // Show/hide scroll to bottom button
            if (isAtBottom) {
                scrollToBottomBtn.classList.remove('show');
                isUserScrolling = false;
            } else {
                scrollToBottomBtn.classList.add('show');
                isUserScrolling = true;
            }

            // Clear scroll timeout
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }

            // Set timeout to detect when user stops scrolling
            scrollTimeout = setTimeout(() => {
                const { scrollTop, scrollHeight, clientHeight } = chatArea;
                const isAtBottom = scrollTop + clientHeight >= scrollHeight - 50;
                if (isAtBottom) {
                    isUserScrolling = false;
                }
            }, 150);
        }

        function scrollToBottom(smooth = true) {
            chatArea.scrollTo({
                top: chatArea.scrollHeight,
                behavior: smooth ? 'smooth' : 'auto'
            });
            scrollToBottomBtn.classList.remove('show');
            isUserScrolling = false;
        }

        // Setup Event Listeners
        function setupEventListeners() {
            // Sidebar toggle
            hamburgerMenu.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);

            // New chat
            newChatBtn.addEventListener('click', startNewConversation);

            // Message input
            messageInput.addEventListener('input', () => {
                sendBtn.disabled = !messageInput.value.trim() && attachedFiles.length === 0;
                autoResize();
            });

            messageInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Send message
            sendBtn.addEventListener('click', sendMessage);

            // File attachment
            attachBtn.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', handleFileSelection);

            // Example prompts
            document.querySelectorAll('.example-prompt').forEach(prompt => {
                prompt.addEventListener('click', () => {
                    if (!isLoggedIn) {
                        showLoginModal();
                        return;
                    }
                    const promptText = prompt.dataset.prompt;
                    startNewConversation();
                    messageInput.value = promptText;
                    messageInput.dispatchEvent(new Event('input'));
                    sendMessage();
                });
            });

            // Settings
            settingsBtn.addEventListener('click', () => {
                updateStats();
                settingsModal.show();
            });

            // Settings tabs
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabName = tab.dataset.tab;
                    switchSettingsTab(tabName);
                });
            });

            // Settings controls
            document.getElementById('autoSaveSwitch').addEventListener('change', (e) => {
                settings.autoSave = e.target.checked;
                saveSettings();
            });

            document.getElementById('timestampsSwitch').addEventListener('change', (e) => {
                settings.showTimestamps = e.target.checked;
                saveSettings();
                // Refresh current conversation to show/hide timestamps
                if (currentConversationId) {
                    loadConversation(currentConversationId, false);
                }
            });

            document.getElementById('contextLengthSelect').addEventListener('change', (e) => {
                settings.contextLength = parseInt(e.target.value);
                saveSettings();
            });

            document.getElementById('modelSelect').addEventListener('change', (e) => {
                settings.model = e.target.value;
                saveSettings();
            });

            document.getElementById('temperatureRange').addEventListener('input', (e) => {
                settings.temperature = parseFloat(e.target.value);
                document.getElementById('temperatureValue').textContent = settings.temperature;
                saveSettings();
            });

            document.getElementById('maxTokensRange').addEventListener('input', (e) => {
                settings.maxTokens = parseInt(e.target.value);
                document.getElementById('maxTokensValue').textContent = settings.maxTokens;
                saveSettings();
            });

            document.getElementById('themeSelect').addEventListener('change', (e) => {
                settings.theme = e.target.value;
                applyTheme();
                saveSettings();
            });

            document.getElementById('exportBtn').addEventListener('click', exportConversations);
            document.getElementById('clearHistoryBtn').addEventListener('click', clearHistory);

            // Auth forms
            document.getElementById('loginForm').addEventListener('submit', handleLogin);
            document.getElementById('signupForm').addEventListener('submit', handleSignup);
            document.getElementById('showSignup').addEventListener('click', showSignupForm);
            document.getElementById('showLogin').addEventListener('click', showLoginForm);

            // Handle window resize
            window.addEventListener('resize', handleResize);

            // Account logout button
            document.getElementById('accountLogoutBtn').addEventListener('click', async () => {
                if (confirm('Are you sure you want to log out?')) {
                    await handleLogout();
                    settingsModal.hide();
                }
            });
        }

        // Sidebar functions
        function toggleSidebar() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        }

        function handleResize() {
            if (window.innerWidth >= 992) {
                closeSidebar();
            }
        }

        // Auto-resize textarea
        function autoResize() {
            messageInput.style.height = 'auto';
            messageInput.style.height = messageInput.scrollHeight + 'px';
        }

        // Update auth section
        function updateAuthSection() {
            if (isLoggedIn && loggedInUser) {
                authSection.innerHTML = `
                    <div class="user-info">
                        <span>Welcome, ${loggedInUser.username}</span>
                        <button class="btn logout-btn" onclick="handleLogout()">Log out</button>
                    </div>
                `;
            } else {
                authSection.innerHTML = `
                    <div class="auth-buttons">
                        <button class="auth-btn login-btn" onclick="showLoginModal()">Log in</button>
                        <button class="auth-btn signup-btn" onclick="showSignupModal()">Sign up</button>
                    </div>
                `;
            }
        }

        // Auth functions
        function showLoginModal() {
            showLoginForm();
            loginModal.show();
        }

        function showSignupModal() {
            showSignupForm();
            loginModal.show();
        }

        function showLoginForm() {
            document.getElementById('loginModalTitle').textContent = 'Log in to ASTRO';
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('signupForm').style.display = 'none';
            document.getElementById('authMessage').innerHTML = '';
        }

        function showSignupForm() {
            document.getElementById('loginModalTitle').textContent = 'Sign up for ASTRO';
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('signupForm').style.display = 'block';
            document.getElementById('authMessage').innerHTML = '';
        }

        function showAuthMessage(message, type) {
            const element = document.getElementById('authMessage');
            element.innerHTML = `<div class="${type}-message">${message}</div>`;
            setTimeout(() => element.innerHTML = '', 5000);
        }

        async function handleLogin(e) {
            e.preventDefault();
            
            // Get form data with correct field names
            const email = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value.trim();
            
            // Debug logging
            console.log('Login attempt:', { email, passwordLength: password.length });
            
            if (!email || !password) {
                showAuthMessage('Please fill in all fields', 'error');
                return;
            }

            // Create FormData with correct field names
            const formData = new FormData();
            formData.append('action', 'login');
            formData.append('loginEmail', email);
            formData.append('loginPassword', password);

            try {
                const response = await fetch('../api/auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                console.log('Login response:', data);
                
                if (data.success) {
                    isLoggedIn = true;
                    loggedInUser = { username: data.username };
                    updateAuthSection();
                    loginModal.hide();
                    document.getElementById('loginForm').reset();
                    await loadConversations();
                } else {
                    showAuthMessage(data.message, 'error');
                }
            } catch (error) {
                console.error('Login error:', error);
                showAuthMessage('Login failed. Please try again.', 'error');
            }
        }

        async function handleSignup(e) {
            e.preventDefault();
            
            // Get form data with correct field names
            const username = document.getElementById('signupName').value.trim();
            const email = document.getElementById('signupEmail').value.trim();
            const password = document.getElementById('signupPassword').value.trim();
            
            console.log('Signup attempt:', { username, email, passwordLength: password.length });
            
            if (!username || !email || !password) {
                showAuthMessage('Please fill in all fields', 'error');
                return;
            }

            // Create FormData with correct field names
            const formData = new FormData();
            formData.append('action', 'register');
            formData.append('signupName', username);
            formData.append('signupEmail', email);
            formData.append('signupPassword', password);

            try {
                const response = await fetch('../api/auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                console.log('Signup response:', data);
                
                if (data.success) {
                    showAuthMessage(data.message, 'success');
                    setTimeout(() => showLoginForm(), 2000);
                } else {
                    showAuthMessage(data.message, 'error');
                }
            } catch (error) {
                console.error('Signup error:', error);
                showAuthMessage('Registration failed. Please try again.', 'error');
            }
        }

        async function handleLogout() {
            try {
                const response = await fetch('../api/auth.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=logout'
                });
                const data = await response.json();
                
                if (data.success) {
                    isLoggedIn = false;
                    loggedInUser = null;
                    conversations = [];
                    currentConversationId = null;
                    updateAuthSection();
                    updateConversationsList();
                    welcomeScreen.style.display = 'flex';
                    messageContainer.style.display = 'none';
                }
            } catch (error) {
                console.error('Logout failed:', error);
            }
        }

        // File handling
        function handleFileSelection() {
            const files = Array.from(fileInput.files);
            attachedFiles = files.map(file => ({
                name: file.name,
                size: file.size,
                type: file.type,
                file: file
            }));

            updateFilePreview();
            sendBtn.disabled = !messageInput.value.trim() && attachedFiles.length === 0;
        }

        function updateFilePreview() {
            if (attachedFiles.length > 0) {
                filePreviewArea.style.display = 'flex';
                filePreviewArea.innerHTML = attachedFiles.map((file, index) => `
                    <div class="file-preview">
                        <i class="bi bi-file-earmark"></i>
                        <span>${file.name}</span>
                        <small class="text-muted">(${formatFileSize(file.size)})</small>
                        <button class="file-remove-btn" onclick="removeFile(${index})">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `).join('');
            } else {
                filePreviewArea.style.display = 'none';
                filePreviewArea.innerHTML = '';
            }
        }

        function removeFile(index) {
            attachedFiles.splice(index, 1);
            updateFilePreview();
            sendBtn.disabled = !messageInput.value.trim() && attachedFiles.length === 0;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Load conversations from database
        async function loadConversations() {
            if (!isLoggedIn) return;
            
            try {
                const response = await fetch('../api/chat.php?action=get_chats');
                const data = await response.json();
                
                if (data.success) {
                    conversations = data.chats;
                    updateConversationsList();
                }
            } catch (error) {
                console.error('Failed to load conversations:', error);
            }
        }

        // Enhanced conversation management with database persistence
        async function startNewConversation() {
            if (!isLoggedIn) {
                showLoginModal();
                return;
            }

            try {
                const response = await fetch('../api/chat.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=create&title=New Chat'
                });
                const data = await response.json();
                
                if (data.success) {
                    currentConversationId = data.chat_id;
                    welcomeScreen.style.display = 'none';
                    messageContainer.style.display = 'block';
                    messageContainer.innerHTML = '';
                    closeSidebar();
                    await loadConversations();
                    scrollToBottom(false);
                }
            } catch (error) {
                console.error('Failed to create conversation:', error);
            }
        }

        async function loadConversation(id, closesSidebar = true) {
            currentConversationId = id;
            
            try {
                const response = await fetch(`../api/chat.php?action=get_messages&chat_id=${id}`);
                const data = await response.json();
                
                if (data.success) {
                    welcomeScreen.style.display = 'none';
                    messageContainer.style.display = 'block';
                    messageContainer.innerHTML = '';
                    
                    // Load all messages from the conversation
                    data.messages.forEach((message) => {
                        addMessageToUI(message.sender, message.message, message.created_at, false);
                    });

                    // Scroll to bottom after loading
                    setTimeout(() => scrollToBottom(false), 100);
                }
            } catch (error) {
                console.error('Failed to load conversation:', error);
            }
            
            if (closesSidebar) {
                closeSidebar();
            }
            updateConversationsList();
        }

        async function deleteConversation(id, event) {
            event.stopPropagation();
            if (confirm('Are you sure you want to delete this conversation?')) {
                try {
                    const response = await fetch('../api/chat.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=delete&chat_id=${id}`
                    });
                    const data = await response.json();
                    
                    if (data.success) {
                        if (currentConversationId == id) {
                            currentConversationId = null;
                            welcomeScreen.style.display = 'flex';
                            messageContainer.style.display = 'none';
                        }
                        await loadConversations();
                        updateStats();
                    }
                } catch (error) {
                    console.error('Failed to delete conversation:', error);
                }
            }
        }

        function updateConversationsList() {
            if (!isLoggedIn) {
                conversationsList.innerHTML = '<div class="text-center text-muted p-3">Please log in to view conversations</div>';
                return;
            }

            if (conversations.length === 0) {
                conversationsList.innerHTML = '<div class="text-center text-muted p-3">No conversations yet</div>';
                return;
            }

            conversationsList.innerHTML = conversations.map(conv => {
                const lastUpdated = new Date(conv.updated_at);
                const isToday = new Date().toDateString() === lastUpdated.toDateString();
                const timeStr = isToday ? 
                    lastUpdated.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) :
                    lastUpdated.toLocaleDateString();

                // Count messages for this conversation
                const messageCount = conversations.find(c => c.id === conv.id)?.messageCount || 0;

                return `
                    <div class="conversation-item ${conv.id == currentConversationId ? 'active' : ''}" 
     onclick="loadConversation('${conv.id}')">
    <div class="conversation-content">
        <div class="conversation-title" id="title-${conv.id}">${conv.title}</div>
        <div class="conversation-meta">${messageCount} messages • ${timeStr}</div>
    </div>
    <div class="conversation-actions">
        <button class="conversation-action-btn" onclick="event.stopPropagation(); renameConversation('${conv.id}', '${conv.title.replace(/'/g, '\\\'')}')" title="Rename conversation">
            <i class="bi bi-pencil"></i>
        </button>
        <button class="conversation-action-btn delete-btn" onclick="event.stopPropagation(); deleteConversation('${conv.id}', event)" title="Delete conversation">
            <i class="bi bi-trash"></i>
        </button>
    </div>
</div>
                `;
            }).join('');
        }

        function generateTitle(message) {
            // Clean the message and generate a meaningful title
            const cleanMessage = message.replace(/\[.*?\]/g, '').trim();
            const words = cleanMessage.split(' ');
            const titleWords = words.slice(0, 6);
            let title = titleWords.join(' ');
            if (words.length > 6) {
                title += '...';
            }
            return title || 'New Conversation';
        }

        // Enhanced message handling with database persistence
        async function sendMessage() {
            if ((!messageInput.value.trim() && attachedFiles.length === 0) || isProcessing || !isLoggedIn) {
                if (!isLoggedIn) {
                    showLoginModal();
                }
                return;
            }

            const userMessage = messageInput.value.trim();
            const fileInfo = attachedFiles.length > 0 ? ` [${attachedFiles.length} file(s) attached]` : '';
            
            // Create conversation if needed
            if (!currentConversationId) {
                await startNewConversation();
            }

            // Add user message with timestamp
            const timestamp = new Date().toISOString();
            const userMessageContent = userMessage + fileInfo;
            addMessageToUI('user', userMessageContent, timestamp);
            
            // Save user message to database
            await saveMessage(currentConversationId, userMessageContent, 'user');

            // Clear input
            messageInput.value = '';
            attachedFiles = [];
            updateFilePreview();
            sendBtn.disabled = true;
            isProcessing = true;

            // Show typing indicator
            showTypingIndicator();

            try {
                // Get conversation context for AI
                const contextMessages = await getConversationContext(currentConversationId);
                
                // Call Gemini API with context
                const response = await callGeminiAPI(userMessage, contextMessages);
                hideTypingIndicator();
                
                // Clean AI response (remove ** and ## formatting)
                const cleanResponse = cleanAIResponse(response);
                
                const aiTimestamp = new Date().toISOString();
                addMessageToUI('assistant', cleanResponse, aiTimestamp);
                await saveMessage(currentConversationId, cleanResponse, 'assistant');
                
                // Update conversation title if this is the first exchange
                await updateConversationTitle(currentConversationId, userMessage);
                
            } catch (error) {
                hideTypingIndicator();
                console.error('API Error:', error);
                const errorMessage = "I apologize, but I encountered an error while processing your request. Please try again later.";
                const errorTimestamp = new Date().toISOString();
                addMessageToUI('assistant', errorMessage, errorTimestamp);
                await saveMessage(currentConversationId, errorMessage, 'assistant');
            }

            isProcessing = false;
            await loadConversations();
        }

        // Get conversation context from database
        async function getConversationContext(chatId) {
            try {
                const response = await fetch(`../api/chat.php?action=get_messages&chat_id=${chatId}`);
                const data = await response.json();
                
                if (data.success) {
                    return data.messages.slice(-settings.contextLength).map(msg => ({
                        role: msg.sender,
                        content: msg.message
                    }));
                }
                return [];
            } catch (error) {
                console.error('Failed to get context:', error);
                return [];
            }
        }

        // Save message to database
        async function saveMessage(chatId, message, sender) {
            try {
                const response = await fetch('../api/chat.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=add_message&chat_id=${chatId}&message=${encodeURIComponent(message)}&sender=${sender}`
                });
                const data = await response.json();
                
                if (!data.success) {
                    console.error('Failed to save message:', data.message);
                }
            } catch (error) {
                console.error('Failed to save message:', error);
            }
        }

        // Update conversation title
        async function updateConversationTitle(chatId, firstMessage) {
            const conversation = conversations.find(c => c.id == chatId);
            if (conversation && conversation.title === 'New Chat') {
                const newTitle = generateTitle(firstMessage);
                try {
                    const response = await fetch('../api/chat.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=rename&chat_id=${chatId}&new_title=${encodeURIComponent(newTitle)}`
                    });
                    const data = await response.json();
                    
                    if (data.success) {
                        await loadConversations();
                    }
                } catch (error) {
                    console.error('Failed to update title:', error);
                }
            }
        }

        // Clean AI response by removing markdown formatting
        function cleanAIResponse(response) {
            return response
                .replace(/\*\*(.*?)\*\*/g, '$1')  // Remove **bold** formatting
                .replace(/^##\s+/gm, '')          // Remove ## headers
                .replace(/^#\s+/gm, '')           // Remove # headers
                .trim();
        }

        function addMessageToUI(role, content, timestamp, shouldScroll = true) {
            const isUser = role === 'user';
            const messageTime = timestamp ? new Date(timestamp) : new Date();
            const timeStr = settings.showTimestamps ? 
                `<div class="message-timestamp">${messageTime.toLocaleString()}</div>` : '';
            
            const messageHTML = `
                <div class="message">
                    <div class="message-avatar ${isUser ? 'user-avatar' : 'ai-avatar'}">
                        <i class="bi ${isUser ? 'bi-person' : 'bi-robot'}"></i>
                    </div>
                    <div class="message-content">
                        <div class="${isUser ? 'user-message' : 'ai-message'}">
                            ${formatMessageContent(content)}
                            ${timeStr}
                        </div>
                    </div>
                </div>
            `;

            messageContainer.insertAdjacentHTML('beforeend', messageHTML);
            
            // Auto-scroll to bottom if user is not scrolling up
            if (shouldScroll && !isUserScrolling) {
                setTimeout(() => scrollToBottom(), 100);
            }
        }

        function formatMessageContent(content) {
            // Handle code blocks
            content = content.replace(/\`\`\`(\w+)?\n([\s\S]*?)\`\`\`/g, (match, language, code) => {
                const lang = language || 'code';
                return `
                    <div class="code-block">
                        <div class="code-header">
                            <span>${lang}</span>
                            <button class="copy-btn" onclick="copyCode(this)">
                                <i class="bi bi-clipboard"></i> Copy
                            </button>
                        </div>
                        <div class="code-content">${escapeHtml(code)}</div>
                    </div>
                `;
            });

            // Handle line breaks
            return content.replace(/\n/g, '<br>');
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function copyCode(button) {
            const codeContent = button.parentNode.nextElementSibling.textContent;
            navigator.clipboard.writeText(codeContent).then(() => {
                const originalHTML = button.innerHTML;
                button.innerHTML = '<i class="bi bi-check"></i> Copied!';
                button.style.color = '#28a745';
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.style.color = '';
                }, 2000);
            });
        }

        function showTypingIndicator() {
            const typingHTML = `
                <div class="message typing-indicator" id="typingIndicator">
                    <div class="message-avatar ai-avatar">
                        <i class="bi bi-robot"></i>
                    </div>
                    <div class="typing-dots">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            `;
            messageContainer.insertAdjacentHTML('beforeend', typingHTML);
            if (!isUserScrolling) {
                setTimeout(() => scrollToBottom(), 100);
            }
        }

        function hideTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) {
                indicator.remove();
            }
        }

        // Enhanced Gemini API call with conversation context
        async function callGeminiAPI(userMessage, contextMessages = []) {
            const API_KEY = 'AIzaSyCLHKexzeidZTL9Awa47-g4g-WrTI0qWgI';
            const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/${settings.model}:generateContent?key=${API_KEY}`;

            // Build conversation context
            let conversationContext = '';
            if (contextMessages.length > 0) {
                conversationContext = contextMessages.map(msg => {
                    const role = msg.role === 'user' ? 'Human' : 'Assistant';
                    return `${role}: ${msg.content}`;
                }).join('\n\n');
                conversationContext += '\n\nHuman: ' + userMessage;
            } else {
                conversationContext = userMessage;
            }

            // Prepare the request with context
            const requestBody = {
                contents: [
                    {
                        parts: [
                            {
                                text: conversationContext
                            }
                        ]
                    }
                ],
                generationConfig: {
                    temperature: settings.temperature,
                    maxOutputTokens: settings.maxTokens,
                }
            };

            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(requestBody)
            });

            if (!response.ok) {
                throw new Error(`API call failed: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.candidates && data.candidates[0] && data.candidates[0].content) {
                return data.candidates[0].content.parts[0].text;
            } else {
                throw new Error('Invalid response format');
            }
        }

        // Settings functions
        function switchSettingsTab(tabName) {
            // Update tab buttons
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.classList.toggle('active', tab.dataset.tab === tabName);
            });

            // Update tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = content.id === `${tabName}Tab` ? 'block' : 'none';
            });

            // Update account info when switching to account tab
            if (tabName === 'account') {
                updateAccountInfo();
            }
        }

        function updateSettingsUI() {
            document.getElementById('autoSaveSwitch').checked = settings.autoSave;
            document.getElementById('timestampsSwitch').checked = settings.showTimestamps;
            document.getElementById('contextLengthSelect').value = settings.contextLength;
            document.getElementById('modelSelect').value = settings.model;
            document.getElementById('temperatureRange').value = settings.temperature;
            document.getElementById('temperatureValue').textContent = settings.temperature;
            document.getElementById('maxTokensRange').value = settings.maxTokens;
            document.getElementById('maxTokensValue').textContent = settings.maxTokens;
            document.getElementById('themeSelect').value = settings.theme;
        }

        function applyTheme() {
            const root = document.documentElement;
            
            if (settings.theme === 'dark') {
                root.setAttribute('data-theme', 'dark');
            } else if (settings.theme === 'light') {
                root.setAttribute('data-theme', 'light');
            } else {
                // System theme
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                root.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
            }
        }

        async function updateStats() {
            if (!isLoggedIn) {
                document.getElementById('conversationCount').textContent = '0';
                document.getElementById('messageCount').textContent = '0';
                return;
            }

            try {
                const response = await fetch('../api/chat.php?action=get_chats');
                const data = await response.json();
                
                if (data.success) {
                    const conversationCount = data.chats.length;
                    let messageCount = 0;
                    
                    // Get message count for each conversation
                    for (const chat of data.chats) {
                        try {
                            const msgResponse = await fetch(`../api/chat.php?action=get_messages&chat_id=${chat.id}`);
                            const msgData = await msgResponse.json();
                            if (msgData.success) {
                                messageCount += msgData.messages.length;
                            }
                        } catch (error) {
                            console.error('Error getting message count:', error);
                        }
                    }
                    
                    document.getElementById('conversationCount').textContent = conversationCount;
                    document.getElementById('messageCount').textContent = messageCount;
                }
            } catch (error) {
                console.error('Error updating stats:', error);
                document.getElementById('conversationCount').textContent = '0';
                document.getElementById('messageCount').textContent = '0';
            }
        }

        async function exportConversations() {
            if (!isLoggedIn) return;

            try {
                const response = await fetch('../api/chat.php?action=get_chats');
                const data = await response.json();
                
                if (data.success) {
                    const exportData = {
                        exportDate: new Date().toISOString(),
                        totalConversations: data.chats.length,
                        conversations: []
                    };

                    // Get messages for each conversation
                    for (const chat of data.chats) {
                        try {
                            const msgResponse = await fetch(`../api/chat.php?action=get_messages&chat_id=${chat.id}`);
                            const msgData = await msgResponse.json();
                            if (msgData.success) {
                                exportData.conversations.push({
                                    ...chat,
                                    messages: msgData.messages
                                });
                            }
                        } catch (error) {
                            console.error('Error exporting conversation:', error);
                        }
                    }

                    exportData.totalMessages = exportData.conversations.reduce((acc, conv) => acc + conv.messages.length, 0);

                    const dataStr = JSON.stringify(exportData, null, 2);
                    const dataBlob = new Blob([dataStr], { type: 'application/json' });
                    const url = URL.createObjectURL(dataBlob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = `astro-conversations-${new Date().toISOString().split('T')[0]}.json`;
                    link.click();
                    URL.revokeObjectURL(url);
                }
            } catch (error) {
                console.error('Export failed:', error);
            }
        }

        async function clearHistory() {
            if (!isLoggedIn) return;

            if (confirm('Are you sure you want to clear all conversation history? This action cannot be undone.')) {
                try {
                    // Delete all conversations for the current user
                    const response = await fetch('../api/chat.php?action=get_chats');
                    const data = await response.json();
                    
                    if (data.success) {
                        for (const chat of data.chats) {
                            await fetch('../api/chat.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: `action=delete&chat_id=${chat.id}`
                            });
                        }
                    }

                    conversations = [];
                    currentConversationId = null;
                    updateConversationsList();
                    welcomeScreen.style.display = 'flex';
                    messageContainer.style.display = 'none';
                    updateStats();
                    settingsModal.hide();
                } catch (error) {
                    console.error('Clear history failed:', error);
                }
            }
        }

        // Rename conversation function
        async function renameConversation(id, currentTitle) {
            const titleElement = document.getElementById(`title-${id}`);
            if (!titleElement) return;

            // Create input field
            const input = document.createElement('input');
            input.type = 'text';
            input.value = currentTitle;
            input.className = 'rename-input';
            input.maxLength = 100;

            // Replace title with input
            titleElement.innerHTML = '';
            titleElement.appendChild(input);
            input.focus();
            input.select();

            // Handle save/cancel
            const saveRename = async () => {
                const newTitle = input.value.trim();
                if (newTitle && newTitle !== currentTitle) {
                    try {
                        const response = await fetch('../api/chat.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: `action=rename&chat_id=${id}&new_title=${encodeURIComponent(newTitle)}`
                        });
                        const data = await response.json();
                        
                        if (data.success) {
                            titleElement.textContent = newTitle;
                            await loadConversations();
                        } else {
                            titleElement.textContent = currentTitle;
                            console.error('Failed to rename conversation:', data.message);
                        }
                    } catch (error) {
                        titleElement.textContent = currentTitle;
                        console.error('Failed to rename conversation:', error);
                    }
                } else {
                    titleElement.textContent = currentTitle;
                }
            };

            const cancelRename = () => {
                titleElement.textContent = currentTitle;
            };

            // Event listeners
            input.addEventListener('blur', saveRename);
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    input.blur();
                } else if (e.key === 'Escape') {
                    e.preventDefault();
                    cancelRename();
                }
            });
        }

        // Update account info in settings
        function updateAccountInfo() {
            if (isLoggedIn && loggedInUser) {
                document.getElementById('accountUsername').textContent = loggedInUser.username || '-';
                document.getElementById('accountEmail').textContent = loggedInUser.email || '-';
            } else {
                document.getElementById('accountUsername').textContent = '-';
                document.getElementById('accountEmail').textContent = '-';
            }
        }

        // Initialize the application
        document.addEventListener('DOMContentLoaded', initApp);

        // Handle system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (settings.theme === 'system') {
                applyTheme();
            }
        });

        // Handle page visibility change to save data
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                saveSettings();
            }
        });

        // Handle beforeunload to save data
        window.addEventListener('beforeunload', () => {
            saveSettings();
        });
    </script>
</body>
</html>
