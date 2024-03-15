@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header mb-5x">
                    <div class="row align-items-center g-2">
                        <div class="col-lg-3 me-auto">
                            <h6 class="card-title mb-0">{{ __('messages.Shipment_List') }}</h6>
                        </div><!--end col-->
                        <div class="col-xl-3 col-md-3 col-md-auto">
                            
                                <form action="" method="get" class="float-rightx">
                                    <select class="form-control form-select" data-id="status" name="s" onchange="this.form.submit();">
                                        @php
                                            $statuses = array_flip(get_status('shipments', 'status', 'all'));
                                        @endphp
                                        <option value="">@lang('messages.All')</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ ($s == $status) ? 'selected' : '' }}>
                                                {{ get_status('shipments', $status) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            
                        </div><!--end col-->
                        {{-- <div class="col-md-auto">
                            <div class="hstack gap-2">
                                bbb
                            </div>
                        </div><!--end col--> --}}
                    </div><!--end row-->
                </div>
                <div class="card-body mt-3">
                    <div class="table-responsive list-shipment">
                        <table class="table" id="table1">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>@lang('messages.Tracking_Number')</th>
                                    <th>@lang('messages.Status')</th>
                                    <th>@lang('messages.Shipping_Cost')</th>
                                    @can('do_staff')
                                        <th>{{ trans_choice('messages.Customer', 1) }}</th>
                                    @endcan
                                    <th>@lang('messages.Sender')</th>
                                    <th>@lang('messages.Receiver')</th>
                                    <th>@lang('messages.Origin')</th>
                                    <th>@lang('messages.Destination')</th>
                                    <th>@lang('messages.Created')</th>
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
                ajax: "{{ route('dashboard.shipments.datatable', ['type' => 'all', 'id' => 'all', 's' => $s]) }}",
                columns: [{
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'shipping_cost',
                        name: 'shipping_cost'
                    },
                    @can('do_staff')
                    {
                        data: 'owner_id',
                        name: 'owner_id'
                    },
                    @endcan
                    {
                        data: 'sender_name',
                        name: 'sender_name'
                    },
                    {
                        data: 'receiver_name',
                        name: 'receiver_name'
                    },
                    {
                        data: 'sender_country',
                        name: 'sender_country'
                    },
                    {
                        data: 'receiver_country',
                        name: 'receiver_country'
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
