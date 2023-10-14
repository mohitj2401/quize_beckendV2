<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content bg-dark  rounded h-100 p-4">
        <div class="modal-header  bg-dark">
            <h4 class="modal-title text-white">View</h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('Name :', null, ['class' => 'label text-white']) }}
                        <span class="text-white">{{ $role->name }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('Credit :', null, ['class' => 'label text-white']) }}
                        <span class="text-white">{{ $role->guard_name }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('Permission :', null, ['class' => 'label text-white']) }}
                        @foreach ($role->permissions as $item)
                            <div class="text-white pl-5">{{ $item->name }}</div>
                        @endforeach
                    </div>
                </div>



            </div>
        </div>

    </div>
</div>
