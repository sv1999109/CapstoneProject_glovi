@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div id="branch-list">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0"> {{ $page_title }}</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a class="btn btn-primary add-btn" href="{{ route('dashboard.branch.add') }}">
                                    <i class="bi bi-plus-circle align-baseline me-1"></i>@lang('messages.Add_Branch')
                                </a>
                            </div>
                        </div>
                    </div>
                   
                    <div class="card-body">
                        <!-- Covered Branches List -->
                        <div class="table-responsive covered branches-list">
                            <table class="table project-table table-centered table-nowrap" id="table1">
                                <thead>
                                    <tr>
                                    <tr class="text-uppercase">
                                        <th>@lang('messages.Code')</th>
                                        <th>@lang('messages.Name')</th>
                                        <th>{{ trans_choice('messages.Address', 1) }}</th>
                                        <th>{{ trans_choice('messages.Location', 1) }}</th>
                                        <th>@lang('messages.Status')</th>
                                        <th>@lang('messages.Action')</th>
                                    </tr>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                        <!-- //Covered Branches List -->
                    </div>
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
                    url: "{{ asset(get_theme_dir('plugins')) }}/datatables/{{ LaravelLocalization::getCurrentLocale() }}.json"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.branches.datatable') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
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
