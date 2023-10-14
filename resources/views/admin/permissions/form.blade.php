<div class="modal-body">
    <div class="form-row mb-4">
        <div class="form-group col-md-12">
            {!! Form::label('Name:*') !!}
            {!! Form::text('name', $permission->name ?? '', ['class' => 'form-control']) !!}
            <span class="md-line" id="name_error"></span>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('Guard Name: ', null, ['class' => 'label text-black']) }}
            {!! Form::select('guard_name', ['web' => 'Web', 'api' => 'Api'], $permission->guard_name ?? [], [
                'class' => 'form-control',
            ]) !!}


        </div>




    </div>
</div>
<div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


    <button class="btn btn-primary" type="submit">Save</button>
</div>
