<?php 
namespace App;

interface AiServiceInterface
{
    public function getResponse(string $input): string;
}
?>