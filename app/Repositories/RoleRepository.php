<?php

namespace App\Repositories;
// use App\Models\AuthCustomer;
use App\Models\Goal;
use App\Models\GoalDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller as Controller;
use App\Models\Customer;
use App\Models\Exam;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository
{

    public function all()
    {
        return Role::get();
    }



    public function store()
    {
        try {
            // dd(request()->all());
            // $employee_ids = Customer::where('exam_id', request()->exam_id)->pluck('id');
            // foreach ($employee_ids as $value) {
            $goal = new Role();
            $goal->name = request()->name;
            $goal->guard_name = request()->guard_name;

            $goal->save();

            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' =>  $goal,
                    'path' => '/roles',
                    'msg' => __("Role Added Successfully")
                ];
            } else {
                $output = redirect()->back();
            }
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong " . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage())
            ];
        }
        return $output;
    }


    public function update(Role $role)
    {
        try {
            $role->name = request()->name;
            $role->guard_name = request()->guard_name;

            $role->save();






            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' => '',
                    'path' => '/roles',
                    'msg' => __("Goal Information Updated Success")
                ];
            } else {
                $output = redirect()->back();
            }
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong") . $e->getMessage()
            ];
        }

        return $output;
    }
    public function delete($id)
    {

        try {
            Role::where('id', $id)->delete();


            $output = [
                'success' => true,
                'msg' => __("messages.deleted_success")
            ];
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong")
            ];
        }
        return $output;
    }

    function addPermission(Role $role)
    {
        try {







            if (request()->ajax()) {

                $role->syncPermissions(request()->permissions);
                $output = [
                    'success' => true,
                    'data' => '',
                    'path' => '/roles',
                    'msg' => __("Goal Information Updated Success")
                ];
            } else {
                $output = redirect()->back();
            }
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong") . $e->getMessage()
            ];
        }

        return $output;
    }
}
