@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Generate Quiz with AI</h6>
                        <a href="{{ route('create.quiz') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Manual Create
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-robot"></i> <strong>AI-Powered Quiz Generation</strong><br>
                            Enter a topic and let AI generate quiz questions for you automatically!
                        </div>

                        <form action="{{ route('generate.quiz.ai') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="topic">Topic <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('topic') is-invalid @enderror" 
                                               id="topic" name="topic" value="{{ old('topic') }}" 
                                               placeholder="e.g., World War II, Python Programming, Human Anatomy"
                                               required>
                                        @error('topic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject">Subject <span class="text-danger">*</span></label>
                                        <select class="form-control @error('subject') is-invalid @enderror" 
                                                id="subject" name="subject" required>
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ old('subject') == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="number_of_questions">Number of Questions <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('number_of_questions') is-invalid @enderror" 
                                               id="number_of_questions" name="number_of_questions" 
                                               value="{{ old('number_of_questions', 10) }}" 
                                               min="5" max="50" required>
                                        <small class="form-text text-muted">Between 5 and 50 questions</small>
                                        @error('number_of_questions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="difficulty">Difficulty Level <span class="text-danger">*</span></label>
                                        <select class="form-control @error('difficulty') is-invalid @enderror" 
                                                id="difficulty" name="difficulty" required>
                                            <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                            <option value="medium" {{ old('difficulty', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                                        </select>
                                        @error('difficulty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="duration">Duration (minutes) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                               id="duration" name="duration" 
                                               value="{{ old('duration', 30) }}" 
                                               min="5" required>
                                        @error('duration')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date & Time</label>
                                        <input type="datetime-local" class="form-control" 
                                               id="start_date" name="start_date" 
                                               value="{{ old('start_date', now()->format('Y-m-d\TH:i')) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date & Time</label>
                                        <input type="datetime-local" class="form-control" 
                                               id="end_date" name="end_date" 
                                               value="{{ old('end_date', now()->addDays(30)->format('Y-m-d\TH:i')) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image">Quiz Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/png,image/jpg,image/jpeg" required>
                                <small class="form-text text-muted">Upload a PNG or JPG image</small>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> <strong>Note:</strong> 
                                AI generation may take 10-30 seconds depending on the number of questions. 
                                Please be patient and don't refresh the page.
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-magic"></i> Generate Quiz with AI
                                </button>
                                <a href="{{ route('quiz.view') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Show loading state when form is submitted
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Quiz...';
    });
</script>
@endsection
