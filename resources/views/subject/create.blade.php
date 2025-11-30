@extends('admin.layouts.admin')
@section('content')
    <main>
        <div class="container" style="margin-top: 20px;">
            <div class="card">
                <div class="card-header">{{ __('Create Subject') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('teacher.create.subject') }}">
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label ">{{ __('Name') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autofocus>

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
                                    value="{{ old('code') }}" required autofocus>

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="generate_with_ai"
                                           name="generate_with_ai" value="1" {{ old('generate_with_ai') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="generate_with_ai">
                                        <i class="fas fa-robot text-primary"></i>
                                        <strong>Generate Quiz & Questions with AI</strong>
                                    </label>
                                    <small class="form-text text-muted">
                                        Automatically create a quiz with AI-generated questions for this subject
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div id="ai_options" style="display: none;">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ __('Number of Questions') }}</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="number_of_questions"
                                           value="{{ old('number_of_questions', 10) }}" min="5" max="50">
                                    <small class="form-text text-muted">Between 5 and 50 questions</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ __('Difficulty Level') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="difficulty">
                                        <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                        <option value="medium" {{ old('difficulty', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ __('Quiz Duration (minutes)') }}</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="duration"
                                           value="{{ old('duration', 30) }}" min="5">
                                </div>
                            </div>

                            <div class="alert alert-info col-md-8 offset-md-3">
                                <i class="fas fa-info-circle"></i>
                                AI will generate questions based on the subject name. Make sure the subject name is descriptive!
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create Subject') }}
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
<script>
    // Show/hide AI options based on checkbox
    document.getElementById('generate_with_ai').addEventListener('change', function() {
        document.getElementById('ai_options').style.display = this.checked ? 'block' : 'none';
    });

    // Show AI options if checkbox is already checked (on page load with old input)
    if (document.getElementById('generate_with_ai').checked) {
        document.getElementById('ai_options').style.display = 'block';
    }
</script>
@endsection
