<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content  rounded h-100 p-4">
        <div class="modal-header ">
            <h4 class="modal-title">View</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('Subject Name :', null, ['class' => 'label text-white']) }}
                        <span>{{ $role->name }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('Credit :', null, ['class' => 'label text-white']) }}
                        <span>{{ $role->guard_name }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('Passing Marks :', null, ['class' => 'label text-white']) }}
                        <span>{{ $role->permissions }}</span>
                    </div>
                </div>



            </div>
        </div>

    </div>
</div>
