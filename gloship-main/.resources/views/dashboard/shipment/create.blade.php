@php
    $form_add = '';
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="mb-3">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{  __('messages.Create_New_Shipment') }}</h3>
            </div>
        </div>
    </div>

        <form action="{{ route('dashboard.shipments.getcost') }}" id="shipment_create_formxx" class="form" method="post" enctype="multipart/form-data">
            @method('POST')
            @include(get_theme_dir('shipment.forms.create', 'dashboard'), [
                'FormType' => 'create',
                'FormAdd' => $form_add,
            ])

            <div class="card-footer d-flex justify-content-end px-9 py-6 mb-3">
                <a href="{{ route('dashboard.shipments')}}" class="btn btn-light btn-active-light-primary me-2">@lang('messages.Discard')</a>
                <button type="submit" class="btn btn-primary me-2">
                    @lang('messages.Proceed')
                    <i class="fa fa-chevron-circle-right"></i>
                </button>                
            </div>

        </form>

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
    @include(get_theme_dir('shipment.scripts', 'dashboard'), [
    ])
@endpush

