@php
    if ($type == 'currency') {
        $countries = DB::table('countries')
            ->select('id', 'name', 'iso2')
            ->where('status', 1)
            ->get();
    }
    if ($type == 'rates') {
        $currencies = DB::table('currencies')
            ->select('code', 'name')
            ->distinct('name', 'code')
            ->where('status', 1)
            ->get();
    }
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="card" style="float: none; max-width: 700px; margin: auto">
        <div class="card-header">
            <h3 class="card-title">
                {{ $page_title }}
            </h3>

        </div>
        <hr class="divider">

        <form id="form_add" data-action="{{ route('dashboard.currencies.create', ['type' => $type]) }}" method="post">
            @csrf
            @method('POST')
            <div class="card-body">
                @if ($type == 'currency')
                    <div class="form-group mb-3">
                        <label class="required">{{ trans_choice('messages.Name', 1) }}</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="required">{{ trans_choice('messages.Code', 1) }}</label>
                        <input type="text" class="form-control" name="code" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="required">{{ trans_choice('messages.Symbol', 1) }}</label>
                        <input type="text" class="form-control" name="symbol" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="required">{{ trans_choice('messages.Country', 1) }}</label>
                        <select name="country" class="form-select form-search" required>
                            <option value="">@lang('messages.Select')</option>
                            @foreach ($countries as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if ($type == 'rates')
                    <div class="form-group">
                        <div class="col-md-12x">
                            <label>{{ trans_choice('messages.Currency', 1) }}</label>
                            <select name="currency" class="form-select form-search" required>
                                @foreach ($currencies as $item)
                                    <option value="{{ $item->code }}">
                                        {{ $item->code }} - {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('messages.Exchange_Rate_Usd')</label>
                        <input type="number" step="0.01" min="0" name="exchange_rate" class="form-control"
                            required>
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label for="native" class="form-label">@lang('messages.Status')</label>
                    <select name="status" class="form-select">
                        <option value="1">{{ get_status('', '1') }}</option>
                        <option value="2">{{ get_status('', '2') }}</option>
                    </select>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ url()->previous() }}" class="btn btn-light btn-active-light-primary me-2">@lang('messages.Back')</a>

                <button type="submit" class="btn btn-success ml-1">
                    <span class="add">@lang('messages.Add')</span>
                </button>
            </div>
        </form>

    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            //start: create data script
            $('#form_add').submit(function(e) {
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

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.currencies.create', ['type' => $type]) }}",
                    data: $form.serialize(),
                    success: create_data,
                    dataType: 'json',
                    error: error_data
                });

            });
            //end: create  data script
        });
    </script>
@endpush
