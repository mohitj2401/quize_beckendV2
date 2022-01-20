@extends('admin.layouts.admin')
@section('content')
    <main>
        <div class="container" style="margin-top: 20px;">
            <div class="card">
                <div class="card-header">{{ __('Edit Subject') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('teacher.edit.subject', $subject->id) }}">
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Name') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') ?? $subject->name }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Code') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                    value="{{ old('code') ?? $subject->code }}" required autofocus>

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create Quiz') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection
