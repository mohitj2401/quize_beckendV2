<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function getQuestion(Quiz $quiz)
    {





        try {

            $data = [
                'status' => 200,
                'message' => 'Subject Fetch Successfuly',
                'output' => $quiz->question
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 400,
                'message' => 'Something Went Wrong',
                'output' => []
            ];
        }


        return response()->json($data);
    }
}
