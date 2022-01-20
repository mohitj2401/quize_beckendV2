<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->usertype_id == 1) {
            $data['quizzes'] = Quiz::all();
        } else {
            $data['quizzes'] = Quiz::where('user_id', auth()->user()->id)->get();
        }

        $data['active'] = 'dashboard';
        $data['title'] = 'Dashboard | Quizie';
        return view('admin.index', $data);
    }



    public function pdfview(User $user, Quiz $quiz)
    {

        $result = Result::where('user_id', $user->id)->where('quiz_id', $quiz->id)->first();

        $data['result'] = $result;
        $data['result_json'] = json_decode($result->results);
        $pdf = PDF::loadView('admin.showresults', $data);

        return $pdf->download('result.pdf');
        // return view('admin.showresults', $data);
    }
}
