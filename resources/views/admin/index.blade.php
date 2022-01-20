     @extends('admin.layouts.admin')
     @section('content')

         <main>
             <div class="container-fluid">
                 <h1 class="mt-4">Dashboard</h1>

                 <div class="card mb-4">
                     <div class="card-header">
                         <i class="fas fa-table mr-1"></i>
                         Quiz
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

                                     </tr>
                                 </thead>

                                 <tbody>
                                     @foreach ($quizzes as $quiz)
                                         <tr>
                                             <td>{{ $quiz->title }}</td>
                                             <td>{{ $quiz->user->name }}</td>
                                             <td>{{ $quiz->question()->count() }}</td>
                                             <td>{{ $quiz->user->usertype->role }}</td>
                                             <td>{{ $quiz->created_at }}</td>

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
