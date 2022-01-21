<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, $api_token, Quiz $quiz)
    {
        $validate = Validator($request->all(), [
            'question' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',

        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        } else {
            if ($api_token) {


                try {
                    $question = new Question;
                    $question->title = $request->question;
                    $question->option1 = $request->option1;
                    $question->option2 = $request->option2;
                    $question->option3 = $request->option3;
                    $question->option4 = $request->option4;
                    $quiz->question()->save($question);
                    $data['status'] = '200';
                    $data['msg'] = 'Question Stored Successfully';
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = 'Please Try Again After Some Time';
                    $data['th'] = $th;
                }
            } else {
                $data['status'] = '511';
                $data['msg'] = 'Please Try Again After Some Time';
            }

            return response()->json($data);
        }
    }
    public function getQuestion(Quiz $quiz)
    {





        try {
            $data['data'] = $quiz->question;
            $data['status'] = '200';
            $data['msg'] = 'Question Stored Successfully';
        } catch (\Throwable $th) {
            $data['status'] = '500';
            $data['msg'] = 'Please Try Again After Some Time';
            $data['th'] = $th;
        }


        return response()->json($data);
    }
}
