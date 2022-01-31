<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Imports\SubjectImport;
use App\Models\Subject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $data['title'] = 'Subject List | Quizie';
        $data['active'] = 'subject';
        // if (auth()->user()->usertype_id == 1) {
            $data['subjects'] = Subject::all();
        // } else {
        //     $data['subjects'] = Subject::where('user_id', auth()->user()->id)->get();
        // }
        // $data['subjects'] = Subject::all();
        return view('subject.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        if ($request->hasFile('excel')) {
            // $path = $request->file('excel')->getRealPath();
            try {
                Excel::import(new SubjectImport(), $request->file('excel'));

                alert()->success('Data Inserted Successfully');
            } catch (\Throwable $th) {
                // dd($th);
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
            alert()->success('Subject added successfuly');
            return redirect()->back();
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
