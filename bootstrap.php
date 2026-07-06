<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// Cambiamos load() por safeLoad() para soportar producción
$dotenv->safeLoad();


use App\FakeAiService;
use App\OllamaAiService;
use App\OpenRouterService;


$aiService = new App\OpenRouterService();

return new App\Chat($aiService);
?>