@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    {{-- .card --}}
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-grow-1">
                <h5 class="card-title mb-0"> @lang('messages.Address_Book')</h5>
            </div>
            <div class="flex-shrink-0">
                <div class="d-flex flex-wrap align-items-start gap-2">
                    <a class="btn btn-primary add-btn" href="{{ route('dashboard.address.add') }}">
                        <i class="bi bi-plus-circle align-baseline me-1"></i> @lang('messages.Add_New')
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive addresses-list">
                <table class="table list-table table-nowrap align-middle table-borderless table-collapsed table-nowrap"
                    id="table1">
                    <thead>
                        <tr class="text-uppercase">
                            <th>@lang('messages.Address_Type')</th>
                            <th width="50%">{{ trans_choice('messages.Address', 1) }}</th>
                            <th>@lang('messages.Created')</th>
                            <th>@lang('messages.Action')</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>{{-- /.card --}}
@endsection


@push('css')
    <style>
        table:not(.table-sm) thead th {
            border-bottom: none;
            background-color: #e9e9eb;
            color: #666;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .list-table {
            border-collapse: separate;
            border-spacing: 0 12px
        }

        .list-table tr {
            background-color: #fff
        }

        .table-nowrap td,
        .table-nowrap th {
            white-space: nowrap;
        }

        .table-borderless>:not(caption)>*>* {
            border-bottom-width: 0;
        }

        .table>:not(caption)>*>* {
            padding: 0.75rem 0.75rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }
    </style>

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
                ajax: "{{ route('dashboard.address.datatable', ['type' => 'all', 'id' => 'all']) }}",
                columns: [{
                        data: 'address_type',
                        name: 'address_type'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
