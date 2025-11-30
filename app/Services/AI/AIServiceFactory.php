<?php

namespace App\Services\AI;

use App\Models\Setting;

class AIServiceFactory
{
    /**
     * Create an AI service instance based on settings
     *
     * @return AIProviderInterface
     */
    public static function make(): AIProviderInterface
    {
        $provider = Setting::getAIProvider();

        return match ($provider) {
            'ollama' => new OllamaService(),
            'gemini' => new GeminiService(),
            'openai' => new OpenAIService(),
            default => new OpenAIService(), // Default to OpenAI
        };
    }

    /**
     * Get available AI providers
     *
     * @return array
     */
    public static function getAvailableProviders(): array
    {
        return [
            'openai' => [
                'name' => 'OpenAI (GPT-4o-mini)',
                'description' => 'Cloud-based AI, requires API key',
                'requires' => ['OPENAI_API_KEY']
            ],
            'ollama' => [
                'name' => 'Ollama (Local)',
                'description' => 'Run AI models locally, no API costs',
                'requires' => ['OLLAMA_URL', 'OLLAMA_MODEL']
            ],
            'gemini' => [
                'name' => 'Google Gemini',
                'description' => 'Google\'s AI model, requires API key',
                'requires' => ['GEMINI_API_KEY']
            ],
        ];
    }
}
