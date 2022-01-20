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
                       Results for {{ $name }}

                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                               <thead>
                                   <tr>
                                       <th>Student Name</th>
                                       <th>Quiz Title</th>

                                       <th>Total</th>
                                       <th>Incorrect</th>
                                       <th>Correct</th>
                                       <th>Not Attempted</th>
                                       <th>Action</th>

                                   </tr>
                               </thead>

                               <tbody>
                                   @foreach ($results as $result)
                                       <tr>
                                           <td>{{ $result->user->name }}</td>
                                           <td>{{ $result->quiz->title }}</td>
                                           <td>{{ $result->total }}</td>
                                           <td>{{ $result->incorrect }}</td>
                                           <td>{{ $result->correct }}</td>
                                           <td>{{ $result->notAttempted }}</td>
                                           <td>
                                               <a href="{{ route('download.results', ['user' => $result->user->id, 'quiz' => $result->quiz->id]) }}"
                                                   class="btn btn-success">Download Results</a>
                                               {{-- <div class="dropdown">
                                                   <a type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                                       <i class="fas fa-ellipsis-v"></i>
                                                   </a>
                                                   <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                       <a class="dropdown-item"
                                                           href="{{ route('quiz.edit', $quiz->id) }}"><i
                                                               class="fas fa-pencil-alt"></i>Edit</a>
                                                       <a class="dropdown-item"
                                                           href="{{ route('create.question', $quiz->id) }}"><i
                                                               class="fas fa-plus-circle"></i>Add Question</a>
                                                       <a class="dropdown-item"
                                                           href="{{ route('quiz.delete', $quiz->id) }}"><i
                                                               class="fas fa-trash"></i>Delete</a>
                                                   </div>
                                               </div> --}}

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
