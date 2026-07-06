<?php
namespace App;

use OpenAI;

class OpenAiService implements AiServiceInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client($_ENV['OPENAI_API_KEY']);
    }

    public function getResponse(string $question): string
    {
        $result = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
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

        return $result['choices'][0]['message']['content'];
    }
}