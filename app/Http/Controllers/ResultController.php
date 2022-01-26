<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;


class ResultController extends Controller
{
    public function store(Request $request)
    {
        // $encode=json_encode($request->data1);
        // $decode=json_decode($encode);
        $data = array();

        try {
            $user = auth()->user();
            $result = new Result();

            $result->results = $request['data1'];
            $res = json_decode($request['data1']);
            $total = count(Quiz::find($request['quizId'])->question);
            $notAttempted = $total - count($res);
            $correct = 0;
            $incorrect = 0;
            foreach ($res as $key) {

                if (Question::where('id', $key->id)->where('option1', $key->answer)->first()) {
                    $correct++;
                } else {
                    $incorrect++;
                }
            }

            $result->user_id = $user->id;
            $result->notAttempted = $notAttempted;
            $result->total = $total;
            $result->incorrect = $incorrect;
            $result->correct = $correct;
            $result->quiz_id = $request['quizId'];
            $result->save();
            $data['status'] = '200';
            $data['msg'] = 'Result Stored Successfully';
        } catch (\Throwable $th) {
            $data['status'] = '500';
            $data['msg'] = $th;
        }

        return $data;
    }

    public function getSearchQuiz($quiz_name)
    {
        // $encode=json_encode($request->data1);
        // $decode=json_decode($encode);

        try {
            $user = auth()->user();
            $quiz_ids = $user->result->pluck('quiz_id');
            $quiz = Quiz::where('title', 'LIKE', "%{$quiz_name}%")->whereIn('id', $quiz_ids)->get();
            $data = [
                'status' => 200,
                'message' => 'Quiz Fetch Successfuly',
                'output' => $quiz
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

    public function getPlayedQuiz()
    {

        try {
            $user = auth()->user();
            $quiz_ids = $user->result->pluck('quiz_id');

            $data = [
                'status' => 200,
                'message' => 'Quiz Fetch Successfuly',
                'output' =>  Quiz::whereIn('id', $quiz_ids)->get()
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

    public function pdfview($quiz_id)
    {


        try {
            $user = auth()->user();
            $result = Result::where('quiz_id', $quiz_id)->where('user_id', $user->id)->first();

            $data['result'] = $result;
            $data['quiz_id']
                = $quiz_id;
            $data['result_json'] = json_decode($result->results);

            $pdf = PDF::loadView('admin.showresults', $data);

            return $pdf->download('result.pdf');
        } catch (\Throwable $th) {
            $data['status'] = '500';
            $data['msg'] = $th;
        }

        return $data;
        // return view('admin.showresults', $data);
    }
}
