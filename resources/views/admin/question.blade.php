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
           <div class="container-fluid">


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

                                       <th>Created By</th>
                                       <th>Total Questions</th>
                                       <th>Role</th>
                                       <th>Date</th>
                                       <th>Action</th>

                                   </tr>
                               </thead>

                               <tbody>
                                   @foreach ($quizzes as $quiz)
                                       <tr>
                                           <td>{{ $quiz->title }}</td>
                                           <td>{{ $quiz->user->name }}</td>
                                           <td>{{ $quiz->question()->count() }}</td>
                                           <td>{{ $quiz->user->role }}</td>
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
                                                       <a class="dropdown-item" href="#"><i
                                                               class="fas fa-plus-circle"></i>Add Question</a>
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
   @endsection
