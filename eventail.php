<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Éventail-AI Chat Assistant - A new way to conceive your AI interactions. Create text chats, generate images, and search the web with AI assistance.">
    <meta name="keywords" content="AI chat, ChatGPT, DALL-E, AI assistant, image generation, web search, artificial intelligence">
    <meta name="author" content="Éventail-AI">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Éventail-AI Chat Assistant">
    <meta property="og:description" content="A new way to conceive your AI interactions with text, images, and web search capabilities.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://yourdomain.com">
    <meta property="og:image" content="https://yourdomain.com/eventail_AI.png">
    <meta property="og:locale" content="it_IT">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Éventail-AI Chat Assistant">
    <meta name="twitter:description" content="A new way to conceive your AI interactions">
    <meta name="twitter:image" content="https://yourdomain.com/eventail_AI.png">
    
    <title>Éventail-AI Chat Assistant</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #dc85ed;
            background: radial-gradient(circle, rgba(220, 133, 237, 1) 0%, rgba(175, 13, 219, 1) 39%);
            min-height: 100vh;
            display: flex;
        }

        /* ===== SIMPLIFIED SIDEBAR ===== */
        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 500;
        }

        .sidebar-header {
            padding: 30px 20px;
            background: linear-gradient(135deg, rgba(220, 133, 237, 1) 0%, rgba(175, 13, 219, 1) 39%);
            color: white;
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-actions {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 20px;
            overflow-y: auto;
        }

        .btn-sidebar {
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            background: radial-gradient(circle, rgba(220, 133, 237, 1) 0%, rgba(175, 13, 219, 1) 39%);
            color: white;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-sidebar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(220, 133, 237, 0.4);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
        }

        .sidebar-footer p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .sidebar-footer small {
            color: #999;
            font-size: 11px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
            
        .header img {
            max-width: 350px;
            height: auto;
        }    

        h1 {
            font-size: 32px;
            color: #2c2c2c;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #222;
            font-size: 18px;
        }

        /* Session Warning */
        .session-warning {
            background: rgba(255, 255, 255, 0.9);
            border-left: 4px solid #ffa502;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .session-warning-icon {
            font-size: 24px;
        }

        .session-warning-text {
            flex: 1;
            font-size: 13px;
            color: #666;
        }

        .session-warning-text strong {
            color: #e63946;
        }

        /* Prompt Area */
        .prompt-area {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 16px;
            margin-bottom: 40px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        }

        .prompt-container {
            display: flex;
            gap: 12px;
            align-items: center;
        }
            
        .triggers {
            width: 280px;
            display: flex;
            justify-content: flex-start;
            margin: 4px;
        }
        
        .triggers span {
            font-size: 20px;     
            cursor: pointer;
            border: 1px solid transparent;
            margin-right: 4px; 
            transition: all .8s ease;    
        }    

        .triggers span:hover {
            border: 1px solid rebeccapurple;
        }    
            
        #user-input {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s;
            background: white;
        }

        #user-input:focus {
            border-color: #6B9BD1;
            box-shadow: 0 0 0 3px rgba(107, 155, 209, 0.1);
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-primary {
            background: radial-gradient(circle, rgba(220, 133, 237, 1) 0%, rgba(175, 13, 219, 1) 39%);
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(107, 155, 209, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #dc85ed;
            border: 2px solid #e0e0e0;
        }

        .btn-secondary:hover:not(:disabled) {
            background: #f5f5f5;
            border-color: #dc85ed;
        }

        /* Cards Grid */
        .cards-section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 24px;
            color: #222;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .cards-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            gap: 12px;
            perspective: 1000px;
            padding: 16px 20px;
            min-height: 360px;
        }

        .chat-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            padding: .5rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            height: 220px;
            width: 220px;
            display: flex;
            flex-direction: column;
            transform-origin: bottom center;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 0 60px rgba(255, 255, 255, 0.3);
        }

        /* Effetto iridescente bolla di sapone */
        .chat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                linear-gradient(45deg, 
                    transparent 30%,
                    rgba(255, 0, 255, 0.2) 40%,
                    rgba(0, 255, 255, 0.2) 50%,
                    rgba(255, 255, 0, 0.2) 60%,
                    transparent 70%),
                linear-gradient(135deg,
                    rgba(255, 0, 150, 0.15) 0%,
                    rgba(0, 200, 255, 0.15) 25%,
                    rgba(150, 255, 0, 0.15) 50%,
                    rgba(255, 150, 0, 0.15) 75%,
                    rgba(255, 0, 200, 0.15) 100%);
            animation: rotate 8s linear infinite;
            opacity: 0.5;
            mix-blend-mode: screen;
            pointer-events: none;
            z-index: 1;
        }

        /* Lens flare/glare luminoso principale */
        .chat-card::after {
            content: '';
            position: absolute;
            top: 15%;
            right: 20%;
            width: 80px;
            height: 80px;
            background: radial-gradient(
                circle at center,
                rgba(255, 255, 255, 0.8) 0%,
                rgba(255, 255, 255, 0.5) 20%,
                rgba(255, 255, 255, 0.2) 40%,
                transparent 70%
            );
            border-radius: 50%;
            filter: blur(8px);
            animation: pulse-glare 3s ease-in-out infinite;
            pointer-events: none;
            mix-blend-mode: overlay;
            z-index: 1;
        }

        /* Riflesso secondario più piccolo */
        .chat-card .secondary-glare {
            position: absolute;
            top: 40%;
            left: 25%;
            width: 40px;
            height: 40px;
            background: radial-gradient(
                circle at center,
                rgba(255, 255, 255, 0.6) 0%,
                rgba(255, 255, 255, 0.3) 30%,
                transparent 60%
            );
            border-radius: 50%;
            filter: blur(6px);
            animation: pulse-glare 3s ease-in-out infinite 0.5s;
            pointer-events: none;
            mix-blend-mode: overlay;
            z-index: 1;
        }

        .chat-card:hover {
            transform: rotate(0deg) translateY(-20px) scale(1.05) !important;
            box-shadow: 
                0 20px 50px rgba(0,0,0,0.2),
                inset 0 0 80px rgba(255, 255, 255, 0.4);
            border-color: #6B9BD1;
            z-index: 10;
        }

        .chat-card:hover::before {
            animation-duration: 4s;
            opacity: 0.7;
        }

        .chat-card:hover::after {
            animation-duration: 2s;
        }

        .chat-card.active {
            border-color: #6B9BD1;
            background: rgba(107, 155, 209, 0.15);
        }

        .chat-card.active::before {
            opacity: 0.6;
        }

        .chat-card.processing {
            border-color: #ffa502;
            background: rgba(255, 165, 2, 0.15);
        }

        .chat-card.processing .processing-indicator {
            content: '●';
            position: absolute;
            top: 10px;
            right: 10px;
            color: #ffa502;
            font-size: 20px;
            animation: pulse 1.5s ease-in-out infinite;
            z-index: 3;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        @keyframes pulse-glare {
            0%, 100% {
                opacity: 0.6;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.1);
            }
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
        }

        .card-title {
            font-size: 12px;
            padding: 4px;
            border-radius: 4px; 
            border: 2px solid black;    
            font-weight: 400;
            color: #000;
            background: #fff;    
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .delete-btn {
            background: #dc85ed;
            color: white;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
            margin-left: 10px;
        }

        .delete-btn:hover {
            background: #e63946;
            transform: scale(1.1);
        }

        .card-preview {
            color: #000;
            font-size: 12px;
            line-height: 1.5;
            overflow: hidden;
            margin-bottom: 8px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            position: relative;
            z-index: 2;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #000;
            position: relative;
            z-index: 2;
        }

        /* Chat Modal */
        .chat-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
            padding: 20px;
        }

        .chat-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 900px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-header {
            padding: 25px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c2c2c;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 28px;
            color: #999;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .close-btn:hover {
            background: #f5f5f5;
            color: #333;
        }

        .chat-history {
            background: radial-gradient(circle, rgba(220, 133, 237, 1) 0%, rgba(175, 13, 219, 1) 39%);    
            border-bottom: 2px solid black;    
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .message {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 12px;
            max-width: 90%;
            word-wrap: break-word;
        }

        .user-message {
            background: white;
            color: #222;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }

        .chatgpt-message {
            width: 100%;
            background: #f5f5f5;
            color: #2c2c2c;
            border-bottom-left-radius: 4px;
            position: relative;
            padding-right: 70px;
        }

        .chatgpt-message p {
            margin: 0 0 10px 0;
            line-height: 1.6;
        }

        .chatgpt-message p:last-child {
            margin-bottom: 0;
        }

        .chatgpt-message pre {
            background: white;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            margin-top: 10px;
        }

        .chatgpt-message code {
            background: rgba(255, 255, 255, 0.8);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }

        .chatgpt-message pre code {
            background: none;
            padding: 0;
        }

        .message-code-block {
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .chatgpt-message pre {
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .copy-btn {
            align-self: flex-end;
            margin-top: 8px;
            background: white;
            border: 1px solid #e0e0e0;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .copy-btn:hover {
            background: #dc85ed;
            color: white;
            border-color: #6B9BD1;
        }

        .modal-image-wrapper {
            text-align: center;
            margin-top: 12px;
        }

        .modal-image-wrapper img {
            max-width: 100%;
            border-radius: 8px;
        }

        .citations-block {
            margin-top: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
        }

        .citations-block p {
            font-weight: bold;
            margin-bottom: 8px;
        }

        .citations-block a {
            display: block;
            color: #007BFF;
            text-decoration: none;
            margin-bottom: 4px;
        }

        .citations-block a:hover {
            text-decoration: underline;
        }

        #typing-indicator {
            color: #999;
            font-style: italic;
            padding: 15px 20px;
        }

        /* ===== MODAL STYLES ===== */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
            padding: 20px;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 500px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-content h3 {
            margin-bottom: 20px;
            color: #2c2c2c;
            font-size: 20px;
        }

        .modal-content p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .modal-content input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s;
            margin-bottom: 10px;
        }

        .modal-content input:focus {
            border-color: #dc85ed;
            box-shadow: 0 0 0 3px rgba(220, 133, 237, 0.1);
        }

        .modal-content small {
            display: block;
            color: #999;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .modal-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .modal-actions button:first-child {
            background: radial-gradient(circle, rgba(220, 133, 237, 1) 0%, rgba(175, 13, 219, 1) 39%);
            color: white;
        }

        .modal-actions button:first-child:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 133, 237, 0.4);
        }

        .modal-actions button:last-child {
            background: #f0f0f0;
            color: #333;
        }

        .modal-actions button:last-child:hover {
            background: #e0e0e0;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #333;
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            z-index: 2000;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Export Button */
        .export-btn {
            background: #6B9BD1;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            margin-left: 10px;
            transition: all 0.2s;
        }

        .export-btn:hover {
            background: #5a8bc0;
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }

            .prompt-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .triggers {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Simplified Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2 id="greeting">Benvenuto!</h2>
        </div>
        
        <div class="sidebar-actions">
            <button id="setup-api-key-btn" class="btn-sidebar">⚙️ Setup API Key</button>
            <a href="users-generations.html" class="btn-sidebar">🖼️ Public Generations</a>
        </div>
        
        <div class="sidebar-footer">
            <p>Éventail-AI © 2026</p>
            <small>A new way to conceive your AI interactions</small>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <img src="eventail_AI.png" alt="Éventail-AI Logo">
                <h1>Éventail-AI Chat Assistant</h1>
                <p class="subtitle"><i>A new way to conceive your AI interactions</i></p>
            </div>

            <!-- Session Warning -->
            <div class="session-warning">
                <div class="session-warning-icon">⚠️</div>
                <div class="session-warning-text">
                    <strong>Le conversazioni sono temporanee:</strong> I messaggi vengono salvati solo nella sessione corrente (max 50). Ricarica la pagina e perderai la conversazione. Esporta la conversazione prima di chiudere!
                </div>
            </div>

            <!-- Prompt Area -->
            <div class="prompt-area">
                <div class="prompt-container">
                    <input type="text" id="user-input" placeholder="Insert your idea..." onkeypress="verifyEnter(event)">
                    <button class="btn btn-primary" id="send-btn" onclick="sendMessage()">Send</button>
                    <button class="btn btn-secondary" onclick="createNewTopic()">New Topic</button>
                </div>
                <div class="triggers">
                    <span id="text">📋</span>
                    <span id="image">🖼️</span>
                    <span id="web">🌎</span>
                    <span id="feedback">Text chat</span>
                </div>
            </div>

            <!-- Cards Section -->
            <div class="cards-section">
                <h2 class="section-title">Votre éventail:</h2>
                <div class="cards-grid" id="cards-container">
                    <!-- Cards will be generated here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Modal -->
    <div class="chat-modal" id="chat-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Conversation card</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="chat-history" id="chat-container">
                <!-- Messages will appear here -->
            </div>
            <div class="modal-prompt" id="modal-prompt" style="display:flex; padding:20px; border-top:1px solid #e0e0e0; gap:10px;">
                <input type="text" id="modal-user-input" placeholder="Write your idea..." style="flex:1; padding:10px; border-radius:8px; border:1px solid #ddd;" onkeypress="verifyEnterModal(event)">
                <button class="btn btn-primary" id="modal-send-btn" onclick="sendMessageFromModal()">Send</button>
                <button class="export-btn" onclick="exportConversation()">📥 Export</button>
            </div>
        </div>
    </div>

    <!-- API Key Modal -->
    <div class="modal" id="api-key-modal">
        <div class="modal-content">
            <h3>Setup OpenAI API Key</h3>
            <input type="password" id="api-key-input" placeholder="sk-...">
            <small>Salvato nel tuo browser (localStorage)</small>
            <div class="modal-actions">
                <button onclick="saveApiKey()">Salva</button>
                <button onclick="closeApiKeyModal()">Annulla</button>
            </div>
        </div>
    </div>

    <!-- Image Warning Modal -->
    <div class="modal" id="image-warning-modal">
        <div class="modal-content">
            <h3>⚠️ Public Image Generation</h3>
            <p>L'immagine generata sarà visibile pubblicamente a <strong>TUTTI</strong> gli utenti nella pagina "Public Generations".</p>
            <p><strong>Sei d'accordo?</strong></p>
            <div class="modal-actions">
                <button onclick="proceedImageGeneration()">Genera e Condividi</button>
                <button onclick="closeImageWarning()">Annulla</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

<script>
// Global variables
let conversations = [];
let currentConversationId = null;
let chatMemory = [];
let typeText = true;
let typeImage = false;
let typeWeb = false;
let feedback = document.getElementById('feedback');
const MAX_MESSAGES = 50;

const textSpan = document.getElementById('text');
const imageSpan = document.getElementById('image');
const webSpan = document.getElementById('web');

// Imposta per chat testuale (default)
textSpan.style.border = "1px solid red";

textSpan.addEventListener('click', () => {
    typeText = true;
    typeImage = false;
    typeWeb = false;
    textSpan.style.border = "1px solid red";
    imageSpan.style.border = "1px solid transparent";
    webSpan.style.border = "1px solid transparent";
    feedback.innerText = 'Text chat';        
});        

imageSpan.addEventListener('click', () => {
    typeText = false;
    typeImage = true;
    typeWeb = false;
    textSpan.style.border = "1px solid transparent";
    imageSpan.style.border = "1px solid red";
    webSpan.style.border = "1px solid transparent"; 
    feedback.innerText = 'Image generation';         
}); 

webSpan.addEventListener('click', () => {
    typeText = false;
    typeImage = false;
    typeWeb = true;
    textSpan.style.border = "1px solid transparent";
    imageSpan.style.border = "1px solid transparent";
    webSpan.style.border = "1px solid red"; 
    feedback.innerText = 'Web search';         
}); 

// Initialize
async function init() {
    loadApiKey();
    initSidebar();
    cleanupUploads();

    // Check for shared conversation in URL (legacy support)
    const urlParams = new URLSearchParams(window.location.search);
    const sharedToken = urlParams.get('conversation');
    if (sharedToken) {
        showToast('Questa versione non supporta più le conversazioni condivise. Le conversazioni sono ora temporanee.');
    }

    // Show warning if no API key
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('Configura la tua API key da ⚙️ Setup per usare le funzionalità AI');
    }
}

// ===== SIDEBAR FUNCTIONS =====
function initSidebar() {
    setGreeting();
    
    document.getElementById('setup-api-key-btn').addEventListener('click', openApiKeyModal);
}

function setGreeting() {
    const userName = localStorage.getItem('eventailUserName');
    const greetingEl = document.getElementById('greeting');
    
    if (userName && userName.trim()) {
        greetingEl.textContent = `Ciao, ${userName}!`;
    } else {
        greetingEl.textContent = 'Benvenuto!';
    }
}

// ===== API KEY FUNCTIONS =====
function openApiKeyModal() {
    const apiKey = getApiKeyForOpenAI();
    if (apiKey) {
        document.getElementById('api-key-input').value = apiKey;
    }
    document.getElementById('api-key-modal').classList.add('active');
}

function closeApiKeyModal() {
    document.getElementById('api-key-modal').classList.remove('active');
}

function saveApiKey() {
    const apiKey = document.getElementById('api-key-input').value.trim();
    
    if (!apiKey) {
        showToast('Inserisci una API key valida');
        return;
    }
    
    localStorage.setItem('eventailAiApiKey', apiKey);
    closeApiKeyModal();
    showToast('✅ API Key salvata!');
}

function loadApiKey() {
    // No longer loads from config.txt - uses localStorage only
    console.log('API Key loaded from localStorage');
}

function getApiKeyForOpenAI() {
    return localStorage.getItem('eventailAiApiKey') || '';
}

// ===== IMAGE WARNING MODAL =====
let pendingImagePrompt = null;

function openImageWarning(prompt) {
    pendingImagePrompt = prompt;
    document.getElementById('image-warning-modal').classList.add('active');
}

function closeImageWarning() {
    pendingImagePrompt = null;
    document.getElementById('image-warning-modal').classList.remove('active');
}

async function proceedImageGeneration() {
    closeImageWarning();
    
    if (pendingImagePrompt) {
        const prompt = pendingImagePrompt;
        pendingImagePrompt = null;
        
        const conversation = conversations.find(c => c.id === currentConversationId);
        if (!conversation) {
            conversation = createNewConversation();
        }
        
        conversation.processing = true;
        renderCards();
        
        const imagePath = await generateCardImage(prompt);
        
        if (imagePath) {
            conversation.imageUrl = imagePath;
            conversation.type = 'image';
            showToast('✅ Immagine condivisa pubblicamente!');
        } else {
            showToast('❌ Errore nella generazione dell\'immagine');
        }
        
        conversation.processing = false;
        renderCards();
    }
}

// ===== CLEANUP UPLOADS =====
async function cleanupUploads() {
    try {
        const response = await fetch('/php/cleanup-uploads.php');
        if (response.ok) {
            const result = await response.json();
            console.log('Cleanup result:', result);
        }
    } catch (error) {
        console.warn('Cleanup failed:', error);
    }
}

// ===== CONVERSATION MANAGEMENT =====
function createNewConversation() {
    const newId = Date.now().toString();
    const newConversation = {
        id: newId,
        title: `Nuova Conversazione`,
        messages: [],
        chatMemory: [
            { role: 'system', content: "You are a general-knowledgebase skilled assistant who receives an input from the user and makes everything possible to find a correct answer or a valid help. You will not invent or make-up answers if you are not able to answer." }
        ],
        createdAt: new Date().toISOString(),
        updatedAt: new Date().toISOString(),
        processing: false,
        imageUrl: null,
        type: null
    };
    
    conversations.unshift(newConversation);
    currentConversationId = newId;
    chatMemory = [...newConversation.chatMemory];
    
    return newConversation;
}

function createNewTopic() {
    createNewConversation();
    renderCards();
}

function verifyEnter(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

function verifyEnterModal(event) {
    if (event.key === 'Enter') {
        sendMessageFromModal();
    }
}

async function sendMessage() {
    const input = document.getElementById('user-input');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Check API key for non-image operations
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey && !typeImage) {
        showToast('⚠️ Configura la tua API Key da ⚙️ Setup per usare questa feature');
        return;
    }
    
    // For image generation, show warning modal
    if (typeImage) {
        openImageWarning(message);
        input.value = '';
        return;
    }
    
    let conversation = conversations.find(c => c.id === currentConversationId);
    if (!conversation) {
        conversation = createNewConversation();
    }
    
    input.value = '';
    
    conversation.processing = true;
    renderCards();
    
    if (typeWeb) {
        await getChatGPTResponseWeb(message, conversation);
    } else {
        await getChatGPTResponse(message, conversation);
    }
    
    // Limit chat memory to MAX_MESSAGES
    limitChatMemory();
    
    renderCards();
}

async function sendMessageFromModal() {
    const input = document.getElementById('modal-user-input');
    const message = input.value.trim();
    
    if (!message) return;
    
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('⚠️ Configura la tua API Key da ⚙️ Setup per usare questa feature');
        return;
    }
    
    let conversation = conversations.find(c => c.id === currentConversationId);
    if (!conversation) return;
    
    input.value = '';
    
    // Show user message in modal
    showMessageInModal('user', message);
    
    // Add to conversation
    conversation.messages.push({ role: 'user', content: message });
    
    // Update chat memory
    chatMemory.push({ role: 'user', content: message });
    
    if (typeWeb) {
        await getChatGPTResponseWeb(message, conversation);
    } else {
        await getChatGPTResponse(message, conversation);
    }
    
    // Limit chat memory
    limitChatMemory();
    
    renderCards();
}

function limitChatMemory() {
    // Keep only last MAX_MESSAGES (excluding system message)
    if (chatMemory.length > MAX_MESSAGES + 1) { // +1 for system message
        chatMemory = [chatMemory[0], ...chatMemory.slice(-(MAX_MESSAGES))];
    }
}

async function getChatGPTResponse(userInput, conversation) {
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('⚠️ API Key non configurata');
        return;
    }

    const typingIndicator = document.createElement('p');
    typingIndicator.id = 'typing-indicator';
    typingIndicator.textContent = 'Scrivendo...';
    
    const chatContainer = document.getElementById('chat-container');
    if (chatContainer && document.getElementById('chat-modal').classList.contains('active')) {
        chatContainer.appendChild(typingIndicator);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    try {
        const response = await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + apiKey
            },
            body: JSON.stringify({
                model: 'gpt-4o-mini',
                messages: [...chatMemory, { role: 'user', content: userInput }]
            })
        });

        if (!response.ok) throw new Error('Errore durante la richiesta API.');

        const data = await response.json();
        if (typingIndicator.parentNode) typingIndicator.remove();

        const chatGPTResponse = data.choices?.[0]?.message?.content?.trim() || '';

        // Add to conversation
        conversation.messages.push({
            role: 'assistant',
            content: chatGPTResponse
        });
        
        conversation.updatedAt = new Date().toISOString();
        
        // Update memory
        chatMemory.push({ role: 'user', content: userInput });
        chatMemory.push({ role: 'assistant', content: chatGPTResponse });

        // Show in modal if open
        if (document.getElementById('chat-modal').classList.contains('active')) {
            showMessageInModal('assistant', chatGPTResponse);
        }

        conversation.processing = false;
        limitChatMemory();
        
    } catch (error) {
        console.error(error);
        if (typingIndicator.parentNode) typingIndicator.remove();
        showToast('Errore nella comunicazione con l\'API.');
    }
}

async function generateCardImage(prompt) {
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('⚠️ API Key non configurata');
        return null;
    }

    try {
        const imgResponse = await fetch("https://api.openai.com/v1/images/generations", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + apiKey
            },
            body: JSON.stringify({
                model: "dall-e-2",
                prompt: prompt,
                size: "512x512",
                response_format: "b64_json"
            })
        });
        
        if (!imgResponse.ok) {
            console.warn("Errore generazione immagine");
            return null;
        }
        
        const data = await imgResponse.json();
        const base64 = data.data[0].b64_json;

        const saveResponse = await fetch("php/save-card-image.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ 
                imageData: base64,
                prompt: prompt,
                timestamp: new Date().toISOString()
            })
        });
        
        const result = await saveResponse.json();
        if (result.success) {
            console.log("Immagine salvata:", result.filepath);
            return result.filepath;
        } else {
            console.warn("Errore salvataggio immagine:", result.error);
            return null;
        }
    } catch (err) {
        console.error("Errore generazione immagine:", err);
        return null;
    }
}

async function getChatGPTResponseWeb(userInput, conversation) {
    const apiKey = getApiKeyForOpenAI();
    if (!apiKey) {
        showToast('⚠️ API Key non configurata');
        return;
    }

    const chatContainer = document.getElementById('chat-container');

    const typingIndicator = document.createElement('p');
    typingIndicator.id = 'typing-indicator';
    typingIndicator.textContent = 'Ricerca in corso...';
    if (chatContainer) {
        chatContainer.appendChild(typingIndicator);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    try {
        const response = await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + apiKey
            },
            body: JSON.stringify({
                model: 'gpt-4o-mini-search-preview',
                web_search_options: { search_context_size: 'medium' },
                messages: [...chatMemory, { role: 'user', content: userInput }]
            })
        });

        if (!response.ok) throw new Error('Errore durante la richiesta API.');

        const data = await response.json();
        if (typingIndicator.parentNode) typingIndicator.remove();

        const chatGPTResponse = data.choices?.[0]?.message?.content?.trim() || '';
        const annotations = data.choices?.[0]?.message?.annotations || [];
        const citations = [];

        // Extract citations
        annotations.forEach(a => {
            if (a.type === 'url_citation' && a.url_citation?.url) {
                citations.push({
                    title: a.url_citation.title || a.url_citation.url,
                    url: a.url_citation.url
                });
            }
        });

        // Clean response
        let cleanResponse = cleanResponseText(chatGPTResponse, annotations);

        // Update conversation
        conversation.messages.push({
            role: 'assistant',
            content: cleanResponse,
            citations: citations
        });
        conversation.updatedAt = new Date().toISOString();
        
        // Update memory
        chatMemory.push({ role: 'user', content: userInput });
        chatMemory.push({ role: 'assistant', content: cleanResponse });

        // Show in modal if open
        if (document.getElementById('chat-modal').classList.contains('active')) {
            showMessageInModal('assistant', cleanResponse);
            if (citations.length > 0) {
                appendCitationsToModal(citations);
            }
        }

        conversation.processing = false;
        limitChatMemory();

    } catch (error) {
        console.error(error);
        if (typingIndicator.parentNode) typingIndicator.remove();
        showToast('Errore nella comunicazione con l\'API Web.');
    }
}

function cleanResponseText(response, citations) {
    const citationUrls = citations
        .filter(a => a.type === 'url_citation' && a.url_citation?.url)
        .map(a => a.url_citation.url);

    let cleaned = response;
    citationUrls.forEach(url => {
        const urlRegex = new RegExp(url.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
        cleaned = cleaned.replace(urlRegex, '');
    });

    cleaned = cleaned
        .replace(/https?:\/\/[^\s]+/g, '')
        .replace(/[ ]{2,}/g, ' ')
        .replace(/\*\*(.*?)\*\*/g, '$1')
        .trim();

    return cleaned;
}

function appendCitationsToModal(citations) {
    const container = document.getElementById('chat-container');
    if (!container) return;

    const block = document.createElement('div');
    block.className = 'citations-block';

    const title = document.createElement('p');
    title.textContent = 'Fonti:';
    block.appendChild(title);

    citations.forEach(c => {
        const link = document.createElement('a');
        link.href = c.url;
        link.target = '_blank';
        link.rel = 'noopener noreferrer';
        link.textContent = c.title;
        block.appendChild(link);
    });

    container.appendChild(block);
    container.scrollTop = container.scrollHeight;
}

function escapeHTML(str) {
    return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
}

function showMessageInModal(role, message) {
    const container = document.getElementById('chat-container');
    const msgDiv = document.createElement('div');
    msgDiv.className = 'message ' + (role === 'user' ? 'user-message' : 'chatgpt-message');
    
    if (role === 'assistant') {
        msgDiv.innerHTML = formatMessage(message);
        
        // Add copy button
        const copyBtn = document.createElement('button');
        copyBtn.className = 'copy-btn';
        copyBtn.textContent = 'Copia';
        copyBtn.onclick = () => copyToClipboard(message);
        msgDiv.appendChild(copyBtn);
    } else {
        msgDiv.textContent = message;
    }
    
    container.appendChild(msgDiv);
    container.scrollTop = container.scrollHeight;
}

function formatMessage(text) {
    // Format code blocks
    const codeBlockRegex = /```(\w*)\n([\s\S]*?)```/g;
    text = text.replace(codeBlockRegex, (match, lang, code) => {
        return `<div class="message-code-block">
            <pre><code class="language-${lang}">${escapeHTML(code)}</code></pre>
        </div>`;
    });
    
    // Format inline code
    text = text.replace(/`([^`]+)`/g, '<code>$1</code>');
    
    // Format paragraphs
    text = text.split('\n\n').map(p => `<p>${p.replace(/\n/g, '<br>')}</p>`).join('');
    
    return text;
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Copiato!');
    }).catch(() => {
        showToast('Errore nella copia');
    });
}

function displayConversationMessages(conversation) {
    const container = document.getElementById('chat-container');
    container.innerHTML = '';

    if (conversation.type === 'image') {
        const userPrompt = conversation.messages.find(m => m.role === 'user');
        if (userPrompt) {
            const userMsg = document.createElement('div');
            userMsg.className = 'message user-message';
            userMsg.textContent = userPrompt.content;
            container.appendChild(userMsg);
        }

        if (conversation.imageUrl) {
            const imgWrapper = document.createElement('div');
            imgWrapper.className = 'modal-image-wrapper';
            const img = document.createElement('img');
            img.src = conversation.imageUrl;
            imgWrapper.appendChild(img);
            container.appendChild(imgWrapper);
        }
    } else {
        conversation.messages.forEach(msg => {
            showMessageInModal(msg.role, msg.content);
            
            if (msg.citations && msg.citations.length > 0) {
                appendCitationsToModal(msg.citations);
            }
        });
    }
}

// ===== RENDER CARDS =====
function renderCards() {
    const container = document.getElementById('cards-container');
    container.innerHTML = '';

    if (conversations.length === 0) {
        container.innerHTML = '<p style="text-align: center; color: #000; width: 100%;">Nessuna conversazione. Inizia creando un nuovo topic!</p>';
        return;
    }

    conversations.forEach(conv => {
        const card = document.createElement('div');
        const isActive = conv.id === currentConversationId;
        const isProcessing = conv.processing || false;
        card.className = 'chat-card' +
            (isActive ? ' active' : '') +
            (isProcessing ? ' processing' : '');

        // Background image
        if (conv.imageUrl) {
            card.style.backgroundImage = `url(${conv.imageUrl})`;
            card.style.backgroundSize = 'cover';
            card.style.backgroundPosition = 'center';
            card.style.color = '#000';
        }

        const firstMessage = conv.messages.find(m => m.role === 'user');
        const lastMessage = conv.messages[conv.messages.length - 1];

        let preview = '';
        if (conv.type === 'image') {
            preview = 'Immagine generata';
        } else if (lastMessage && lastMessage.role === 'assistant') {
            preview = lastMessage.content.substring(0, 250);
        } else if (firstMessage) {
            preview = firstMessage.content.substring(0, 250);
        } else {
            preview = 'Nessun messaggio ancora';
        }

        const messagesCount = conv.messages.filter(m => m.role !== 'system').length;
        const date = new Date(conv.updatedAt).toLocaleDateString('it-IT', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });

        const cardHeader = document.createElement('div');
        cardHeader.className = 'card-header';

        const cardTitle = document.createElement('div');
        cardTitle.className = 'card-title';
        cardTitle.textContent = conv.title;

        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'delete-btn';
        deleteBtn.textContent = '×';
        deleteBtn.onclick = (e) => deleteConversation(conv.id, e);

        const cardPreview = document.createElement('div');
        cardPreview.className = 'card-preview';
        cardPreview.textContent = preview;

        const cardMeta = document.createElement('div');
        cardMeta.className = 'card-meta';

        const messagesSpan = document.createElement('span');
        messagesSpan.textContent = `${messagesCount} messaggi`;

        const dateSpan = document.createElement('span');
        dateSpan.textContent = date;

        cardMeta.appendChild(messagesSpan);
        cardMeta.appendChild(dateSpan);
        cardHeader.appendChild(cardTitle);
        cardHeader.appendChild(deleteBtn);
        card.appendChild(cardHeader);
        card.appendChild(cardPreview);
        card.appendChild(cardMeta);

        card.onclick = (e) => {
            if (!e.target.classList.contains('delete-btn')) {
                openModal(conv.id);
            }
        };

        container.appendChild(card);
    });

    // Fan effect
    const cards = container.querySelectorAll('.chat-card');
    const total = cards.length;

    if (total === 1) {
        cards[0].style.transform = 'rotate(0deg) translateY(0px)';
    } else {
        const screenWidth = window.innerWidth;
        let maxAngle, offsetMultiplier;
        
        if (screenWidth < 768) {
            maxAngle = 5;
            offsetMultiplier = 0.5;
        } else if (screenWidth < 1024) {
            maxAngle = 8;
            offsetMultiplier = 0.7;
        } else {
            maxAngle = 10;
            offsetMultiplier = 0.8;
        }
        
        cards.forEach((card, i) => {
            const angle = ((i / (total - 1)) - 0.5) * 2 * maxAngle;
            const offsetY = Math.abs(angle) * offsetMultiplier;
            card.style.transform = `rotate(${angle}deg) translateY(${offsetY}px)`;
        });
    }
}

function deleteConversation(id, event) {
    event.stopPropagation();
    if (confirm('Eliminare questa conversazione?')) {
        conversations = conversations.filter(c => c.id !== id);
        if (currentConversationId === id) currentConversationId = null;
        renderCards();
    }
}

function openModal(conversationId) {
    currentConversationId = conversationId;
    const conversation = conversations.find(c => c.id === conversationId);
    if (!conversation) return;

    document.getElementById('modal-title').textContent = conversation.title;
    const modal = document.getElementById('chat-modal');
    const container = document.getElementById('chat-container');
    container.innerHTML = '';
    modal.classList.add('active');

    // Restore memory for this conversation
    chatMemory = conversation.chatMemory || [
        { role: 'system', content: "You are a general-knowledgebase skilled assistant who receives an input from the user and makes everything possible to find a correct answer or a valid help. You will not invent or make-up answers if you are not able to answer." }
    ];

    // Modal visibility based on type
    if (conversation.type === 'image') {
        document.getElementById('modal-prompt').style.display = 'none';
    } else {
        document.getElementById('modal-prompt').style.display = 'flex';
    }

    displayConversationMessages(conversation);
    renderCards();
}

function closeModal() {
    document.getElementById('chat-modal').classList.remove('active');
    document.getElementById('chat-container').innerHTML = '';
}

// ===== EXPORT CONVERSATION =====
function exportConversation() {
    const conversation = conversations.find(c => c.id === currentConversationId);
    if (!conversation) {
        showToast('Nessuna conversazione da esportare');
        return;
    }

    // Export as JSON
    const json = JSON.stringify(conversation, null, 2);
    const blob = new Blob([json], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `conversation_${conversation.createdAt.replace(/[:.]/g, '-')}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);

    showToast('✅ Conversazione esportata!');
}

// ===== TOAST NOTIFICATION =====
function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// Recalculate fan on resize
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        renderCards();
    }, 250);
});

window.onload = init;
</script>
</body>
</html>
