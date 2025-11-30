<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Imports\ImportQuestions;
use App\Jobs\CreateQuizQuestionsJob;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['quizzes'] = auth()->user()->quiz;
        $data['selectedQuiz'] = '';
        $data['active'] = 'question';
        return view('admin.question', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($quiz = '')
    {
        if ($quiz == '') {
            $data['selectedQuiz'] = '';
            $data['quizzes'] = auth()->user()->quiz;
            $data['title'] = 'Question Create | Quizie';
            $data['active'] = 'quiz';
            return view('admin.questioncreate', $data);
        } else {
            $data['title'] = 'Question Create | Quizie';
            $data['active'] = 'quiz';
            return view('question.create', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $quiz = '')
    {
        if ($quiz == '') {
            $request->validate([
                'excel' => 'required|mimes:xlsx',
                'quiz' => 'required',
            ]);
            if ($request->hasFile('excel')) {
                // $path = $request->file('excel')->getRealPath();
                try {
                    Excel::import(new ImportQuestions($request->quiz), $request->excel);


                    alert()->success('Data Inserted Successfully');
                } catch (\Exception $e) {
                    Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

                    alert()->error('Please check excel file', 'An Error Occur');
                }
            }
            return redirect()->back();
        } else {
            if (Quiz::find($quiz)->user->id != auth()->user()->id) {
                alert()->error("Don't have enough privileges for performing this action");
                return redirect()->back();
            }
            $request->validate([

                'question' => 'required|bail|max:255',
                'option1' => 'required|bail|max:255',
                'option2' => 'required|bail|max:255',
                'option3' => 'required|bail|max:255',
                'option4' => 'required|bail|max:255',
            ]);
            $question = new Question();
            $question->title = $request->question;
            $question->option1 = $request->option1;
            $question->option2 = $request->option2;
            $question->option3 = $request->option3;
            $question->option4 = $request->option4;
            $question->quiz_id = $quiz;
            $question->save();
            alert()->success('Data Inserted Successfully');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Quiz $quiz)
    {
        $question->delete();
        alert()->success('Deleted');
        session()->put('quiz_id', $quiz->id);
        return redirect()->back();
    }

    public function getQuestion(Quiz $quiz)
    {
        $data['data'] = $quiz->question->toArray();

        return $data;
    }

    /**
     * Show form to generate questions for a quiz using AI
     */
    public function createWithAI($quiz)
    {
        $quiz = Quiz::findOrFail($quiz);

        if ($quiz->user_id != auth()->user()->id) {
            alert()->error("Don't have permission to modify this quiz", 'Request Denied');
            return redirect()->back();
        }

        $data['quiz'] = $quiz;
        $data['active'] = 'question';
        $data['title'] = 'Generate Questions with AI | Quizie';
        return view('admin.question-ai-generate', $data);
    }

    /**
     * Generate questions for a quiz using AI through job queue
     */
    public function generateWithAI(Request $request, $quiz)
    {
        $quiz = Quiz::findOrFail($quiz);

        if ($quiz->user_id != auth()->user()->id) {
            alert()->error("Don't have permission to modify this quiz", 'Request Denied');
            return redirect()->back();
        }

        $request->validate([
            'topic' => 'required|max:255',
            'number_of_questions' => 'required|integer|min:1|max:50',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        try {
            // Dispatch job to generate questions
            CreateQuizQuestionsJob::dispatch(
                $quiz->id,
                $request->topic,
                $request->number_of_questions,
                $request->difficulty
            );

            alert()->success('Question generation has been queued. Questions will be added once processing completes.');
            return redirect()->route('quiz.view');
        } catch (\Exception $e) {
            alert()->error('Failed to queue question generation: ' . $e->getMessage());
            return back()->withInput();
        }
    }
}
