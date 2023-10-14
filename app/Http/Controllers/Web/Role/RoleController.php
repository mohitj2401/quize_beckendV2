<?php

namespace App\Http\Controllers\Web\Role;




use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\GoalRepository;
use App\Http\Controllers\Admin\Goal\Requests\CreateGoalRequest;
use App\Http\Controllers\Admin\Goal\Requests\UpdateGoalRequest;
use App\Http\Controllers\Web\Role\Requests\CreateRoleRequest;
use App\Http\Controllers\Web\Role\Requests\UpdateRoleRequest;
use App\Models\Customer;
use App\Models\Exam;
use App\Repositories\RoleRepository;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $role;

    /**
     * CustomerController constructor.
     */

    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    public function index()
    {

        if (!(auth()->user()->can('CRUD Role'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        if (request()->ajax()) {
            return Datatables::of($this->role->all())
                ->addColumn(
                    'action',
                    '


                    <a data-href="{{action(\'App\Http\Controllers\Web\Role\RoleController@show\', [$id])}}" class="btn btn-modal btn-xs btn-info"  data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("View")</a>
                    &nbsp;
                  
                    <button data-href="{{action(\'App\Http\Controllers\Web\Role\RoleController@edit\', [$id])}}" class="btn btn-xs btn-primary btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("Edit")</button>
                    &nbsp;
                    <button data-href="{{action(\'App\Http\Controllers\Web\Role\RoleController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_button"><i class="glyphicon glyphicon-trash"></i> @lang("Delete")</button>
                    &nbsp;
                    <button data-href="{{action(\'App\Http\Controllers\Web\Role\RoleController@getPermission\', [$id])}}" class="btn btn-xs btn-light  btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-trash"></i> @lang("Add Permission")</button>'

                )


                ->editColumn('name', function ($row) {

                    return  $row->name;
                })


                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.role.index', ['title' => 'Roles', 'active' => 'roles']);
    }


    public function create()
    {
        if (!(auth()->user()->can('CRUD Role'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        return view('admin.role.create');
    }

    public function edit($id)
    {
        if (!(auth()->user()->can('CRUD Role'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        $role = Role::where('id', $id)->first();



        return view('admin.role.edit')->with(compact('role'));
    }

    public function show($id)
    {
        if (!(auth()->user()->can('CRUD Role'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        $role = Role::where('id', $id)->first();
        return view('admin.role.view')->with(compact('role'));
    }

    public function store(CreateRoleRequest $request)
    {

        if (!(auth()->user()->can('CRUD Role'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        return $this->role->store();
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {

        if (!(auth()->user()->can('CRUD Role'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        return $this->role->update($role);
    }


    public function destroy($id)
    {
        if (!(auth()->user()->can('CRUD Role'))) {
            alert()->error("You Don't Have Enough Permission", 'Request Denied');

            return redirect()->back();
        }
        if (request()->ajax()) {
            return $this->role->delete($id);
        }
    }

    public function getPermission(Role $role)
    {
        $permissions = ModelsPermission::where('guard_name', $role->guard_name)->get()->pluck('name', 'name')->toArray();
        return view('admin.role.add_permission')->with(compact('role', 'permissions'));
    }

    function storePermission(Role $role)
    {
        return $this->role->addPermission($role);
    }
}
