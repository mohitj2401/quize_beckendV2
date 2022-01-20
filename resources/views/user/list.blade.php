   @extends('admin.layouts.admin')
   @section('style')
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css">
       <style>
           .dropdown-item>svg {
               margin-right: 10px;
           }

           .toggle-off.btn {
               padding-left: 0px !important;
           }

           .toggle-on.btn {
               padding-right: 0px !important;
           }

       </style>
   @endsection
   @section('content')

       <main>
           <div class="container-fluid mt-5">


               <div class="card mb-4">
                   <div class="card-header">
                       <i class="fas fa-table mr-1"></i>
                       User List
                       <a data-toggle="modal" data-target="#Import" href=""><i class="fas fa-plus-circle"
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


                                       <th>Email</th>

                                       <th>Status</th>
                                       <th>Created At</th>
                                       @if (auth()->user()->usertype_id == 1)
                                           <th>Action</th>
                                       @endif
                                   </tr>
                               </thead>

                               <tbody>
                                   @foreach ($users as $user)
                                       <tr>
                                           <td>{{ $user->name }}</td>
                                           <td>{{ $user->email }}</td>
                                           <td> <input type="checkbox" class="userStatus" rel="{{ $user->id }}"
                                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger" @if ($user->status == 1) checked @endif>
                                           </td>

                                           <td>{{ $user->created_at }}</td>
                                           @if (auth()->user()->usertype_id == 1)

                                               <td>

                                                   <div class="dropdown">
                                                       <a type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                                           <i class="fas fa-ellipsis-v"></i>
                                                       </a>
                                                       <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                           <a class="dropdown-item"
                                                               href="{{ route('user.delete', $user->id) }}"><i
                                                                   class="fas fa-trash"></i>Delete</a>
                                                       </div>
                                                   </div>

                                               </td>
                                           @endif
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
   @if (auth()->user()->usertype_id == 1)
       @include('commons.modal',array('from_title'=>'Teacher
       Create','route'=>'/user/create','file_name'=>'user_sample'))
   @else
       @include('commons.modal',array('from_title'=>'Student
       Create','route'=>'/user/create','file_name'=>'user_sample'))
   @endif
   @section('scripts')

       <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap2-toggle.js"></script>

       <script>
           $('.userStatus').change(function() {

               var id = $(this).attr('rel');
               var token = '{{ csrf_token() }}';
               var url = "{{ url('/user/approve') }}";
               if ($(this).prop('checked') == true) {
                   $.ajax({

                       type: 'post',
                       url: url,
                       data: {
                           status: '1',
                           id: id,
                           _token: token
                       },
                       success: function(data) {


                       },
                       error: function(res) {

                           alert('Something Went Wrong Please Try Again!');
                       }

                   });
               } else {
                   $.ajax({
                       type: 'post',
                       url: url,
                       data: {
                           status: '0',
                           id: id,
                           _token: token
                       },
                       success: function(resp) {




                       },
                       error: function(err) {
                           alert('Something Went Wrong Please Try Again!');
                       }

                   })
               }
           });
       </script>
   @endsection
