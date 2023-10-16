<div class="modal-dialog modal-s modal-lg" role="document">
    <div class="modal-content  rounded h-100 p-4">
        <div class="modal-header ">
            <h4 class="modal-title">Edit</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        {!! Form::open([
            'url' => action('App\Http\Controllers\Web\Theme\ThemeController@update', [$theme->id]),
            'method' => 'PUT',
            'id' => 'ajax_form',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @php
            $form = 'edit';
        @endphp
        @include('admin.theme.form')
        {!! Form::close() !!}
    </div>
</div>
