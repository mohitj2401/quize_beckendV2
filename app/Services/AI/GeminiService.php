<?php

namespace App\Services\AI;

use Gemini\Laravel\Facades\Gemini;

class GeminiService implements AIProviderInterface
{
    /**
     * Generate quiz questions based on topic and parameters
     */
    public function generateQuestions(string $topic, int $numberOfQuestions = 10, string $difficulty = 'medium'): array
    {
        $prompt = $this->buildQuestionPrompt($topic, $numberOfQuestions, $difficulty);

        $result = Gemini::geminiPro()->generateContent($prompt);

        $content = $result->text();
        
        // Clean up markdown code blocks if present
        $content = preg_replace('/```json\s*|\s*```/', '', $content);
        $content = trim($content);
        
        $questions = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Failed to parse Gemini response as JSON: ' . json_last_error_msg());
        }

        return $this->formatQuestions($questions);
    }

    /**
     * Generate quiz metadata (title and description)
     */
    public function generateQuizMetadata(string $topic): array
    {
        $prompt = "Generate a catchy title and engaging description for a quiz about: {$topic}. Return as JSON with 'title' and 'description' keys. Return ONLY valid JSON, no markdown formatting.";

        $result = Gemini::geminiPro()->generateContent($prompt);
        
        $content = $result->text();
        
        // Clean up markdown code blocks if present
        $content = preg_replace('/```json\s*|\s*```/', '', $content);
        $content = trim($content);
        
        $metadata = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Failed to parse Gemini response as JSON: ' . json_last_error_msg());
        }

        return $metadata;
    }

    /**
     * Build the prompt for question generation
     */
    protected function buildQuestionPrompt(string $topic, int $numberOfQuestions, string $difficulty): string
    {
        return <<<PROMPT
Generate {$numberOfQuestions} multiple-choice questions about "{$topic}" at {$difficulty} difficulty level.

IMPORTANT: The CORRECT answer must ALWAYS be in option1. The other three options should be plausible but incorrect.

Return ONLY a valid JSON object with this exact structure (no markdown code blocks, no explanation):
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
- Return ONLY the JSON object, no markdown formatting
PROMPT;
    }

    /**
     * Format questions to match database structure
     */
    protected function formatQuestions(array $data): array
    {
        if (!isset($data['questions']) || !is_array($data['questions'])) {
            throw new \Exception('Invalid response format from Gemini');
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
