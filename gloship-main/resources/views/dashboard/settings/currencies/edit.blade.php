@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="card small-card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $page_title }}
            </h3>

        </div>
        <hr class="divider">

        <form id="form_edit" data-action="{{ route('dashboard.currency.update', ['id' => $model->id, 'type' => $type]) }}"
            method="post">
            @csrf
            @method('POST')
            <div class="card-body">
                @if ($type == 'currency')
                    <div class="form-group">
                        <label class="required">{{ trans_choice('messages.Country', 1) }}</label>
                        <input type="text" class="form-control" value="{{ get_name($model->country_id, 'countries') }}"
                            disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label class="required">{{ trans_choice('messages.Name', 1) }}</label>
                        <input type="text" class="form-control" name="name" value="{{ $model->name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="required">{{ trans_choice('messages.Code', 1) }}</label>
                        <input type="text" class="form-control" name="code" value="{{ $model->code }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="required">{{ trans_choice('messages.Symbol', 1) }}</label>
                        <input type="text" class="form-control" name="symbol" value="{{ $model->symbol }}" required>
                    </div>
                @endif
                @if ($type == 'rates')
                    <div class="form-group mb-3">
                        <label class="required">{{ trans_choice('messages.Currency', 1) }}</label>
                        <input type="text" class="form-control" value="{{ $model->code }}" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label class="required">@lang('messages.Exchange_Rate_Usd')</label>
                        <input value="{{ $model->exchange_rate }}" type="number" step="0.01" min="0"
                            name="exchange_rate" class="form-control" required>
                    </div>
                @endif
                <div class="form-group mb-3">
                    <label for="native" class="form-label">@lang('messages.Status')</label>
                    <select name="status" class="form-select">
                        <option value="1" @if ($model->status == 1) selected @endif>{{ get_status('', '1') }}
                        </option>
                        <option value="2" @if ($model->status == 2) selected @endif>{{ get_status('', '2') }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ url()->previous() }}" class="btn btn-light btn-active-light-primary me-2">@lang('messages.Back')</a>

                <button type="submit" class="btn btn-success ml-1">
                    <span class="add">@lang('messages.Save_Change')</span>
                </button>
            </div>
        </form>

    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            //start: save script
            $('#form_edit').submit(function(e) {
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
                    url: "{{ route('dashboard.currency.update', ['type' => $type, 'id' => $model->id]) }}",
                    data: $form.serialize(),
                    success: save_data,
                    dataType: 'json',
                    error: error_data
                });

            });
            //end: save  data script
        });
    </script>
@endpush
