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
    public function store(Request $request, $api_token)
    {
        // $encode=json_encode($request->data1);
        // $decode=json_decode($encode);
        $data = array();
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {
                try {
                    $result = new Result;

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
            } else {
                $data['status'] = '511';
                $data['msg'] = 'User Not Found';
            }
        }
        return $data;
    }

    public function getSearchQuiz($api_token, $quiz_name)
    {
        // $encode=json_encode($request->data1);
        // $decode=json_decode($encode);
        $data = array();
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {
                try {
                    $quiz_ids = $user->result->pluck('quiz_id');
                    $data['data'] = Quiz::where('title', 'LIKE', "%{$quiz_name}%")->whereIn('id', $quiz_ids)->get();
                    $data['status'] = '200';
                    $data['msg'] = 'Result Stored Successfully';
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = $th;
                }
            } else {
                $data['status'] = '511';
                $data['msg'] = 'User Not Found';
            }
        }
        return $data;
    }

    public function getPlayedQuiz($api_token)
    {
        $data = array();
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {
                try {
                    $quiz_ids = $user->result->pluck('quiz_id');
                    $data['data'] = Quiz::whereIn('id', $quiz_ids)->get();
                    $data['status'] = '200';
                    $data['msg'] = 'Result Stored Successfully';
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = $th;
                }
            } else {
                $data['status'] = '511';
                $data['msg'] = 'User Not Found';
            }
        }
        return $data;
    }

    public function pdfview($api_token, $quiz_id)
    {
        $data = array();
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {

                try {
                    $result = Result::where('quiz_id', $quiz_id)->where('user_id', $user->id)->first();

                    $data['result'] = $result;
                    $data['result_json'] = json_decode($result->results);

                    $pdf = PDF::loadView('admin.showresults', $data);

                    return $pdf->download('result.pdf');
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = $th;
                }
            } else {
                $data['status'] = '511';
                $data['msg'] = 'User Not Found';
            }
        }

        return $data;
        // return view('admin.showresults', $data);
    }
}
