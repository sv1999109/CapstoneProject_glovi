@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    {{-- .card --}}
    <div class="card">
        <div class="card-header">
            <h6>{{ trans_choice('messages.Shipment', 1) }}: {{ ($shipment->code) }} </h6>
            <h6>{{ trans_choice('messages.Location', 1) }}: {{ country_name($shipment->receiver_country) }} </h6>
            <h6 class="fw-bolder"> @lang('messages.Agent_Available'): {{ \App\Models\User::whereRaw("country = '$shipment->receiver_country' AND role = 2 AND status = 1")->count() }} </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table list-table table-nowrap align-middle table-borderless table-collapsed table-nowrap"
                    id="table1">
                    <thead>
                        <tr class="text-uppercase">
                            <th>@lang('messages.ID')</th>
                            <th></th>
                            <th>{{ trans_choice('messages.Agent', 1) }}</th>
                            <th>{{ trans_choice('messages.Shipment', 1) }}</th>
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
                ajax: "{{ route('dashboard.shipments.agents.datatable', ['country' => $shipment->receiver_country, 'shipment' => $id]) }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'avatar',
                        name: 'avatar'
                    },
                    {
                        data: 'firstname',
                        name: 'firstname'
                    },
                    {
                        data: 'username',
                        name: 'username'
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
