@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-header">
                    
                    <h4 class="card-title text-uppercase">{{ trans_choice('messages.Invoice', 2) }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>@lang('#')</th>
                                    @can('do_staff')
                                        <th>{{ trans_choice('messages.Customer', 1) }}</th>
                                    @endcan
                                    <th>@lang('messages.Amount')</th>
                                    <th>@lang('messages.Status')</th>
                                    <th>@lang('messages.Tracking')</th>
                                    <th>@lang('messages.Date')</th>
                                    <th>@lang('messages.Action')</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset(get_theme_dir('plugins')) }}/datatables/dataTables.bootstrap5.min.css" rel="stylesheet">
    </head>
@endpush

@push('scripts')
    {{-- Datatable script --}}
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
                ajax: "{{ route('dashboard.shipments.invoices.datatable', ['type' => 'all', 'id' => 'all']) }}",
                columns: [{
                        data: 'invoice_id',
                        name: 'invoice_id'
                    },
                    @can('do_staff')
                        {
                            data: 'owner_id',
                            name: 'owner_id'
                        },
                    @endcan 
                    {
                        data: 'shipping_cost',
                        name: 'shipping_cost'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'code',
                        name: 'code'
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
