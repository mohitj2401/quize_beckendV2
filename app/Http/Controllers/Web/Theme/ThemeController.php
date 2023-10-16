<?php

namespace App\Http\Controllers\Web\Theme;





use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Permission\Requests\CreatePermissionRequest;
use App\Http\Controllers\Web\Permission\Requests\UpdatePermissionRequest;
use App\Http\Controllers\Web\Theme\Requests\CreateThemeRequest;
use App\Http\Controllers\Web\Theme\Requests\UpdateThemeRequest;
use App\Models\AppTheme;
use App\Repositories\PermissionRepository;
use App\Repositories\ThemeRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ThemeController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    /**
     * CustomerController constructor.
     */

    public function __construct(ThemeRepository $repository)
    {

        $this->repository = $repository;
        $this->middleware('can:Crud Apptheme');
    }

    public function index()
    {
        // if (!(auth()->user()->can('Crud Permission'))) {
        //     alert()->error("You Don't Have Enough Permission", 'Request Denied');

        //     return redirect()->back();
        // }

        if (request()->ajax()) {
            return Datatables::of($this->repository->all())
                ->addColumn(
                    'action',
                    '


                 
                  
                    <button data-href="{{action(\'App\Http\Controllers\Web\Theme\ThemeController@edit\', [$id])}}" class="btn btn-xs btn-primary btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("Edit")</button>
                    &nbsp;
                    <button data-href="{{action(\'App\Http\Controllers\Web\Theme\ThemeController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_button"><i class="glyphicon glyphicon-trash"></i> @lang("Delete")</button>'
                )


                ->editColumn('name', function ($row) {

                    return  $row->name;
                })


                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.theme.index', ['title' => 'Theme Setting', 'active' => 'themes']);
    }


    public function create()
    {

        // if (!(auth()->user()->can('Crud Permission'))) {
        //     alert()->error("You Don't Have Enough Permission", 'Request Denied');

        //     return redirect()->back();
        // }
        return view('admin.theme.create');
    }

    public function edit(AppTheme $theme)
    {


        // if (!(auth()->user()->can('Crud Permission'))) {
        //     alert()->error("You Don't Have Enough Permission", 'Request Denied');

        //     return redirect()->back();
        // }

        return view('admin.theme.edit')->with(compact('theme'));
    }

    // public function show($id)
    // {
    //     $role = Role::where('id', $id)->first();
    //     return view('admin.permissions.view')->with(compact('role'));
    // }

    public function store(CreateThemeRequest $request)
    {
        // if (!(auth()->user()->can('Crud Permission'))) {
        //     alert()->error("You Don't Have Enough Permission", 'Request Denied');

        //     return redirect()->back();
        // }
        return $this->repository->store();
    }

    public function update(UpdateThemeRequest $request, AppTheme $theme)
    {
        // if (!(auth()->user()->can('Crud Permission'))) {
        //     alert()->error("You Don't Have Enough Permission", 'Request Denied');

        //     return redirect()->back();
        // }
        return $this->repository->update($theme);
    }


    public function destroy($id)
    {

        // if (!(auth()->user()->can('Crud Permission'))) {
        //     alert()->error("You Don't Have Enough Permission", 'Request Denied');

        //     return redirect()->back();
        // }
        if (request()->ajax()) {
            return $this->repository->delete($id);
        }
    }
}
