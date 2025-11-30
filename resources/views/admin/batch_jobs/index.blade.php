@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Batch Jobs</h1>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Queued Jobs</h5>
                        <p class="mb-0">Count: {{ $jobs_count ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Failed Jobs</h5>
                        <p class="mb-0">Count: {{ $failed_count ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">Queued Jobs (latest)</div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Queue</th>
                            <th>Payload</th>
                            <th>Attempts</th>
                            <th>Reserved At</th>
                            <th>Available At</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                            <tr>
                                <td>{{ $job->id ?? '-' }}</td>
                                <td>{{ $job->queue ?? '-' }}</td>
                                <td style="max-width:400px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $job->payload ?? '-' }}</td>
                                <td>{{ $job->attempts ?? '-' }}</td>
                                <td>{{ $job->reserved_at ?? '-' }}</td>
                                <td>{{ $job->available_at ?? '-' }}</td>
                                <td>{{ $job->created_at ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7">No queued jobs</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">Failed Jobs (latest)</div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Connection</th>
                            <th>Queue</th>
                            <th>Payload / Exception</th>
                            <th>Failed At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($failed_jobs as $f)
                            <tr>
                                <td>{{ $f->id ?? '-' }}</td>
                                <td>{{ $f->connection ?? '-' }}</td>
                                <td>{{ $f->queue ?? '-' }}</td>
                                <td style="max-width:400px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">@if(isset($f->payload)){{ $f->payload }}@else {{ $f->exception ?? '-' }}@endif</td>
                                <td>{{ $f->failed_at ?? '-' }}</td>
                                <td>
                                    <form method="POST" action="{{ route('system.batch-jobs.retry', $f->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning" title="Retry this job">
                                            <i class="fas fa-redo"></i> Retry
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6">No failed jobs</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
