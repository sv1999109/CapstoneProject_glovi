@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div id="area-list">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fw-bolder"> {{ $page_title }} </h4>
                        <div class="float-right">
                            <a class="btn btn-primary m-1" href="{{ route('dashboard.location.add', ['type'=> $type]) }}">
                                <ion-icon name="add-outline"></ion-icon> @lang('messages.Add_New')
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Location List -->
                        <div class="table-responsive location-list">
                            <table class="table list-table table-nowrap align-middle table-borderless"
                                xclass="table project-table table-centered table-nowrap" id="table1">
                                <thead>
                                    <tr>
                                    <tr class="text-uppercase">
                                        <th>@lang('messages.ID')</th>
                                        <th>@lang('messages.Name')</th>
                                        @if ($type == 'states')
                                            <th>{{ trans_choice('messages.Country', 1) }}</th>
                                        @endif
                                        @if ($type == 'cities')
                                            <th>{{ trans_choice('messages.State', 1) }}</th>
                                            <th>{{ trans_choice('messages.Country', 1) }}</th>
                                        @endif
                                        <th>@lang('messages.Status')</th>
                                        <th>@lang('messages.Action')</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- //Location List -->
                    </div>
                    <!--  //.card -->
                </div>

            </div>
        </div>
    </div>
@endsection
@push('css')
    <link href="{{ asset(get_theme_dir('plugins')) }}/datatables/dataTables.bootstrap5.min.css" rel="stylesheet">
    </head>
@endpush

@push('scripts')
    <script src="{{ asset(get_theme_dir('plugins')) }}/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset(get_theme_dir('plugins')) }}/datatables/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.location.datatable', ['type' => $type, 'id' => $id]) }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    }, 
                    
                    @if ($type == 'states')
                        {
                            data: 'country_code',
                            name: 'country_code'
                        },
                    @endif 
                    @if ($type == 'cities')
                        {
                            data: 'state_id',
                            name: 'state_id'
                        },
                        {
                            data: 'country_code',
                            name: 'country_code'
                        },
                    @endif 

                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
@endpush
