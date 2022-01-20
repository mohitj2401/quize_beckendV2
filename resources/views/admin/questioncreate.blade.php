@extends('admin.layouts.admin')
@section('style')
    <style>
        .mt-10 {
            margin-top: 10px;
        }

    </style>
@endsection
@section('content')
    @if (Session::has('quiz_id'))
        <?php $quiz_id = Session::get('quiz_id'); ?>
    @else
        <?php $quiz_id = ''; ?>
    @endif
    <main>
        <div class="container" style="margin-top: 20px;">
            <div class="card">
                <div class="card-header">{{ __('Create Question') }}
                    <a class="btn  btn-sm btn-primary" style="float: right"
                        href="{{ asset('assets/excels/sample.xlsx') }}">
                        Download Sample file
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('create.question') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Quiz') }}</label>

                            <div class="col-md-8">
                                <select name="quiz" id="quiz" class="form-control @error('quiz') is-invalid @enderror"
                                    required>
                                    <option value="">Select Quiz</option>
                                    @foreach ($quizzes as $quiz)
                                        <option value="{{ $quiz->id }}" @if ($quiz_id == $quiz->id) selected @endif>
                                            {{ $quiz->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('quiz')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ __('Excel File') }}</label>

                            <div class="col-md-8">
                                <input type="file" class="form-control @error('excel') is-invalid @enderror" name="excel"
                                    required>

                                @error('excel')
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
            <div class="card mb-4 mt-10">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Questions for <span id="selectedquiz"></span>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Option 1(Currect option)</th>
                                    <th>Option 2</th>
                                    <th>Option 3</th>
                                    <th>Option 4</th>

                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody id="tableBody">



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
@section('scripts')
    @if ($quiz_id)

        <script>
            $(document).ready(function() {
                $('#selectedquiz').empty();
                url = "{{ url('/get/questions/') }}" + '/' + "{{ $quiz_id }}";
                $('#selectedquiz').append($('#quiz option:selected').text());

                $.ajax({
                    type: "get",
                    url: url,
                    success: function(response) {

                        $('#tableBody').empty();
                        var len = 0;


                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var title = response['data'][i].title;
                                var id = response['data'][i].id;
                                var option1 = response['data'][i].option1;
                                var option2 = response['data'][i].option2;
                                var option3 = response['data'][i].option3;
                                var option4 = response['data'][i].option4;
                                var route = "{{ url('/question/delete/') }}" + '/' + id + '/' +
                                    response[
                                        'data'][i].quiz_id;
                                var option =
                                    '<tr><td>' + title + '</td><td>' + option1 + '</td><td>' + option2 +
                                    '</td><td>' + option3 +
                                    '</td><td>' + option4 +
                                    '</td><td><a class="btn btn-danger" href="' + route +
                                    '"><i class="fas fa-trash"></i></a></td></tr>';
                                $('#tableBody').append(option);
                            }
                        }
                    },
                    error: function(response) {
                        console.log('Something Went Worng Please Try Again!');
                    }
                });
            });

        </script>
    @endif
    <script>
        $("#quiz").change(function() {
            $('#selectedquiz').empty();
            url = "{{ url('/get/questions/') }}" + '/' + $(this).val();
            $('#selectedquiz').append($('#quiz option:selected').text());

            $.ajax({
                type: "get",
                url: url,
                success: function(response) {

                    $('#tableBody').empty();
                    var len = 0;


                    if (response['data'] != null) {
                        len = response['data'].length;
                    }

                    if (len > 0) {
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var title = response['data'][i].title;
                            var id = response['data'][i].id;
                            var option1 = response['data'][i].option1;
                            var option2 = response['data'][i].option2;
                            var option3 = response['data'][i].option3;
                            var option4 = response['data'][i].option4;
                            var route = "{{ url('/question/delete/') }}" + '/' + id + '/' + response[
                                'data'][i].quiz_id;
                            var option =
                                '<tr><td>' + title + '</td><td>' + option1 + '</td><td>' + option2 +
                                '</td><td>' + option3 +
                                '</td><td>' + option4 +
                                '</td><td><a class="btn btn-danger" href="' + route +
                                '"><i class="fas fa-trash"></i></a></td></tr>';
                            $('#tableBody').append(option);
                        }
                    }
                },
                error: function(response) {
                    console.log('Something Went Worng Please Try Again!');
                }
            });
        });

    </script>
@endsection
