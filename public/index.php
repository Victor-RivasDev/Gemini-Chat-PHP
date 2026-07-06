<?php
$app = require __DIR__ . '/../bootstrap.php';
$question = $_POST['question'] ?? '';
$answer = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $question){
    $answer = $app->getResponse($question);
}
?>
<html>
    <head>
        <title>Chat con IA</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Chat con una IA</h1>
        <form method="POST">
            <label for="question">Pregunta a la IA:</label>
            <input type="text" id="question" name="question" required>
            <button type="submit">Enviar</button>
            </form>
        <p class="answer">
        <strong>Respuesta: </strong>
            <?php echo htmlspecialchars($answer) ?>
        </p>

        <p class="copyright">@copyright Victor Josue Rivas Zambrano </p>
    </body>
</html>