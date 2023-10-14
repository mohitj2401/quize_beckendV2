<div class="modal-dialog modal-s modal-lg" role="document">
    <div class="modal-content  rounded h-100 p-4">
        <div class="modal-header ">
            <h4 class="modal-title">Add Role</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {!! Form::open([
            'url' => action('\App\Http\Controllers\Web\Role\RoleController@store'),
            'id' => 'ajax_form',
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @include('admin.role.form')
        {!! Form::close() !!}
    </div>
</div>
