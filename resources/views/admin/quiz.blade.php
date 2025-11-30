   @extends('admin.layouts.admin')
   @section('style')
       <style>
           .dropdown-item>svg {
               margin-right: 10px;
           }

       </style>
   @endsection
   @section('content')

       <main>
           <div class="container-fluid mt-5">


               <div class="card mb-4">
                   <div class="card-header">
                       <i class="fas fa-table mr-1"></i>
                       Quiz
                       <a href="{{ route('create.quiz') }}"><i class="fas fa-plus-circle" style="float: right;
                                                                font-size: 23px;
                                                                "></i></a>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                               <thead>
                                   <tr>
                                       <th>Title</th>
                                       <th>Total Questions</th>
                                       <th>Attempted User</th>

                                       <th>Date</th>
                                       <th>Action</th>

                                   </tr>
                               </thead>

                               <tbody>
                                   @foreach ($quizzes as $quiz)
                                       <tr>
                                           <td>{{ $quiz->title }}</td>

                                           <td>{{ $quiz->question()->count() }}</td>
                                           <td>{{ count($quiz->result) }}</td>
                                           <td>{{ $quiz->created_at }}</td>
                                           <td>
                                               <div class="dropdown">
                                                   <a type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                                       <i class="fas fa-ellipsis-v"></i>
                                                   </a>
                                                   <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                       <a class="dropdown-item"
                                                           href="{{ route('quiz.edit', $quiz->id) }}"><i
                                                               class="fas fa-pencil-alt"></i>Edit</a>
                                                       <a class="dropdown-item"
                                                           href="{{ route('quiz.results', $quiz->id) }}"><i
                                                               class="fas fa-eye"></i>User Attempted</a>
                                                       <a class="dropdown-item"
                                                           href="{{ route('create.question', $quiz->id) }}"><i
                                                               class="fas fa-plus-circle"></i>Add Question</a>
                                                       <a class="dropdown-item" href="#" data-toggle="modal" data-target="#aiGenerateModal{{ $quiz->id }}"><i
                                                               class="fas fa-robot"></i>Generate Questions with AI</a>
                                                       <a class="dropdown-item"
                                                           href="{{ route('quiz.delete', $quiz->id) }}"><i
                                                               class="fas fa-trash"></i>Delete</a>
                                                   </div>
                                               </div>

                                           </td>
                                       </tr>
                                   @endforeach
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>

           </div>
       </main>

       <!-- AI Generate Questions Modals -->
       @foreach ($quizzes as $quiz)
           <div class="modal fade" id="aiGenerateModal{{ $quiz->id }}" tabindex="-1" role="dialog" aria-labelledby="aiGenerateLabel{{ $quiz->id }}" aria-hidden="true">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title" id="aiGenerateLabel{{ $quiz->id }}">Generate Questions with AI</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                       </div>
                       <form method="POST" action="{{ route('generate.question.ai', $quiz->id) }}">
                           @csrf
                           <div class="modal-body">
                               <div class="form-group">
                                   <label for="topic{{ $quiz->id }}">Topic/Subject</label>
                                   <input type="text" class="form-control" id="topic{{ $quiz->id }}" name="topic" placeholder="e.g., History, Biology"
                                   value="{{$quiz->title}}" required>
                               </div>
                               <div class="form-group">
                                   <label for="number{{ $quiz->id }}">Number of Questions</label>
                                   <input type="number" class="form-control" id="number{{ $quiz->id }}" name="number_of_questions" min="1" max="50" value="10" required>
                               </div>
                               <div class="form-group">
                                   <label for="difficulty{{ $quiz->id }}">Difficulty Level</label>
                                   <select class="form-control" id="difficulty{{ $quiz->id }}" name="difficulty" required>
                                       <option value="easy">Easy</option>
                                       <option value="medium" selected>Medium</option>
                                       <option value="hard">Hard</option>
                                   </select>
                               </div>
                           </div>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                               <button type="submit" class="btn btn-primary">Generate Questions</button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       @endforeach
   @endsection
