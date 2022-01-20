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
                       Subjects
                       <a data-toggle="modal" data-target="#exampleModal" href=""><i class="fas fa-plus-circle"
                               style="float: right;
                                                                                                                                                                                                font-size: 23px;
                                                                                                                                                                                                "></i></a>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                               <thead>
                                   <tr>
                                       <th>Name</th>
                                       <th>Code</th>
                                       <th>Created By</th>
                                       <th>Total Quiz</th>
                                       <th>Status</th>
                                       <th>Action</th>

                                   </tr>
                               </thead>

                               <tbody>
                                   @foreach ($subjects as $subject)
                                       <tr>
                                           <td>{{ $subject->name }}</td>
                                           <td>{{ $subject->code }}</td>
                                           <td>{{ $subject->user->name }}</td>

                                           <td>{{ $subject->quiz()->count() }}</td>
                                           <td>{{ $subject->status == 1 ? 'Active' : 'Deactive' }}</td>
                                           <td>
                                               @if ($subject->user->id == auth()->user()->id)
                                                   <div class="dropdown">
                                                       <a type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                                           <i class="fas fa-ellipsis-v"></i>
                                                       </a>
                                                       <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                           <a class="dropdown-item"
                                                               href="{{ route('teacher.edit.subject', $subject->id) }}"><i
                                                                   class="fas fa-pencil-alt"></i>Edit</a>
                                                           @if ($subject->status != 1)
                                                               <a class="dropdown-item"
                                                                   href="{{ route('subject.status', ['subject' => $subject->id, 'status' => 'active']) }}"><i
                                                                       class="fas fa-exclamation"></i>Active</a>
                                                           @else
                                                               <a class="dropdown-item"
                                                                   href="{{ route('subject.status', ['subject' => $subject->id, 'status' => 'inactive']) }}"><i
                                                                       class="fas fa-exclamation"></i>Inactive</a>

                                                           @endif
                                                           <a class="dropdown-item"
                                                               href="{{ route('subject.delete', $subject->id) }}"><i
                                                                   class="fas fa-trash"></i>Delete</a>
                                                       </div>
                                                   </div>
                                               @else
                                                   Not Allowed
                                               @endif
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

   @include('commons.modal',array('from_title'=>'Subject
   Create','route'=>'/create/subject','file_name'=>'subject_sample'))
