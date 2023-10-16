<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;

use App\Models\AppTheme;

class ThemeRepository
{

    public function all()
    {
        return AppTheme::get();
    }



    public function store()
    {
        try {
            // dd(request()->all());
            // $employee_ids = Customer::where('exam_id', request()->exam_id)->pluck('id');
            // foreach ($employee_ids as $value) {
            $goal = new AppTheme();
            $goal->name = request()->name;
            $goal->seed_color = request()->seed_color;
            $goal->primary_color = request()->primary_color;
            $goal->secondary_color = request()->secondary_color;
            $goal->tertiary_color = request()->tertiary_color;

            $goal->save();

            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' =>  $goal,
                    'path' => '/permissions',
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


    public function update(AppTheme $role)
    {
        try {
            $role->name = request()->name;
            $role->guard_name = request()->guard_name;

            $role->save();






            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' => '',
                    'path' => '/permissions',
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
            AppTheme::where('id', $id)->delete();


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
}
