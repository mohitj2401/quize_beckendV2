<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'User List | Quizie';
        $data['active'] = 'user';
        if (auth()->user()->usertype_id == 1) {
            $data['users'] = User::where('usertype_id', '!=', 1)->get();
        } else {
            $data['users'] = User::where('usertype_id', 3)->get();
        }
        return view('user.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('excel')) {;
            try {
                Excel::import(new UserImport(), $request->file('excel'));

                alert()->success('Data Inserted Successfully');
            } catch (\Throwable $th) {
                // dd($th);
                alert()->error('Please check excel file', 'An Error Occur');
            }
            return redirect()->back();
        } else {
            alert()->error('Please check excel file', 'An Error Occur');
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
    public function destroy(User $user)
    {
        if (auth()->user()->usertype_id == 1) {
            $user->deleted = 1;
            $user->save();
        } else {
            alert()->warning('Not Allowed');
            return redirect()->back();
        }

        alert()->success('User deleted successfuly');
        return redirect()->back();
    }

    public function statusUpdate(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();
    }

    public function userprofile()
    {
        $data['title'] = 'Profile Setting | Quizie';
        $data['active'] = 'setting';
        return view('admin.settings', $data);
    }

    public function changedPass(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            alert()->success('Password Changed Successfully');
            return redirect()->back();
        } else {
            alert()->error('Incorrect Password ! please try again  ');
            return redirect()->back();
        }
    }
}
