<?php
namespace App;

use ArdaGnsrn\Ollama\Ollama;

class OllamaAiService implements AiServiceInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = Ollama::client();
    }

    public function getResponse(string $question): string
    {
        $result = $this->client->chat()->create([
            'model' => 'deepseek-r1:1.5b',
            'messages' => [
                [
                'role' => 'system', 
                'content' => 'Eres un asistente de programacion experto. Respondes en español de forma muy breve, concisa y sin rodeos, si no sabes algo, dilo directamente.',
            ],
            [
                'role' => 'user', 
                'content' => $question,
            ],
            ],
        ]);

        return $result->message->content;
    }
}