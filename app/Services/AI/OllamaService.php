<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;

class OllamaService implements AIProviderInterface
{
    protected $baseUrl;
    protected $model;

    public function __construct()
    {
        $this->baseUrl = config('services.ollama.url', 'http://localhost:11434');
        $this->model = config('services.ollama.model', 'llama3.1:8b');
    }

    /**
     * Generate quiz questions based on topic and parameters
     */
    public function generateQuestions(string $topic, int $numberOfQuestions = 10, string $difficulty = 'medium'): array
    {
        \Log::info("response");

        $prompt = $this->buildQuestionPrompt($topic, $numberOfQuestions, $difficulty);

        $response = Http::timeout(120)->post("{$this->baseUrl}/api/generate", [
            'model' => $this->model,
            'prompt' => $prompt,
            'stream' => false,
            'format' => 'json',
            'options' => [
                'temperature' => 0.7,
            ]
        ]);

        \Log::info($response);
        if (!$response->successful()) {
            throw new \Exception('Ollama API request failed: ' . $response->body());
        }

        $content = $response->json('response');
        $questions = json_decode($content, true);

        return $this->formatQuestions($questions);
    }

    /**
     * Generate quiz metadata (title and description)
     */
    public function generateQuizMetadata(string $topic): array
    {
        \Log::info("ss");
        $prompt = "Generate a catchy title and engaging description for a quiz about: {$topic}. Return as JSON with 'title' and 'description' keys. ONLY return valid JSON, nothing else.";

        $response = Http::timeout(60)->post("{$this->baseUrl}/api/generate", [
            'model' => $this->model,
            'prompt' => $prompt,
            'stream' => false,
            'format' => 'json',
            'options' => [
                'temperature' => 0.8,
            ]
        ]);
        \Log::info($response);

        if (!$response->successful()) {
            throw new \Exception('Ollama API request failed: ' . $response->body());
        }

        $content = $response->json('response');
        return json_decode($content, true);
    }

    /**
     * Build the prompt for question generation
     */
    protected function buildQuestionPrompt(string $topic, int $numberOfQuestions, string $difficulty): string
    {
        return <<<PROMPT
Generate {$numberOfQuestions} multiple-choice questions about "{$topic}" at {$difficulty} difficulty level.

IMPORTANT: The CORRECT answer must ALWAYS be in option1. The other three options should be plausible but incorrect.

Return ONLY a valid JSON object with this exact structure (no markdown, no explanation):
{
    "questions": [
        {
            "title": "Question text here?",
            "option1": "CORRECT ANSWER HERE",
            "option2": "Incorrect option",
            "option3": "Incorrect option",
            "option4": "Incorrect option"
        }
    ]
}

Requirements:
- Each question must have exactly 4 options
- option1 MUST be the correct answer
- option2, option3, and option4 must be incorrect but plausible
- Questions should be clear and unambiguous
- Incorrect options should be believable distractors
- Return ONLY the JSON, no other text
PROMPT;
    }

    /**
     * Format questions to match database structure
     */
    protected function formatQuestions(array $data): array
    {
        if (!isset($data['questions']) || !is_array($data['questions'])) {
            throw new \Exception('Invalid response format from Ollama');
        }

        $formatted = [];
        foreach ($data['questions'] as $question) {
            $formatted[] = [
                'title' => $question['title'] ?? '',
                'option1' => $question['option1'] ?? '',
                'option2' => $question['option2'] ?? '',
                'option3' => $question['option3'] ?? '',
                'option4' => $question['option4'] ?? '',
                'status' => 1
            ];
        }

        return $formatted;
    }
}
