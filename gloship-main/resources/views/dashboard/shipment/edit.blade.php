@php
    // fetch active branches
    $branches = \App\Models\Branches::where('status', 1)
        ->orderBy('id', 'asc')
        ->get();
    
    //fetch shipment logs
    if (isset($shipment)) {
        $logs = App\Models\ShipmentLog::where('shipment_id', $shipment->code)
            ->orderBy('id', 'asc')
            ->get();
    }
    
    //fetch packages
    if (isset($shipment)) {
        $packages = App\Models\Packages::where('shipment_id', $shipment->code)
            ->orderBy('id', 'asc')
            ->get();
    }
    
    $user_lang = LaravelLocalization::getCurrentLocale();
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="mb-5 mb-xl-10">
        {{-- .card --}}
        <div class="card">
            <div class="card-header">

                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">{{ __('messages.Editing_Shipment') }} : {{ $shipment->code }}</h3>
                </div>

                {{-- Quick Actions Tools --}}
                <div class="card-tool mt-2">
                    @can('do_staff')
                        {{-- action: Approve Shipment --}}
                        @if ($shipment->status == 0)
                            {{-- <a class="btn btn-sm btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#approve-{{ $shipment->id }}" href="#"><i class="fa fa-check"></i>
                                @lang('messages.Approve')
                            </a>
                            <a class="btn btn-sm btn-danger m-1" data-bs-toggle="modal"
                                data-bs-target="#reject-{{ $shipment->id }}" href="#"><i class="fa fa-times"></i>
                                @lang('messages.Reject')
                            </a> --}}
                        @endif
                    @endcan
                    @if ($shipment->payment_status == 0)
                        {{-- action: Pay Invoice --}}
                        {{-- <a class="btn btn-sm btn-warning m-1"
                            href="{{ route('dashboard.shipments.invoice.pay', ['id' => $shipment->invoice_id]) }}"><i
                                class="fa fa-dollar-sign"></i>
                            @lang('messages.Pay_Now')
                        </a> --}}
                        {{-- @can('do_staff')
                            <a class="btn btn-sm btn-warning m-1" data-bs-toggle="modal"
                                data-bs-target="#paid-{{ $shipment->id }}" href="#"><i class="fa fa-check"></i>
                                @lang('messages.Mark_Paid')
                            </a>
                        @endcan --}}
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
                            href="{{ route('dashboard.shipments.view', ['id' => $shipment->code]) }}"><i class="fa fa-eye"></i>
                            @lang('messages.View')
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
        {{-- //.card --}}


        @can('do_staff')
            <div class="mt-1">

                {{-- Check if Shipment is Disabled --}}
                @if ($shipment->disabled == '1')
                    <div class="alert alert-danger text-center">
                        <strong>@lang('messages.Shipment_Is_Edit_Disabled') </strong>
                    </div>
                @else
                    <!-- Form -->
                    <form class="form" id="shipment_edit_form" method="post" enctype="multipart/form-data">
                        @method('PUT')

                        <div class="">
                            @include(get_theme_dir('shipment.forms.edit', 'dashboard'), [
                                'branches' => $branches,
                                'logs' => $logs,
                                'packages' => $packages,
                            ])
                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ url()->previous() }}" class="btn btn-light me-2">@lang('Cancel')</a>
                            <button id="save_shipment_btn" type="submit" class="btn btn-primary"
                                id="">@lang('messages.Save_Change')</button>
                        </div>

                    </form>
                    <!-- // Form -->
                @endif

                {{-- modal --}}
                @include(get_theme_dir('shipment.modal', 'dashboard'), [
                    'id' => $shipment->id,
                    'code' => $shipment->code,
                    'shipment' => $shipment,
                    'logs' => $logs,
                    'packages' => $packages,
                ])
                {{-- //modal --}}

            </div>
        @endcan

    </div>
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .fade:not(.show) {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    {{-- Add Javascript --}}
    @include(get_theme_dir('shipment.scripts', 'dashboard'), [])
@endpush
