<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class AppSubjectController extends Controller
{
    public function getSubjects($api_token)
    {
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {
                try {
                    if ($user->usertype_id == 3) {
                        $data['data'] = Subject::has('quiz', '>', 0)->withCount('quiz')->get();
                    }

                    $data['status'] = '200';
                    $data['msg'] = 'All Quizzes';
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = 'Please Try Again After Some Time';
                    $data['th'] = $th;
                }
            } else {
                $data['status'] = '203';
                $data['msg'] = 'User Not Found';
            }
        }
        return response()->json($data);
    }
    public function getSearchSubjects($api_token, $sub_name)
    {
        if ($api_token) {
            $user = User::where('api_token', $api_token)->first();
            if ($user) {
                try {
                    if ($user->usertype_id == 3) {
                        $data['data'] = Subject::where('name', 'LIKE', "%{$sub_name}%")->has('quiz', '>', 0)->get();
                    }

                    $data['status'] = '200';
                    $data['msg'] = 'All Quizzes';
                } catch (\Throwable $th) {
                    $data['status'] = '500';
                    $data['msg'] = 'Please Try Again After Some Time';
                    $data['th'] = $th;
                }
            } else {
                $data['status'] = '203';
                $data['msg'] = 'User Not Found';
            }
        }
        return response()->json($data);
    }
}
