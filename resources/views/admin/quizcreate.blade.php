@extends('admin.layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.datetimepicker.css') }}" />
@endsection
@section('content')
    <main>
        <div class="container" style="margin-top: 20px;">
            <div class="card">
                <div class="card-header">{{ __('Create Quiz') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('create.quiz') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Title') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                    value="{{ old('title') }}" required autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Image') }}</label>

                            <div class="col-md-8">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                                    required>

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Subject') }}</label>

                            <div class="col-md-8">
                                <select name="subject" class="form-control" required>
                                    <option value="">Select a subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Duration (In Minutes)') }}</label>

                            <div class="col-md-8">
                                <input class="form-control @error('duration') is-invalid @enderror" type="number"
                                    name="duration" value="{{ old('duration') }}" required>

                                @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Start Time') }}</label>

                            <div class="col-md-8">
                                <input type="text" id="demo" name="start_date" value="{{old('start_date')}}" onchange="updateEndDtae();" required />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('End Time') }}</label>

                            <div class="col-md-8">
                                <input type="text" id="demo2" name="end_date"  value="{{old('end_date')}}"required />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Description') }}</label>

                            <div class="col-md-8">
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="10"
                                    name="description" required>{{ old('description') }} </textarea>

                                @error('description')
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
@section('scripts')
    <script src="{{ asset('assets/js/jquery.datetimepicker.full.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#demo').datetimepicker({

                mask: true,
                minDate: 0,
                format: 'Y/m/d H:i',
                minTime: 0,

            });
        });

        function updateEndDtae() {
            var min = $('#demo').val();

            $('#demo2').datetimepicker({

                mask: true,
                minDate: min,

                format: 'Y/m/d H:i'

            });
        }

    </script>
@endsection
