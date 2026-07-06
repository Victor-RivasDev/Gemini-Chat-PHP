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
    </head>
    <body>
        <h1>Chat con IA</h1>
        <form method="POST">
            <label for="question">Pregunta a la IA:</label>
            <input type="text" id="question" name="question" required>
            <button type="submit">Enviar</button>
            </form>
        <p class="answer">
        <strong>Respuesta: </strong>
            <?php echo htmlspecialchars($answer) ?>
        </p>
    </body>
</html>