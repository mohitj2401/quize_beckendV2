<div class="modal-body">
    <div class="form-row mb-4">
        <div class="form-group col-md-12">
            {!! Form::label('Name:*') !!}
            {!! Form::text('name', $theme->name ?? '', ['class' => 'form-control']) !!}
            <span class="md-line" id="name_error"></span>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('Seed Color: ', null, ['class' => 'label text-black']) }}
            {!! Form::color('seed_color', $theme->seed_color ?? '', ['class' => 'form-control']) !!}

            <span class="md-line" id="seed_color_error"></span>
        </div>


        <div class="form-group col-md-12">
            {{ Form::label('Primary Color: ', null, ['class' => 'label text-black']) }}
            {!! Form::color('primary_color', $theme->primary_color ?? '', ['class' => 'form-control']) !!}

            <span class="md-line" id="primary_color_error"></span>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('Secondary Color: ', null, ['class' => 'label text-black']) }}
            {!! Form::color('secondary_color', $theme->secondary_color ?? '', ['class' => 'form-control']) !!}

            <span class="md-line" id="secondary_color_error"></span>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('Tertiary Color: ', null, ['class' => 'label text-black']) }}
            {!! Form::color('tertiary_color', $theme->tertiary_color ?? '', ['class' => 'form-control']) !!}

            <span class="md-line" id="tertiary_color_error"></span>
        </div>


    </div>
</div>
<div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


    <button class="btn btn-primary" type="submit">Save</button>
</div>
