@extends('admin.layouts.admin')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css" />
@endsection
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
                        <li class="breadcrumb-item active">App Theme</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class=" rounded h-100 p-4">
                    <div class="card-header modal-header d-flex align-items-center justify-content-between">
                        <h3 class="mb-0">App Theme</h3>

                        <button type="button" class="btn btn-primary btn-modal-multi waves-effect waves-light"
                            data-href="{{ action('App\Http\Controllers\Web\Theme\ThemeController@create') }}"
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
                                        <th>Seed Color</th>
                                        <th>Primary Color</th>
                                        <th>Secondary Color</th>
                                        <th>Tertiary Color</th>

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
    <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>

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
                data: 'seed_color',
                name: 'seed_color'
            },

            {
                data: 'primary_color',
                name: 'primary_color'
            },
            {
                data: 'secondary_color',
                name: 'secondary_color'
            },
            {
                data: 'tertiary_color',
                name: 'tertiary_color'
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
