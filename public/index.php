<?php
// 1. Iniciar la sesión al principio del archivo
session_start();

$app = require __DIR__ . '/../bootstrap.php';

// 2. Inicializar el historial en la sesión si aún no existe
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

// 3. Procesar el envío de un nuevo mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Opción para limpiar/reiniciar el chat
    if (isset($_POST['action']) && $_POST['action'] === 'clear') {
        $_SESSION['chat_history'] = [];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $question = trim($_POST['question'] ?? '');

    if ($question !== '') {
        // Obtener la respuesta del modelo
        $answer = $app->getResponse($question);

        // Guardar la pregunta y la respuesta en el historial acumulado
        $_SESSION['chat_history'][] = [
            'user' => $question,
            'bot'  => $answer
        ];

        // Redirección POST-Redirect-GET para evitar que se reenvíe la pregunta si el usuario refresca la página (F5)
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Chat con IA</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Copia y pega esto dentro del <head> de tu index.php -->
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 640 512'%3E%3C!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Free Theme) --%3E%3Cpath d='M320 0c17.7 0 32 14.3 32 32V96H472c26.5 0 48 21.5 48 48V288c0 26.5-21.5 48-48 48H168c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48H288V32c0-17.7 14.3-32 32-32zM504 384H136c-22.1 0-40 17.9-40 40s17.9 40 40 40H504c22.1 0 40-17.9 40-40s-17.9-40-40-40zM320 160c-35.3 0-64 28.7-64 64s28.7 64 64 64 64-28.7 64-64-28.7-64-64-64z' fill='%2360a5fa'/%3E%3C/svg%3E">
</head>

<body>
    <header style="display: flex; justify-content: space-between; align-items: center; max-width: 800px; margin: 0 auto; width: 100%; padding: 0 1rem;">
        <h1>Chat con una IA</h1>
        
        <!-- Botón para borrar el historial si quieres empezar una nueva conversación -->
        <?php if (!empty($_SESSION['chat_history'])): ?>
            <form method="POST" style="position: static; margin: 0; width: auto;">
                <input type="hidden" name="action" value="clear">
                <button type="submit" style="background: transparent; color: #71717a; border: 1px solid #3f3f46; font-size: 0.8rem; border-radius: 0.5rem; width: auto; height: auto; padding: 0.3rem 0.6rem;" title="Nuevo Chat">
                    Limpiar
                </button>
            </form>
        <?php endif; ?>
    </header>

    <main class="chat-box" id="chat-box">
        <?php if (empty($_SESSION['chat_history'])): ?>
            <!-- Estado inicial si la conversación está vacía -->
            <div class="message bot">
                <div class="avatar avatar-bot">AI</div>
                <div class="bubble">
                    ¡Hola! Soy un modelo de lenguaje. ¿En qué te puedo ayudar hoy?
                </div>
            </div>
        <?php else: ?>
            <!-- Iterar sobre todo el historial acumulado en la sesión -->
            <?php foreach ($_SESSION['chat_history'] as $chat): ?>
                
                <!-- Mensaje del usuario -->
                <div class="message user">
                    <div class="bubble"><?php echo htmlspecialchars($chat['user']) ?></div>
                    <div class="avatar avatar-user">Tú</div>
                </div>

                <!-- Respuesta de la IA -->
                <div class="message bot">
                    <div class="avatar avatar-bot">AI</div>
                    <div class="bubble"><?php echo htmlspecialchars($chat['bot']) ?></div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <footer>
        <form method="POST">
            <div>
                <input type="text" id="question" name="question" placeholder="Pregunta algo..." autocomplete="off" required>
                <button type="submit">🡡</button>
            </div>
        </form>
        <p class="copyright">@copyright Victor Josue Rivas Zambrano</p>
    </footer>

    <script>
        // Mantiene el scroll en la parte inferior al cargar los nuevos mensajes
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</body>

</html>