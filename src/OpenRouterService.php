<?php

namespace App;

use GuzzleHttp\Client;

class OpenRouterService implements AiServiceInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://openrouter.ai/api/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $_ENV['OPENROUTER_API_KEY'],
                'Content-Type' => 'application/json',
            ],
            'curl' => [
                CURLOPT_VERBOSE => false,
                CURLOPT_STDERR => fopen('NUL', 'w'), // Corregido de 'NULL' a 'NUL' para Windows
            ],
        ]);
    }

    public function getResponse(string $question): string
    {
        $result = $this->client->post('chat/completions', [
            'json' => [
                'model' => 'google/gemini-2.5-flash',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un profesor de programación. Explica conceptos de manera clara y didáctica, respuestas cortas pero muy precisas explicando de forma basica y facil para que todos aprendan, siempre en español.'],
                    ['role' => 'user', 'content' => $question],
                ],
                'max_tokens' => 1000, // <--- AGREGASTE ESTA LÍNEA AQUÍ
            ],
        ]);

        $body = json_decode($result->getBody(), true);
        return $body['choices'][0]['message']['content'];
    }
}