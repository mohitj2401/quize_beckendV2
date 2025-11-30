<?php

namespace App\Services\AI;

use OpenAI;

class OpenAIService implements AIProviderInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(config('services.openai.api_key'));
    }

    /**
     * Generate quiz questions based on topic and parameters
     *
     * @param string $topic The topic for the quiz
     * @param int $numberOfQuestions Number of questions to generate
     * @param string $difficulty Difficulty level (easy, medium, hard)
     * @return array Generated questions
     */
    public function generateQuestions(string $topic, int $numberOfQuestions = 10, string $difficulty = 'medium'): array
    {
        $prompt = $this->buildQuestionPrompt($topic, $numberOfQuestions, $difficulty);

        $response = $this->client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an expert quiz creator. Generate multiple-choice questions in valid JSON format only. Each question must have exactly 4 options and indicate which option is correct (1-4).'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.7,
            'response_format' => ['type' => 'json_object']
        ]);

        $content = $response->choices[0]->message->content;
        $questions = json_decode($content, true);

        return $this->formatQuestions($questions);
    }

    /**
     * Generate quiz metadata (title and description)
     *
     * @param string $topic The topic for the quiz
     * @return array Quiz metadata
     */
    public function generateQuizMetadata(string $topic): array
    {
        $prompt = "Generate a catchy title and engaging description for a quiz about: {$topic}. Return as JSON with 'title' and 'description' keys.";

        $response = $this->client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a creative quiz title and description generator. Return only valid JSON.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.8,
            'response_format' => ['type' => 'json_object']
        ]);

        $content = $response->choices[0]->message->content;
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

Return ONLY a valid JSON object with this exact structure:
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
PROMPT;
    }

    /**
     * Format questions to match database structure
     */
    protected function formatQuestions(array $data): array
    {
        if (!isset($data['questions']) || !is_array($data['questions'])) {
            throw new \Exception('Invalid response format from OpenAI');
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
