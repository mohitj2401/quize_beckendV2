<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class AppSubjectController extends Controller
{
    public function getSubjects()
    {

        try {
            $user = auth()->user();
            if ($user->usertype_id == 3) {
                $subject = Subject::has('quiz', '>', 0)->withCount('quiz')->get();
            }
            $data = [
                'status' => 200,
                'message' => 'Subject Fetch Successfuly',
                'output' => $subject
            ];
        } catch (\Exception $th) {
            $data = [
                'status' => 400,
                'message' => 'Something Went Worng',
                'output' => $th
            ];
        }
        return response()->json($data);
    }
    public function getSearchSubjects($sub_name)
    {

        try {
            $user = auth()->user();
            if ($user->usertype_id == 3) {
                $subject = Subject::where('name', 'LIKE', "%{$sub_name}%")->has('quiz', '>', 0)->get();
            }
            $data = [
                'status' => 200,
                'message' => 'Subject Fetch Successfuly',
                'output' => $subject
            ];
        } catch (\Exception $th) {
            $data = [
                'status' => 400,
                'message' => 'Something Went Wrong',
                'output' => []
            ];
        }
        return response()->json($data);
    }
}
