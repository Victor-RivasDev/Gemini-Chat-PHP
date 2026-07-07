<?php
$app = require __DIR__ . '/../bootstrap.php';
$question = $_POST['question'] ?? '';
$answer = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $question) {
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
    <p class="answer">
        <?php echo htmlspecialchars($answer) ?>
    </p>
    <form method="POST">
        <div>
            <input type="text" id="question" name="question" placeholder="Pregunta algo..." autocomplete="off" required>
            <button type="submit">🡡</button>
        </div>
    </form>

    <p class="copyright">@copyright Victor Josue Rivas Zambrano </p>
</body>

</html>