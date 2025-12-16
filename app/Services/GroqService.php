<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GroqService
{
    protected $apiKey;
    protected $model;
    protected $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
        $this->model = env('GROQ_MODEL', 'llama-3.3-70b-versatile');
    }

    public function enhanceClinicalText($text)
    {
        // Prompt del Sistema: Define la personalidad de la IA
        $systemPrompt = "Eres un asistente médico experto en estética y dermatología. " .
                        "Tu trabajo es recibir notas rápidas o informales y reescribirlas " .
                        "usando terminología clínica profesional, ortografía perfecta y tono formal. " .
                        "No agregues información inventada, solo mejora la redacción y estructura lo que se te da. " .
                        "Responde SOLO con el texto mejorado, sin saludos ni explicaciones.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $text],
                ],
                'temperature' => 0.3, // Bajo para ser preciso y no creativo
            ]);

            return $response->json()['choices'][0]['message']['content'] ?? $text;

        } catch (\Exception $e) {
            // Si falla (internet, api key), devolvemos el texto original para no romper nada
            return $text;
        }
    }
}