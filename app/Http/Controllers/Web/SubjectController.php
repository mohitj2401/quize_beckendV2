<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Imports\SubjectImport;
use App\Models\Subject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!(auth()->user()->can('View Subject') || in_array('Owner', auth()->user()->getRoleNames()->toArray()))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        $data['title'] = 'Subject List | Quizie';
        $data['active'] = 'subject';

        $data['subjects'] = Subject::all();

        return view('subject.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!(auth()->user()->can('Create Subject') || in_array('Owner', auth()->user()->getRoleNames()->toArray()))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        $data['title'] = 'Subject Create | Quizie';
        $data['active'] = 'subject';
        return view('subject.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!(auth()->user()->can('Create Subject') || in_array('Owner', auth()->user()->getRoleNames()->toArray()))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        if ($request->hasFile('excel')) {
            // $path = $request->file('excel')->getRealPath();
            try {
                Excel::import(new SubjectImport(), $request->file('excel'));

                alert()->success('Data Inserted Successfully');
            } catch (\Exception $e) {
                Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

                alert()->error('Please check excel file', 'An Error Occur');
            }
            return redirect()->back();
        } else {
            $request->validate([
                'name' => 'required|bail|max:255|unique:subjects,name',
                'code' => 'required|bail|max:255|unique:subjects,code',
            ]);

            $subject = new Subject();
            $subject->name = $request->name;
            $subject->code = $request->code;
            $subject->user_id = auth()->user()->id;
            $subject->save();

            // Check if AI generation is requested
            if ($request->has('generate_with_ai') && $request->generate_with_ai == '1') {
                try {
                    $this->generateAIQuizForSubject($subject, $request);
                    alert()->success('Subject created and AI quiz generated successfully!');
                } catch (\Exception $e) {
                    alert()->warning('Subject created but AI quiz generation failed: ' . $e->getMessage());
                }
            } else {
                alert()->success('Subject added successfully');
            }

            return redirect()->back();
        }
    }

    /**
     * Generate AI quiz for a newly created subject
     */
    protected function generateAIQuizForSubject(Subject $subject, Request $request)
    {
        $aiService = \App\Services\AI\AIServiceFactory::make();
        
        // Generate quiz metadata based on subject name
        $metadata = $aiService->generateQuizMetadata($subject->name);
        
        // Generate questions
        $questionCount = $request->ai_question_count ?? 10;
        $difficulty = $request->ai_difficulty ?? 'medium';
        $questions = $aiService->generateQuestions($subject->name, $questionCount, $difficulty);

        // Create quiz
        $quiz = new \App\Models\Quiz();
        $quiz->title = $metadata['title'] ?? $subject->name . ' Quiz';
        $quiz->description = $metadata['description'] ?? 'AI-generated quiz about ' . $subject->name;
        $quiz->duration = $request->ai_duration ?? 30;
        $quiz->access_token = \Illuminate\Support\Str::random(8);
        $quiz->subject_id = $subject->id;
        $quiz->start_time = now();
        $quiz->end_time = now()->addDays(30);
        
        // Create a default image path (you may want to use a default image)
        $quiz->image = 'uploads/quiz/default.jpg';
        
        // Save quiz
        auth()->user()->quiz()->save($quiz);

        // Create questions
        foreach ($questions as $questionData) {
            $quiz->question()->create($questionData);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        if (!(auth()->user()->can('Edit Subject') || in_array('Owner', auth()->user()->getRoleNames()->toArray()))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        $data['title'] = 'Subject Edit | Quizie';
        $data['active'] = 'subject';
        $data['subject'] = $subject;
        return view('subject.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        if (!(auth()->user()->can('Edit Subject') || in_array('Owner', auth()->user()->getRoleNames()->toArray()))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        $request->validate([
            'name' => 'required|bail|max:255|unique:subjects,name,' . $subject->id,
            'code' => 'required|bail|max:255|unique:subjects,code,' . $subject->id,
        ]);
        $subject->name = $request->name;
        $subject->code = $request->code;
        $subject->save();
        alert()->success('Subject updated successfuly');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if (!(auth()->user()->can('Delete Subject') || in_array('Owner', auth()->user()->getRoleNames()->toArray()))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        if ($subject->user->id != auth()->user()->id) {
            alert()->error("Don't have enough privileges for performing this action");
        }

        if (count($subject->quiz) > 0) {
            alert()->error('Record In use unable to delete it');
        } else {
            $subject->delete();
            alert()->success('Deleted successfully');
        }
        return redirect()->back();
    }


    public function statusUpdate($status, Subject $subject)
    {
        if ($subject->user->id != auth()->user()->id) {
            alert()->error("Don't have enough privileges for performing this action");
        }

        if ($status == 'active' || $status == 'inactive') {
            // dd($status);
            $subject->status = $status == 'active' ? 1 : 0;
            $subject->save();

            alert()->success('Status updated successfully');
        } else {
            alert()->error("Don't have enough privileges for performing this action");
        }
        return redirect()->back();
    }
}
