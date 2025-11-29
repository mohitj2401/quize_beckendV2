<?php

namespace App\Services\AI;

interface AIProviderInterface
{
    /**
     * Generate quiz questions based on topic and parameters
     *
     * @param string $topic The topic for the quiz
     * @param int $numberOfQuestions Number of questions to generate
     * @param string $difficulty Difficulty level (easy, medium, hard)
     * @return array Generated questions
     */
    public function generateQuestions(string $topic, int $numberOfQuestions = 10, string $difficulty = 'medium'): array;

    /**
     * Generate quiz metadata (title and description)
     *
     * @param string $topic The topic for the quiz
     * @return array Quiz metadata with 'title' and 'description' keys
     */
    public function generateQuizMetadata(string $topic): array;
}
