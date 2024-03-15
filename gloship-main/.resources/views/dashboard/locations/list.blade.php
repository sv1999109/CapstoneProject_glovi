@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div id="area-list">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0"> {{ $page_title }}</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a class="btn btn-primary add-btn" href="{{ route('dashboard.location.add', ['type'=> $type]) }}">
                                    <i class="bi bi-plus-circle align-baseline me-1"></i>@lang('messages.Add_New')
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Location List -->
                        <div class="table-responsive location-list">
                            <table class="table list-table table-nowrap align-middle table-borderless" id="table1">
                                <thead>
                                    <tr>
                                    <tr class="text-uppercase">
                                        <th>@lang('messages.ID')</th>
                                        <th>@lang('messages.Name')</th>
                                        @if ($type == 'countries')
                                            <th>@lang('messages.Code')</th>
                                            <th>@lang('messages.Phone_Code')</th>
                                            <th>@lang('messages.Region')</th>
                                        @endif
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
                language: {
                    url: "{{ asset(get_theme_dir('plugins')) }}/datatables/{{LaravelLocalization::getCurrentLocale()}}.json"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.location.datatable', ['type' => $type]) }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    }, 
                    @if ($type == 'countries')
                        {
                            data: 'iso2',
                            name: 'iso2'
                        }, 
                        {
                            data: 'phone_code',
                            name: 'phone_code'
                        },
                        {
                            data: 'region',
                            name: 'region'
                        },
                    @endif 
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
