@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    {{-- .card --}}
    <div class="card">
        <div class="card-header">
        <h4 class="fw-bolder">{{ trans_choice('messages.Notification', 2) }}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive addresses-list">
                <table class="table list-tablevalign-middle table-borderless table-collapsed"
                    id="table1">
                    <thead>
                        <tr class="text-uppercase">
                            <th>@lang('messages.From')</th>
                            <th width="50%">{{ trans_choice('messages.Message', 1) }}</th>
                            <th>@lang('messages.Date')</th>
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
                ajax: "{{ route('dashboard.users.notification.datatable') }}",
                columns: [{
                        data: 'sender',
                        name: 'message_type'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
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
