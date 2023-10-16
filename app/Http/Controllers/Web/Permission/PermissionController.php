<?php

namespace App\Http\Controllers\Web\Permission;





use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Permission\Requests\CreatePermissionRequest;
use App\Http\Controllers\Web\Permission\Requests\UpdatePermissionRequest;
use App\Repositories\PermissionRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $permission;

    /**
     * CustomerController constructor.
     */

    public function __construct(PermissionRepository $permission)
    {

        $this->permission = $permission;
        $this->middleware('can:Crud Permission');
    }

    public function index()
    {
        if (!(auth()->user()->can('Crud Permission'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }

        if (request()->ajax()) {
            return Datatables::of($this->permission->all())
                ->addColumn(
                    'action',
                    '


                 
                  
                    <button data-href="{{action(\'App\Http\Controllers\Web\Permission\PermissionController@edit\', [$id])}}" class="btn btn-xs btn-primary btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("Edit")</button>
                    &nbsp;
                    <button data-href="{{action(\'App\Http\Controllers\Web\Permission\PermissionController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_button"><i class="glyphicon glyphicon-trash"></i> @lang("Delete")</button>'
                )


                ->editColumn('name', function ($row) {

                    return  $row->name;
                })


                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.permissions.index', ['title' => 'Permissions', 'active' => 'permissions']);
    }


    public function create()
    {

        if (!(auth()->user()->can('Crud Permission'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        return view('admin.permissions.create');
    }

    public function edit(Permission $permission)
    {


        if (!(auth()->user()->can('Crud Permission'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }

        return view('admin.permissions.edit')->with(compact('permission'));
    }

    // public function show($id)
    // {
    //     $role = Role::where('id', $id)->first();
    //     return view('admin.permissions.view')->with(compact('role'));
    // }

    public function store(CreatePermissionRequest $request)
    {
        if (!(auth()->user()->can('Crud Permission'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        return $this->permission->store();
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        if (!(auth()->user()->can('Crud Permission'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        return $this->permission->update($permission);
    }


    public function destroy($id)
    {

        if (!(auth()->user()->can('Crud Permission'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        if (request()->ajax()) {
            return $this->permission->delete($id);
        }
    }
}
