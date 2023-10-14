@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row page-titles">
            {{-- <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Goal</h4>
        </div> --}}
            <div class="col-md-12 align-self-end text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Permission</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class=" rounded h-100 p-4">
                    <div class="card-header modal-header d-flex align-items-center justify-content-between">
                        <h3 class="mb-0">Permission</h3>

                        <button type="button" class="btn btn-primary btn-modal-multi waves-effect waves-light"
                            data-href="{{ action('App\Http\Controllers\Web\Permission\PermissionController@create') }}"
                            data-container="">
                            <i class="fa fa-plus"></i> Add
                        </button>

                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="data_table" class="table table-dark table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Guard Name</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="ajax_modal" tabindex="-1" role="dialog"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.btn-modal-multi', function(e) {

            e.preventDefault();

            var container = '#ajax_modal';
            $.ajax({
                url: $(this).data('href'),
                dataType: 'html',
                success: function(result) {
                    $(container)
                        .html(result)
                        .modal('show');

                },
            });
        });
        var columns = [{
                data: 'name',
                name: 'name'
            },
            {
                data: 'guard_name',
                name: 'guard_name'
            },


            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },



        ];
    </script>
    @include('admin.layouts.partials.common-js');
@endsection
