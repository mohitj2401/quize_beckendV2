     @extends('admin.layouts.admin')
     @section('content')

         <main>
             <div class="container-fluid">
                 <h3 class="my-4 text-secondary">Changed Password</h3>

                 <div class="card mb-4">
                     <div class="card-body">
                         <div class="container">
                             <form action="{{ route('user.changepass') }}" method="post" id="pass-form"
                                 data-parsley-trigger="keyup" data-parsley-validate>
                                 @csrf
                                 <div class="form-group col-lg-12">

                                     <input type="password" name="old_password" placeholder="Enter Old Password" id=""
                                         class="form-control" required>
                                 </div>
                                 <div class="form-group col-lg-12">
                                     <input id="password" type="password"
                                         class="form-control @error('password') is-invalid @enderror" name="password"
                                         required autocomplete="new-password" placeholder="Password"
                                         data-parsley-minlength="8" data-parsley-errors-container=".errorspannewpassinput"
                                         data-parsley-required-message="Please enter your new password."
                                         data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1"
                                         data-parsley-special="1" data-parsley-required>


                                 </div>
                                 <!-- Form Group -->
                                 <div class="form-group col-lg-12">
                                     <input id="password-confirm" type="password" class="form-control"
                                         name="password_confirmation" required autocomplete="new-password"
                                         placeholder="Confirm Password" data-parsley-minlength="8"
                                         data-parsley-errors-container=".errorspanconfirmnewpassinput"
                                         data-parsley-required-message="Please re-enter your new password."
                                         data-parsley-equalto-message="password does not match."
                                         data-parsley-equalto="#password" data-parsley-required>
                                 </div>
                                 <div class="col-lg-12 text-center">
                                     <button class="btn btn-outline-primary" type="submit">Update</button>
                                 </div>

                             </form>
                         </div>
                     </div>

                 </div>

             </div>
         </main>
     @endsection
     @section('scripts')
         <script src="https://parsleyjs.org/dist/parsley.min.js"></script>

         <script>
             window.Parsley.addValidator('uppercase', {
                 requirementType: 'number',
                 validateString: function(value, requirement) {
                     var uppercases = value.match(/[A-Z]/g) || [];
                     return uppercases.length >= requirement;
                 },
                 messages: {
                     en: 'Your password must contain at least (%s) uppercase letter.'
                 }
             });

             //has lowercase
             window.Parsley.addValidator('lowercase', {
                 requirementType: 'number',
                 validateString: function(value, requirement) {
                     var lowecases = value.match(/[a-z]/g) || [];
                     return lowecases.length >= requirement;
                 },
                 messages: {
                     en: 'Your password must contain at least (%s) lowercase letter.'
                 }
             });

             //has number
             window.Parsley.addValidator('number', {
                 requirementType: 'number',
                 validateString: function(value, requirement) {
                     var numbers = value.match(/[0-9]/g) || [];
                     return numbers.length >= requirement;
                 },
                 messages: {
                     en: 'Your password must contain at least (%s) number.'
                 }
             });

             //has special char
             window.Parsley.addValidator('special', {
                 requirementType: 'number',
                 validateString: function(value, requirement) {
                     var specials = value.match(/[^a-zA-Z0-9]/g) || [];
                     return specials.length >= requirement;
                 },
                 messages: {
                     en: 'Your password must contain at least (%s) special characters.'
                 }
             });
             $('#pass-form').parsley();
         </script>
     @endsection
