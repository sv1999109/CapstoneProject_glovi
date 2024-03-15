@php
    $currencies = DB::table('currencies')
        ->select('code', 'name')
        ->where('status', 1)
        ->distinct('name', 'code')
        ->get();
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('dashboard.currency.set') }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="form-body-section">
                        <div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="fw-bolder"> @lang('messages.Currency_Settings') </h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-3">{{ __('messages.Default_Currency') }}</label>
                                        <div class="col-sm-9">
                                            <select name="code"
                                                class="form-select form-search">
                                                @foreach ($currencies as $item)
                                                    <option value="{{ $item->code }}"
                                                        @if (get_config('currency_code') == $item->code) selected @endif>
                                                        {{ $item->name }}({{ $item->code }}) </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-3">{{ __('messages.Localize_Currency') }}</label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input name="currency_localize" class="form-check-input" type="checkbox" value="enabled"
                                                    id="currency_localize" @if (get_config('currency_localize') == 'enabled') checked @endif>
                                                <label class="form-check-label" for="currency_localize">@lang('messages.Currency_Base_User')</label>
                                            </div>
                                           
                                            @if ( !DB::table('exchange_rates')->where('code', get_config('currency_code'))->value('exchange_rate') > 0)
                                            <br>
                                            <div class="col-md-6 mb-1">
                                                <div class="alert alert-light-warning" role="alert">
                                                    @lang('messages.Wrong_Currency_Warning')
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-success" id="">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="currencies-tab" data-bs-toggle="tab" href="#tb1" role="tab"
                                    aria-controls="home" aria-selected="true">{{ trans_choice('messages.Currency', 2) }}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="exchange-tab" data-bs-toggle="tab" href="#tb2"
                                    role="tab" aria-controls="exchange" aria-selected="false"> @lang('messages.Exchange_Rate')</a>
                            </li>

                        </ul>

                        <div class="float-right">
                            <a class="btn btn-success m-1" href="{{ route('dashboard.currency.add', ['type' => 'currency']) }}">
                                <ion-icon name="add-outline"></ion-icon> @lang('messages.Add') {{ trans_choice('messages.Currency', 1) }}
                            </a>
                            <a class="btn btn-dark m-1" href="{{ route('dashboard.currency.add', ['type' => 'rates']) }}">
                                <ion-icon name="add-outline"></ion-icon> @lang('messages.Add') {{ trans_choice('messages.Exchange_Rate', 1) }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="table-responsive fade" role="tabpanel" aria-labelledby="exchange-tab"
                                id="tb1">
                                <table class="table table-centered table-nowrap" id="table1">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th>@lang('messages.ID')</th>
                                            <th>{{ trans_choice('messages.Country', 1) }}</th>
                                            <th>@lang('messages.Name')</th>
                                            <th>@lang('messages.Symbol')</th>
                                            <th>@lang('messages.Code')</th>
                                            <th>@lang('messages.Status')</th>
                                            <th>@lang('messages.Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="table-responsive fade show active" role="tabpanel" aria-labelledby="exchange-tab"
                                id="tb2">
                                <table class="table table-centered table-nowrap" id="table2">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th>@lang('messages.ID')</th>
                                            <th>{{ trans_choice('messages.Currency', 1) }}</th>
                                            <th>@lang('messages.Exchange_Rate_Usd')</th>
                                            <th>@lang('messages.Status')</th>
                                            <th>@lang('messages.Created')</th>
                                            <th>@lang('messages.Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset(get_theme_dir('plugins')) }}/datatables/dataTables.bootstrap5.min.css" rel="stylesheet">
    </head>
    <style>
        .fade:not(.show) {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset(get_theme_dir('plugins')) }}/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset(get_theme_dir('plugins')) }}/datatables/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('#table1').DataTable({
                language: {
                    url: "{{ asset(get_theme_dir('plugins')) }}/datatables/{{ LaravelLocalization::getCurrentLocale() }}.json"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.currencies.datatable') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'country_id',
                        name: 'country_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'symbol',
                        name: 'symbol'
                    },
                    {
                        data: 'code',
                        name: 'code'
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
            var table = $('#table2').DataTable({
                language: {
                    url: "{{ asset(get_theme_dir('plugins')) }}/datatables/{{ LaravelLocalization::getCurrentLocale() }}.json"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.currencies.datatable.rates') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'exchange_rate',
                        name: 'exchange_rate'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
