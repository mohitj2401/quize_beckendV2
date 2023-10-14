<div class="modal-dialog modal-s modal-lg" role="document">
    <div class="modal-content  rounded h-100 p-4">
        <div class="modal-header ">
            <h4 class="modal-title">Add Permission</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {!! Form::open([
            'url' => action('\App\Http\Controllers\Web\Role\RoleController@storePermission', [$role->id]),
            'id' => 'ajax_form',
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ]) !!}
        <div class="modal-body">
            <div class="form-row mb-4">

                <div class="form-group col-md-12">
                    {{ Form::label('Permission', null, ['class' => 'label text-black']) }}
                    {!! Form::select('permissions[]', $permissions, $role->permissions()->pluck('name') ?? [], [
                        'class' => 'form-control js-example-basic-multiple',
                        'multiple',
                    ]) !!}


                </div>




            </div>
        </div>
        <div class="modal-footer">

            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


            <button class="btn btn-primary" type="submit">Save</button>
        </div>

        {!! Form::close() !!}
    </div>
</div>
