<?php

namespace App\Jobs;

use App\Models\Quiz;
use App\Services\AI\AIServiceFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateQuizQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $quiz_id;
    public string $topic;
    public int $number_of_questions;
    public string $difficulty;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(int $quiz_id, string $topic, int $number_of_questions, string $difficulty)
    {
        $this->quiz_id = $quiz_id;
        $this->topic = $topic;
        $this->number_of_questions = $number_of_questions;
        $this->difficulty = $difficulty;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $quiz = Quiz::find($this->quiz_id);
        if (!$quiz) {
            return; // Quiz not found, skip
        }

        $aiService = AIServiceFactory::make();

        // Generate questions from AI service
        $questions = [];
        try {
            $batchSize = (int) config('ai.questions_batch', 5);
            $toGenerate = max(0, min($this->number_of_questions, $batchSize));

            if ($toGenerate > 0) {
                $questions = $aiService->generateQuestions(
                    $this->topic,
                    $toGenerate,
                    $this->difficulty
                );
            }
        } catch (\Throwable $e) {
            throw new \Exception('Failed to generate questions: ' . $e->getMessage());
        }

        // Bulk create questions for the quiz
        if (!empty($questions)) {
            foreach ($questions as $questionData) {
                $quiz->question()->create($questionData);
            }
        }
        $remaining = $this->number_of_questions - ($toGenerate ?? 0);
        if ($remaining > 0) {
            // dispatch next batch for remaining questions
            CreateQuizQuestionsJob::dispatch(
                $quiz->id,
                $this->topic,
                (int) $remaining,
                $this->difficulty ?? 'medium'
            );
        }
    }
}
