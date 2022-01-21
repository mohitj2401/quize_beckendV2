<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class QuizController extends Controller
{

    public function getQuiz($subject)
    {

        try {
            $user = auth()->user();
            if (count($user->quiz) > 0) {
                $quiz = $user->quiz()->withCount('question')
                    ->get();
            }
            if ($user->usertype_id == 3) {
                $quiz_ids = $user->result->pluck('quiz_id');
                $quiz = Subject::find($subject)->quiz()->whereNotIn('id', $quiz_ids)->has('question', '>', 0)->withCount('question')
                    ->get();
            }
            $data = [
                'status' => 200,
                'message' => 'Quiz Fetch Successfuly',
                'output' => $quiz
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 400,
                'message' => 'Something Wemt Worng',
                'output' => []
            ];
        }

        return response()->json($data);
    }

    public function getSingleQuiz($quiz_id)
    {

        try {
            $user = auth()->user();
            if ($user->usertype_id == 3) {
                $quiz = Quiz::where('id', $quiz_id)->has('question', '>', 0)->withCount('question')
                    ->get();
            }
            $data = [
                'status' => 200,
                'message' => 'Quiz Fetch Successfuly',
                'output' => $quiz
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 400,
                'message' => 'Something Went Worng',
                'output' => []
            ];
        }

        return response()->json($data);
    }
}
