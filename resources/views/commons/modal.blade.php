<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $from_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button type="button" id="impButton" class="btn btn-primary" data-toggle="modal"
                    data-target="#Import">By
                    Excel</button>
                <a type="button" href="{{ url($route) }}" class="btn btn-primary">By Manual</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="Import" tabindex="-1" role="dialog" aria-labelledby="ImportLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ImportLabel">{{ $from_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['files' => 'true', 'id' => 'export_form', 'method' => 'POST', 'data-parsley-validate' => '', 'url' => $route]) !!}
                <div class="form-group">
                    {!! Form::label('excel', 'Excel File') !!}
                    {!! Form::file('excel', ['class' => 'form-control', 'data-parsley-validate' => '', 'data-parsley-required', 'data-parsley-max-file-size' => '1024', 'data-parsley-fileextension' => 'xlsx']) !!}

                </div>
                <button type="submit" class="btn btn-success">Import</button>
                <a class="btn btn-primary" style="float: right"
                    href="{{ asset('assets/excels/' . $file_name . '.xlsx') }}">Download
                    Sample</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script src="https://parsleyjs.org/dist/parsley.min.js"></script>
    <script>
        window.ParsleyValidator
            .addValidator('fileextension', function(value, requirement) {
                var fileExtension = value.split('.').pop();

                return fileExtension === requirement;
            }, 32)
            .addMessage('en', 'fileextension', 'The file type is not supported. download sample');
        window.Parsley.addValidator('maxFileSize', {
            validateString: function(_value, maxSize, parsleyInstance) {

                var files = parsleyInstance.$element[0].files;
                return files.length != 1 || files[0].size <= maxSize * 1024;
            },
            requirementType: 'integer',
            messages: {
                en: 'This file should not be larger than %s Kb',
            }
        });
        $('#export_form').parsley();

    </script>
    <script>
        $('#impButton').click(function(e) {
            e.preventDefault();
            $('#exampleModal').modal('toggle')
            $('#exampleModal').modal('hide');
        });

    </script>
@endsection
