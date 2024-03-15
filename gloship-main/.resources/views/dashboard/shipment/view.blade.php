{{-- //Tracking Statuses
    '0' => 'Pending',
    '1' => 'Created',
    '2' => 'Pending Pickup Confirmation',
    '3' => 'Ready for shipment',
    '4' => 'Shipped',
    '5' => 'Arrives at',
    '6' => 'Custom Clearing',
    '7' => 'Ready for Pickup',
    '8' => 'Out for Delievering',
    '9' => 'Failed Delivery Attempts',
    '10' => 'Canceled',
    '11' => 'Shipping On-Hold',
    '12' => 'Returned',
    '13' => 'Delivered',
    '14' => 'Rejected'
  --}}
@php
    
    if (isset($shipment)) {
        //fetch shipment logs
        $logs = App\Models\ShipmentLog::where('shipment_id', $shipment->code)
            ->orderBy('id', 'asc')
            ->get();
    
        //fetch packages
    
        $packages = App\Models\Packages::where('shipment_id', $shipment->code)
            ->orderBy('id', 'asc')
            ->get();
    
        // shipping service
        $provider = App\Models\ShipmentProviders::where('shipment_id', $shipment->code)->first();
    }
    
    $user_lang = LaravelLocalization::getCurrentLocale();
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    {{-- .s-view --}}
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="alert alert-{{ get_status_color($shipment->status, 'shipments') }} alert-dismissible fade show text-center" role="alert">
                {{ get_status('shipment-notes', $shipment->status) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="s-view mb-5 mb-xl-10">
        <div class="card">
            <div class="card-header">
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">
                        {{ trans_choice('messages.Shipment', 1) }} : {{ $shipment->code }}
                        <small>
                            <span class="text-muted">@lang('messages.By')</span>

                            <a href="{{ route('dashboard.users.view', ['id' => $shipment->owner_id]) }}">
                                <span
                                    class='btn btn-sm btn-secondary m-1'>{{ get_user('username', $shipment->owner_id) }}</span>
                            </a>
                        </small>
                    </h3>
                </div>

                {{-- Quick Actions Tools --}}
                <div class="card-tool mt-2">
                    @can('do_staff')
                        {{-- action: Approve Shipment --}}
                        @if ($shipment->status == 0)
                            <a class="btn btn-sm btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#approve-{{ $shipment->id }}" href="#"><i class="fa fa-check"></i>
                                @lang('messages.Approve')
                            </a>
                            <a class="btn btn-sm btn-danger m-1" data-bs-toggle="modal"
                                data-bs-target="#reject-{{ $shipment->id }}" href="#"><i class="fa fa-times"></i>
                                @lang('messages.Reject')
                            </a>
                        @endif
                    @endcan
                    @if ($shipment->payment_status == 0)
                        {{-- action: Pay Invoice --}}
                        <a class="btn btn-sm btn-warning m-1"
                            href="{{ route('dashboard.shipments.invoice.pay', ['id' => $shipment->invoice_id]) }}"><i
                                class="fa fa-dollar-sign"></i>
                            @lang('messages.Pay_Now')
                        </a>
                        @can('do_staff')
                            <a class="btn btn-sm btn-warning m-1" data-bs-toggle="modal"
                                data-bs-target="#paid-{{ $shipment->id }}" href="#"><i class="fa fa-check"></i>
                                @lang('messages.Mark_Paid')
                            </a>
                        @endcan
                    @endif
                    @if ($shipment->status != 0)
                        {{-- action: Track --}}
                        <a target="_blank" class="btn btn-sm btn-outline-warning m-1"
                            href="{{ route('tracking', ['code' => $shipment->code]) }}"><i class="fa fa-arrow-right"></i>
                            @lang('messages.Track')
                        </a>
                    @endif
                    @can('do_staff')
                        {{-- action: Edit --}}
                        <a class="btn btn-sm btn-outline-primary m-1"
                            href="{{ route('dashboard.shipments.edit', ['id' => $shipment->id]) }}"><i class="fa fa-edit"></i>
                            @lang('messages.Edit')
                        </a>
                    @endcan

                    @if ($shipment->disabled == '0')
                        @can('do_moderator')
                            {{-- action: Disable Edit --}}
                            <a class="btn btn-sm btn-outline-primary m-1"
                                href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'disable']) }}"><i
                                    class="fa fa-minus"></i>
                                @lang('messages.Disable_Edit')
                            </a>
                        @endcan
                    @elseif($shipment->disabled == '1')
                        @can('do_moderator')
                            {{-- action: Enable Edit --}}
                            <a class="btn btn-sm btn-outline-primary m-1"
                                href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'enable']) }}"><i
                                    class="fa fa-minus"></i>
                                @lang('messages.Enable_Edit')
                            </a>
                        @endcan
                    @endif

                    {{-- action: Print --}}
                    <a target="_blank" class="btn btn-sm btn-outline-success m-1"
                        href="{{ route('dashboard.shipments.invoice', ['id' => $shipment->invoice_id]) }}"><i
                            class="fa fa-print"></i> @lang('messages.Print_Invoice')
                    </a>
                    <a target="_blank" class="btn btn-sm btn-outline-success m-1"
                        href="{{ route('dashboard.shipments.invoice.label', ['id' => $shipment->invoice_id]) }}"><i
                            class="fa fa-print"></i> @lang('messages.Print_Label')
                    </a>

                    @if ($shipment->status < 3)
                        {{-- action: mark as shipped --}}
                        @can('do_agent')
                            <a class="btn btn-sm btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#ready-for-shipment-{{ $shipment->id }}" href="#"><i
                                    class="fa fa-check"></i>
                                @lang('messages.Mark_Ready_For_Shipment')
                            </a>
                        @endcan
                    @endif

                    @if ($shipment->status < 4)
                        {{-- action: mark as shipped --}}
                        @can('do_agent')
                            <a class="btn btn-sm btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#shipped-{{ $shipment->id }}" href="#"><i class="fa fa-check"></i>
                                @lang('messages.Mark_Shipped')
                            </a>
                        @endcan
                    @endif

                    @if ($shipment->status < 8)
                        {{-- action: mark as out for delivery --}}
                        @can('do_agent')
                            <a class="btn btn-sm btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#out-for-delivery-{{ $shipment->id }}" href="#"><i
                                    class="fa fa-check"></i>
                                @lang('messages.Mark_Out_For_Delivery')
                            </a>
                        @endcan
                    @endif

                    @if ($shipment->status < 10)
                        {{-- action: mark as delivered --}}
                        @can('do_agent')
                            <a class="btn btn-sm btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#delivered-{{ $shipment->id }}" href="#"><i class="fa fa-check"></i>
                                @lang('messages.Mark_Delivered')
                            </a>
                        @endcan
                    @endif

                    @can('do_moderator')
                        {{-- action: Cancel --}}
                        <a class="btn btn-sm btn-outline-danger m-1" data-bs-toggle="modal"
                            data-bs-target="#cancel-{{ $shipment->id }}" href="#">
                            <i class="fa fa-times"></i> @lang('messages.Cancel_Shipment')
                        </a>
                        {{-- action: Delete --}}
                        <a class="btn btn-sm btn-outline-danger m-1" data-bs-toggle="modal"
                            data-bs-target="#delete-{{ $shipment->id }}" href="#">
                            <i class="fa fa-trash"></i> @lang('messages.Delete')
                        </a>
                    @endcan
                </div>
                {{-- // Quick Actions Tools --}}

            </div>
        </div>

        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="float-left"><b
                                class="text-success text-uppercase">{{ trans_choice('messages.Invoice', 1) }}</b>
                            <span>#{{ $shipment->invoice_id }}</span>
                        </h3>
                    </div>
                </div>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Collection_Type')</strong></h6>
                            <p class="text-muted">
                                {{ $shipment->collection_type == '1' ? __('messages.Drop_off_at_Branch') : __('messages.Home_Pick_Up') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Delivery_Type')</strong></h6>
                            <p class="text-muted">
                                {{ $shipment->delivery_type == '1' ? __('messages.Pick_Up_at_Branch') : __('messages.Home_Delivery') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Shipment_Status')</strong></h6>
                            <p class="text-muted">{{ get_status('shipments', $shipment->status) }}</p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Invoice_Status')</strong></h6>
                            <p class="text-muted">
                                {{ $shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid') }}</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Payment_Type')</strong></h6>
                            <p class="text-muted">
                                {{ $shipment->payment_type == '1' ? __('messages.PrePaid') : __('messages.PostPaid') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="float-left">
                            <h6><strong>{{ trans_choice('messages.Payment_Method', 1) }}</strong></h6>
                            <p class="text-muted">
                                {{ __('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name')) }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Sending_Branch')</strong></h6>
                            @if ($shipment->from_branch == '')
                                @can('do_staff')
                                    {{-- action: Assign --}}
                                    - <a
                                        href="{{ url('dashboard/shipments/edit/' . $shipment->id . '#from_branch') }}">@lang('messages.Assign_Branch')</a>
                                @endcan
                            @else
                                {{ get_data_db('branches', 'id', $shipment->from_branch, 'name') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            @if ($shipment->delivery_type == '1')
                                <h6><strong>@lang('messages.Receiving_Branch')</strong></h6>
                                <p class="text-muted">
                                    @if ($shipment->to_branch == '')
                                        @can('do_staff')
                                            <a
                                                href="{{ url('dashboard/shipments/edit/' . $shipment->id . '#to_branch') }}">@lang('messages.Assign_Branch')</a>
                                        @endcan
                                    @else
                                        {{ get_data_db('branches', 'id', $shipment->to_branch, 'name') }}
                                    @endif

                                </p>
                            @else
                                <h6><strong>@lang('messages.Destination')</strong></h6>
                                <p class="text-muted">
                                    {{ $shipment->receiver_address }},
                                    {{ get_name($shipment->to_area, 'areas') }},
                                    {{ get_name($shipment->receiver_city, 'cities') }},
                                    <br>
                                    {{ get_name($shipment->receiver_state, 'states') }},
                                    {{ get_name($shipment->receiver_country, 'countries') }}
                                </p>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Origin')</strong>
                            </h6>
                            <p class="text-muted">
                                {{ get_dataBy_id($shipment->sender_state, 'states', 'name') . '-' . get_dataBy_id($shipment->sender_country, 'countries', 'name') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Destination')</strong>
                            </h6>
                            <p class="text-muted">
                                {{ get_dataBy_id($shipment->receiver_state, 'states', 'name') . '-' . get_dataBy_id($shipment->receiver_country, 'countries', 'name') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Shipping_Date')</strong>
                            </h6>
                            <p class="text-muted">
                                @if ($shipment->shipped_date)
                                    {{ \Carbon\Carbon::parse($shipment->shipped_date)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong>@lang('messages.Delivery_Date') (<small class="text-muted">@lang('messages.Estimated')</small>)</strong>
                            </h6>
                            <p class="text-muted">
                                @if ($shipment->delivery_date)
                                    {{ \Carbon\Carbon::parse($shipment->delivery_date)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d') }}
                                @else
                                    -
                                @endif

                            </p>
                        </div>
                    </div>
                    @can('do_agent')
                        <div class="col-md-4 col-6">
                            <div class="float-left">
                                <h6><strong>{{ trans_choice('messages.Delivery_Agent', 1) }}</strong></h6>
                                <p class="text-muted">
                                    @if ($shipment->delivery_agent)
                                        <a href="{{ route('dashboard.users.view', ['id' => $shipment->delivery_agent]) }}">
                                            <span> {{ get_user('firstname', $shipment->delivery_agent) }}
                                                {{ get_user('lastname', $shipment->delivery_agent) }} -
                                                {{ get_user('username', $shipment->delivery_agent) }}</span>
                                        </a>
                                    @else
                                        <a href="{{ route('dashboard.shipments.agent.list', ['id' => $shipment->id]) }}">
                                            <span>@lang('messages.Assign_Agent')</span>
                                        </a>
                                    @endif


                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="float-left">
                                <h6><strong>@lang('messages.Submitted')</strong></h6>
                                <p class="text-muted">
                                    {{ \Carbon\Carbon::parse($shipment->created_at)->setTimezone(\Helpers::getUserTimeZone()) }}
                                    @lang('messages.By') {{ get_user('username', $shipment->created_by) }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="float-left">
                                <h6><strong>@lang('messages.Last_Updated_On')</strong></h6>
                                <p class="text-muted">
                                    {{ \Carbon\Carbon::parse($shipment->updated_at)->setTimezone(\Helpers::getUserTimeZone())->diffForHumans() }}
                                    @lang('messages.By') {{ get_user('username', $shipment->last_updated_by) }}
                                </p>
                            </div>
                        </div>
                    @endcan

                </div>
            </div>
        </div>

        {{-- Sender Info --}}
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <h3 class="col-md-12 text-left text-uppercase"><b class="text-success">@lang('messages.Sender_Info')</b></h3>
                    <hr>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Name') }}</strong></h6>
                            <p class="text-muted">{{ $shipment->sender_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Phone') }}</strong></h6>
                            <p class="text-muted">{{ $shipment->sender_phone }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Email') }}</strong></h6>
                            <p class="text-muted">{{ $shipment->sender_email }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.Address', 1) }}</strong></h6>
                            <p class="text-muted">{{ $shipment->sender_address }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.Area', 1) }}</strong></h6>
                            <p class="text-muted">{{ get_name($shipment->from_area, 'areas') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.City', 1) }}</strong></h6>
                            <p class="text-muted">{{ get_name($shipment->sender_city, 'cities') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.State', 1) }}</strong></h6>
                            <p class="text-muted">{{ get_name($shipment->sender_state, 'states') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.Country', 1) }}</strong></h6>
                            <p class="text-muted">{{ country_name($shipment->sender_country) }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Postal') }}</strong></h6>
                            <p class="text-muted">{{ $shipment->postal_sender }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Receiver Info --}}
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <h3 class="col-md-12 text-left text-uppercase"><b class="text-success">@lang('messages.Receiver_Info')</b></h3>
                    <hr>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Name') }}</strong></h6>
                            <p class="text-muted">{{ $shipment->receiver_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Phone') }}</strong></h6>
                            <p class="text-muted">{{ $shipment->receiver_phone }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Email') }}</strong></h6>
                            <p class="text-muted">{{ $shipment->receiver_email }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.Address', 1) }}</strong></h6>
                            <p class="text-muted">{{ $shipment->receiver_address }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.Area', 1) }}</strong></h6>
                            <p class="text-muted">{{ get_name($shipment->to_area, 'areas') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.City', 1) }}</strong></h6>
                            <p class="text-muted">{{ get_name($shipment->receiver_city, 'cities') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.State', 1) }}</strong></h6>
                            <p class="text-muted">{{ get_name($shipment->receiver_state, 'states') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.Country', 1) }}</strong></h6>
                            <p class="text-muted">{{ country_name($shipment->receiver_country) }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Postal') }}</strong></h6>
                            <p class="text-muted">{{ $shipment->postal_receiver }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipment Packages --}}
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-md-12 text-left text-uppercase">
                        <b class="text-success">{{ trans_choice('messages.Package', 2) }}
                            ({{ App\Models\Packages::where('shipment_id', $shipment->code)->count() }})
                        </b>
                    </h4>
                    <hr>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th style="width: 50%" class="pl-0 font-weight-bold text-muted text-uppercase">
                                            @lang('messages.Description')</th>
                                        <th class="text-right  text-muted text-uppercase">@lang('messages.Length_CM')</th>
                                        <th class="text-right  text-muted text-uppercase">@lang('messages.Width_CM')</th>
                                        <th class="text-right  text-muted text-uppercase">@lang('messages.Height_CM')</th>

                                        <th class="text-right  text-muted text-uppercase">@lang('messages.Weight_Kg')</th>
                                        <th class="pr-0 text-right  text-muted text-uppercase">@lang('messages.Quantity')</th>
                                        {{-- <th class="pr-0 text-right  text-muted text-uppercase">@lang('messages.Unit_Price')</th>
                                        <th class="pr-0 text-right  text-muted text-uppercase">@lang('messages.Total')</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $package)
                                        <tr class="font-weight-boldest">
                                            <td style="width: 50%"><strong> {{ $package->description }}</strong></td>
                                            <td> {{ $package->length }}</td>
                                            <td> {{ $package->width }}</td>
                                            <td> {{ $package->height }}</td>
                                            <td> {{ $package->weight }}</td>
                                            <td> {{ $package->qty }}</td>
                                            {{-- <td> {{ get_money($package->unit_price, $shipment->currency, 'symbol', 'localize') }}
                                            </td>
                                            <td> {{ get_money($package->price, $shipment->currency, 'symbol', 'localize') }}
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="hm-p table-bordered" style="width: 100%; margin-top: 30px">
                                <tr>
                                    <th style="vertical-align: top;padding: 10px;">{{ __('messages.Subtotal') }}</th>
                                    <td style="vertical-align: top;padding: 10px;">
                                        <b>
                                            {{ get_money($shipment->subtotal, $shipment->currency, 'full', 'localize') }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: top;padding: 10px;">{{ __('messages.Tax') }}</th>
                                    <td style="vertical-align: top;padding: 10px;">
                                        <b>+{{ get_money($shipment->tax, $shipment->currency, 'full', 'localize') }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: top;padding: 10px;">{{ __('messages.Discount') }}</th>
                                    <td style="vertical-align: top;padding: 10px;">
                                        <b>-{{ get_money($shipment->discount, $shipment->currency, 'full', 'localize') }}</b>
                                    </td>
                                </tr>

                                <tr>
                                    <th style="vertical-align: top; padding: 10px;">{{ __('messages.Total') }}</th>
                                    <td style="vertical-align: top; padding: 10px;">
                                        <b>{{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}</b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipment Provider --}}
        @can('do_staff')
            @if ($provider)
                <div class="card mt-3 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="col-md-12 text-left text-uppercase">
                                <b class="text-success">{{ trans_choice('messages.Shipping_Provider', 1) }} </b>
                            </h4>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    @php
                                        
                                    @endphp
                                    <table class="hm-p table" style="width: 100%; margin-top: 30px">
                                        <tr>
                                            <th style="vertical-align: top;padding: 10px;">{{ __('messages.Provider') }}</th>
                                            <td style="vertical-align: top;padding: 10px;">
                                                @if ($provider->provider == 1)
                                                    {{ get_content_locale(get_config('site_name'), LaravelLocalization::getCurrentLocale()) }}
                                                @endif
                                                @if ($provider->provider == 2)
                                                    Eurosender
                                                @endif
                                                @if ($provider->provider == 3)
                                                    Shippo
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th style="vertical-align: top;padding: 10px;">
                                                {{ trans_choice('messages.Service', 1) }}</th>
                                            <td style="vertical-align: top;padding: 10px;">
                                                <b>This shipment is handle by {{ $provider->name }} -
                                                    {{ $provider->service_name }}</b>
                                            </td>
                                        </tr>

                                        @if ($provider->provider == 2 || $provider->provider == 3)
                                            <tr>
                                                <th style="vertical-align: top;padding: 10px;">
                                                    {{ trans_choice('messages.Tracking_Number', 1) }}</th>
                                                <td style="vertical-align: top;padding: 10px;">

                                                    @if ($provider->tracking_number != '')
                                                        {{ $provider->tracking_number }}
                                                    @else
                                                        @lang('messages.Approve_Shipment_First')
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;padding: 10px;">
                                                    {{ trans_choice('messages.Status', 1) }}</th>
                                                <td style="vertical-align: top;padding: 10px;">

                                                    @if ($provider->tracking_status != '')
                                                        {{ $provider->tracking_status }}
                                                        @if ($provider->tracking_url_provider != '')
                                                        <a href="{{ $provider->tracking_url_provider }}" target="_blank">@lang('messages.Track')</a>
                                                    
                                                    @endif
                                                    @else
                                                        @lang('messages.Approve_Shipment_First')
                                                    @endif
                                                </td>
                                            </tr>
                                        
                                        
                                            <tr>
                                                <th style="vertical-align: top;padding: 10px;">
                                                    {{ trans_choice('messages.Label', 1) }}</th>
                                                <td style="vertical-align: top;padding: 10px;">

                                                    @if ($provider->label != '')
                                                        <a href="{{ $provider->label }}" target="_blank">@lang('messages.View')</a>
                                                    @else
                                                        @lang('messages.Approve_Shipment_First')
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @endcan

        {{-- Shipment Log --}}
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-md-12 text-left text-uppercase"><b class="text-success">@lang('messages.Shipment_Logs')</b></h4>
                    <hr>
                    <div class="col-md-12">

                        <table class="table table-condensed">
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->diffForHumans() }}</td>
                                    <td>{{ get_status('shipment-notes', $log->note) }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- // .s-view --}}

    {{-- modal --}}
    @include(get_theme_dir('shipment.modal', 'dashboard'), [
        'id' => $shipment->id,
        'code' => $shipment->code,
        'shipment' => $shipment,
        'logs' => $logs,
        'packages' => $packages,
    ])
    {{-- //modal --}}
@endsection
