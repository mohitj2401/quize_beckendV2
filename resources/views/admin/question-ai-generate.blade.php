@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="row mt-4">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Generate Questions with AI for Quiz: <strong>{{ $quiz->title }}</strong></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('generate.question.ai', $quiz->id) }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="topic" class="form-label">Topic/Subject</label>
                                <input type="text" class="form-control @error('topic') is-invalid @enderror"
                                       id="topic" name="topic" placeholder="e.g., History, Biology, Mathematics"
                                       value="{{ old('topic') }}" required>
                                @error('topic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="number_of_questions" class="form-label">Number of Questions</label>
                                <input type="number" class="form-control @error('number_of_questions') is-invalid @enderror"
                                       id="number_of_questions" name="number_of_questions" min="1" max="50"
                                       value="{{ old('number_of_questions', 10) }}" required>
                                <small class="form-text text-muted">Between 1 and 50</small>
                                @error('number_of_questions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="difficulty" class="form-label">Difficulty Level</label>
                                <select class="form-control @error('difficulty') is-invalid @enderror"
                                        id="difficulty" name="difficulty" required>
                                    <option value="">-- Select Difficulty --</option>
                                    <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info" role="alert">
                                <strong>Note:</strong> Questions will be generated in the background. You will be redirected
                                to the question list. Check back later to see the generated questions.
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('question.view') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-magic"></i> Generate Questions
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
