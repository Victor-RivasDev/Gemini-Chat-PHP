<?php
namespace App;

class Chat
{

    public function __construct(
        private AiServiceInterface $aiService
    ){}

    public function start()
    {
        $this->welcome();

while (true) {
    $input = readline("You: ");
    if ($input === 'exit') {
        echo "Goodbye!" . PHP_EOL;
        break;
    }
    $response = $this->getResponse($input);
    echo $response . PHP_EOL;
}
    }
    private function welcome()
    {
        echo "Welcome to the AI Chat! Type 'exit' to quit." . PHP_EOL;
    }

    public function getResponse($input)
    {
        return $this->aiService->getResponse($input);
    }
}
?>