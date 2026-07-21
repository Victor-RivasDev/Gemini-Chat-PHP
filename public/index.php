<?php
session_start();

$app = require __DIR__ . '/../bootstrap.php';

// Inicializar historial
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

// Procesar envío o acción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Opción para resetear la conversación
    if (isset($_POST['action']) && $_POST['action'] === 'clear') {
        $_SESSION['chat_history'] = [];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $question = trim($_POST['question'] ?? '');

    if ($question !== '') {
        $answer = $app->getResponse($question);

        $_SESSION['chat_history'][] = [
            'user' => $question,
            'bot'  => $answer
        ];

        // Redirección POST-Redirect-GET
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Chat con IA</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!-- Favicon con Robot en SVG integrado -->
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 640 512'%3E%3Cpath d='M320 0c17.7 0 32 14.3 32 32V96H472c26.5 0 48 21.5 48 48V288c0 26.5-21.5 48-48 48H168c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48H288V32c0-17.7 14.3-32 32-32zM504 384H136c-22.1 0-40 17.9-40 40s17.9 40 40 40H504c22.1 0 40-17.9 40-40s-17.9-40-40-40zM320 160c-35.3 0-64 28.7-64 64s28.7 64 64 64 64-28.7 64-64-28.7-64-64-64z' fill='%2360a5fa'/%3E%3C/svg%3E">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="chat-header">
        <h1>Chat con una IA</h1>
        <?php if (!empty($_SESSION['chat_history'])): ?>
            <form method="POST" class="clear-form">
                <input type="hidden" name="action" value="clear">
                <button type="submit" class="clear-btn" title="Reiniciar chat">Limpiar</button>
            </form>
        <?php endif; ?>
    </header>

    <main class="chat-box" id="chat-box">
        <?php if (empty($_SESSION['chat_history'])): ?>
            <div class="message bot">
                <div class="avatar avatar-bot">AI</div>
                <div class="bubble">
                    ¡Hola! Soy tu asistente de IA. ¿En qué puedo ayudarte hoy?
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($_SESSION['chat_history'] as $chat): ?>
                <div class="message user">
                    <div class="bubble"><?php echo htmlspecialchars($chat['user']); ?></div>
                    <div class="avatar avatar-user">Tú</div>
                </div>

                <div class="message bot">
                    <div class="avatar avatar-bot">AI</div>
                    <div class="bubble"><?php echo htmlspecialchars($chat['bot']); ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <footer>
        <form method="POST" class="input-form">
            <div class="input-container">
                <input 
                    type="text" 
                    id="question" 
                    name="question" 
                    placeholder="Pregunta algo..." 
                    autocomplete="off" 
                    required
                >
                <button type="submit" class="send-btn" aria-label="Enviar">
                    <!-- Icono de Flecha SVG para consistencia en móviles -->
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="19" x2="12" y2="5"></line>
                        <polyline points="5 12 12 5 19 12"></polyline>
                    </svg>
                </button>
            </div>
        </form>
        <p class="copyright">@copyright Victor Josue Rivas Zambrano</p>
    </footer>

    <script>
        // Auto-scroll al último mensaje
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</body>

</html>