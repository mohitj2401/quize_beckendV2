@extends('admin.layouts.admin')
@section('content')
    <main>
        <div class="container" style="margin-top: 20px;">
            <div class="card">
                <div class="card-header">{{ __('Question Create') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('create.question', Request::route('quiz')) }}">
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Question') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('question') is-invalid @enderror"
                                    name="question" value="{{ old('question') }}" required autofocus>

                                @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Option 1 (Correct Option)') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('option1') is-invalid @enderror"
                                    name="option1" value="{{ old('option1') }}" required autofocus>

                                @error('option1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Option 2 ') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('option2') is-invalid @enderror"
                                    name="option2" value="{{ old('option2') }}" required autofocus>

                                @error('option2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Option 3') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('option3') is-invalid @enderror"
                                    name="option3" value="{{ old('option3') }}" required autofocus>

                                @error('option3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Option 4') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('option4') is-invalid @enderror"
                                    name="option4" value="{{ old('option4') }}" required autofocus>

                                @error('option4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create Question') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection
