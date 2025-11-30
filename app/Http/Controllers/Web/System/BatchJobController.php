<?php

namespace App\Http\Controllers\Web\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BatchJobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = [];

        if (Schema::hasTable('jobs')) {
            $data['jobs'] = DB::table('jobs')->orderBy('id', 'desc')->limit(200)->get();
            $data['jobs_count'] = DB::table('jobs')->count();
        } else {
            $data['jobs'] = collect();
            $data['jobs_count'] = 0;
        }

        if (Schema::hasTable('failed_jobs')) {
            $data['failed_jobs'] = DB::table('failed_jobs')->orderBy('id', 'desc')->limit(200)->get();
            $data['failed_count'] = DB::table('failed_jobs')->count();
        } else {
            $data['failed_jobs'] = collect();
            $data['failed_count'] = 0;
        }

        $data['active'] = 'system';
        $data['title'] = 'Batch Jobs | Quizie';

        return view('admin.batch_jobs.index', $data);
    }

    /**
     * Retry a failed job
     */
    public function retry($failedJobId)
    {
        if (!Schema::hasTable('failed_jobs')) {
            alert()->error('Failed jobs table not found');
            return redirect()->back();
        }

        $failedJob = DB::table('failed_jobs')->where('id', $failedJobId)->first();

        if (!$failedJob) {
            alert()->error('Failed job not found');
            return redirect()->back();
        }

        try {
            // Move failed job back to jobs queue
            if (Schema::hasTable('jobs')) {
                DB::table('jobs')->insert([
                    'queue' => $failedJob->queue,
                    'payload' => $failedJob->payload,
                    'attempts' => 0,
                    'reserved_at' => null,
                    'available_at' => now(),
                    'created_at' => now(),
                ]);
            }

            // Delete from failed_jobs
            DB::table('failed_jobs')->where('id', $failedJobId)->delete();

            alert()->success('Failed job has been queued for retry');
        } catch (\Exception $e) {
            alert()->error('Failed to retry job: ' . $e->getMessage());
        }

        return redirect()->back();
    }
}
