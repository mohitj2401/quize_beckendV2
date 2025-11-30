<?php

namespace App\Jobs;

use App\Models\Quiz;
use App\Models\User;
use App\Services\AI\AIServiceFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class GenerateAiQuizJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data;

    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payload = $this->data;

        $user = User::find($payload['user_id'] ?? null);
        if (!$user) {
            return; // cannot proceed without user
        }

        $openAI = AIServiceFactory::make();

        // Generate metadata only (questions will be handled by separate job)
        $metadata = [];
        try {
            $metadata = $openAI->generateQuizMetadata($payload['topic']);
        } catch (\Throwable $e) {
            // ignore metadata failure, fall back to topic
        }

        $quiz = new Quiz();
        $quiz->title = $metadata['title'] ?? ($payload['topic'] . ' Quiz');
        $quiz->description = $metadata['description'] ?? ('AI-generated quiz about ' . $payload['topic']);
        $quiz->duration = (int)($payload['duration'] ?? 10);
        $quiz->access_token = Str::random(8);
        $quiz->subject_id = $payload['subject_id'] ?? ($payload['subject'] ?? null);
        $quiz->start_time = $payload['start_time'] ?? now();
        $quiz->end_time = $payload['end_time'] ?? now()->addDays(30);
        $quiz->image = $payload['image_path'] ?? '';
        $quiz->status = $payload['status'] ?? 1;

        $user->quiz()->save($quiz);

        // Dispatch separate job for creating questions
        CreateQuizQuestionsJob::dispatch(
            $quiz->id,
            $payload['topic'],
            (int)($payload['number_of_questions'] ?? 10),
            $payload['difficulty'] ?? 'medium'
        );
    }
}
