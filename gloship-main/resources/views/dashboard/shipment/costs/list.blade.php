@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    {{-- Default Cost Settings --}}
    <form id="save_form" data-action="{{ route('dashboard.shipments.cost.set') }}" method="post">
        @csrf
        @method('POST')
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bolder"> @lang('messages.Default_Shipping_Cost') </h4>
            </div>
            <div class="card-body row">
                <div class="col-md-6 mb-1">
                    <div class="alert alert-light-success" role="alert">
                        @lang('messages.Enter_Default_Shipping_Cost_Msg')
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <span class="input-group-text">@lang('messages.Amount')</span>
                                @php
                                    $defualt_cost = get_money(get_config('default_shipping_cost'), get_config('default_shipping_cost_currency'), 'input', 'localize');
                                @endphp

                                <input type="number" min="0.01" step="any" name="default_shipping_cost"
                                    class="form-control"
                                    value="{{ old('default_shipping_cost', isset($defualt_cost) ? $defualt_cost : '') }}">
                                <span
                                    class="input-group-text">{{ get_money('0', get_config('default_shipping_cost_currency'), 'only_code', 'localize') }}</span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-success" id="">@lang('messages.Save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- // Default Cost Settings --}}

    {{-- Shipping Cost List --}}
    <div class="card">
        <div class="card-header">
            <h4 class="fw-bolder"> @lang('messages.Shipping_Cost') </h4>
            <div class="float-right">
                <a class="btn btn-primary m-1" href="{{ route('dashboard.shipments.cost.add') }}">
                    <ion-icon name="add-outline"></ion-icon> @lang('messages.Add') @lang('messages.Shipping_Cost')
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive covered areas-list">
                <table class="table list-table table-nowrap align-middle table-borderless"
                    xclass="table project-table table-centered table-nowrap" id="table1">
                    <thead>
                        <tr>
                        <tr class="text-uppercase">
                            <th>#</th>
                            <th>@lang('messages.Origin')</th>
                            <th>@lang('messages.Destination')</th>
                            <th>@lang('messages.Weight')</th>
                            <th>@lang('messages.Amount')</th>
                            <th>@lang('messages.Status')</th>
                            <th>@lang('messages.Action')</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <!--  //.card -->
    {{-- // Shipping Cost List --}}
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
                ajax: "{{ route('dashboard.cost.shipments.datatable') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'origin_country',
                        name: 'origin_country'
                    },
                    {
                        data: 'destination_country',
                        name: 'destination_country'
                    },
                    {
                        data: 'weight_to',
                        name: 'weight_to'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
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

    <script>
        $(document).ready(function() {

            //start: save data script
            $('#save_form').submit(function(e) {
                e.preventDefault();

                $form = $(this);
                //show some response on the button
                $('button[type="submit"]', $form).each(function() {
                    $btn = $(this);
                    $btn.prop('type', 'button');
                    $btn.prop('orig_label', $btn.text());
                    $btn.prop('disabled', true);
                    $btn.html(
                        ' <span class="spinner-grow spinner-grow-md mr-05" role="status" aria-hidden="true"></span>'
                    );
                });

                var cost = $('input[name="default_shipping_cost"]').val();
                //validate input field
                if (cost != '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.shipments.cost.set') }}",
                        data: $form.serialize(),
                        success: save_data,
                        dataType: 'json',
                        error: function() {
                            Toastify({
                                text: "{{ __('messages.Unable_To_Process') }}",
                                duration: 10000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "red",
                            }).showToast();
                            //reverse the response on the button
                            $('button[type="button"]', $form).each(function() {
                                $btn = $(this);
                                label = $btn.prop('orig_label');
                                if (label) {
                                    $btn.prop('type', 'submit');
                                    $btn.text(label);
                                    $btn.prop('orig_label', '');
                                    $btn.prop('disabled', false);
                                }
                            });
                        }
                    });
                } else {
                    //some required fields are empty 
                    Toastify({
                        text: "{{ __('messages.Fill_Required_Field_First') }}",
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                    //reverse the response on the button
                    $('button[type="button"]', $form).each(function() {
                        $btn = $(this);
                        label = $btn.prop('orig_label');
                        if (label) {
                            $btn.prop('type', 'submit');
                            $btn.text(label);
                            $btn.prop('orig_label', '');
                            $btn.prop('disabled', false);
                        }
                    });
                }
            });
            //end: save data script
        });
    </script>
@endpush
