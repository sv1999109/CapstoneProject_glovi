@php
    $payment_method = DB::table('payment_methods')
        ->orderBy('id', 'asc')
        ->get();
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="card-header mb-3">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ trans_choice('messages.Payment_Method', 2) }}</h3>
        </div>
    </div>
    {{-- payment method section --}}
    @foreach ($payment_method as $pay)
        @php
            $payment_settings = json_decode(
                DB::table('payment_methods')
                    ->where('id', $pay->id)
                    ->value('fields'),
                true,
            );
        @endphp
        <div class="card">
            <form id="form_{{ $pay->name }}" data-action="{{ route('dashboard.payment.update', ['id' => $pay->id]) }}"
                method="POST">
                @csrf
                @method('POST')
                <input name="type" type="hidden" value="{{ strtolower($pay->name) }}">
                <div class="card-body ">
                    <div class="form-group row">
                        <label class="col-sm-4"></label>
                        <div class="col-sm-8">
                            <div class="form-check form-switch">
                                <input name="status" class="form-check-input" type="checkbox" value="1"
                                    id="section_{{ $pay->name }}" @if ($pay->status == '1') checked @endif>
                                <label class="form-check-label" for="section_{{ $pay->name }}">
                                    {{ __('messages.' . $pay->name) }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="section_{{ $pay->name }}">
                        <div class="form-group row">
                            <label class="col-sm-4 text-left control-label col-form-label">{{ trans_choice('messages.Currency', 1) }}</label>
                            <div class="col-sm-8">
                                <select name="currency" id="currency" class="form-select">
                                    @foreach (DB::table('exchange_rates')->where('status', 1)->orderBy('id', 'asc')->get() as $item)
                                        <option value="{{ $item->code }}"
                                            @if ($item->code == $pay->currency) selected @endif>{{ $item->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 text-left control-label col-form-label">{{ trans_choice('messages.Mode', 1) }}</label>
                            <div class="col-sm-8">
                                <select name="test_mode" id="test_mode" class="form-select">
                                   
                                <option value="true" @if ($pay->test_mode == 'true') selected @endif>{{ __('messages.Test') }}</option>
                                <option value="false" @if ($pay->test_mode == 'false') selected @endif>{{ __('messages.Live') }}</option>
                                </select>
                            </div>
                        </div>
                        @foreach ($payment_settings as $key => $item)
                            @if ($key != '')
                                @if ($key == '')
                                @else
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-4 text-left control-label col-form-label">{{ __('messages.' .$key) }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="{{ $key }}" class="form-control form-control-lg"
                                                id="{{ $key }}" value="{{ $item }}">
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                        {{-- Payment Instructions section --}}
                        <div class="form-group row">
                            <label
                                class="col-sm-4 text-left control-label col-form-label">@lang('messages.Payment_Instruction')</label>
                            <div class="col-sm-8">
                                {{-- translation tab --}}
                                <ul class="nav nav-tabs" id="notemyTab" role="tablist">

                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li class="nav-item" role="presentation">

                                            <button class="nav-link @if ($localeCode == LaravelLocalization::getCurrentLocale()) active @endif"
                                                id="{{ $pay->name }}-{{ $localeCode }}-tab-a" data-bs-toggle="tab"
                                                data-bs-target="#{{ $pay->name }}-{{ $localeCode }}-tab"
                                                type="button" role="tab"
                                                aria-controls="{{ $pay->name }}-{{ $localeCode }}-tab"
                                                aria-selected="true">{{ $properties['native'] }}</button>

                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content" id="notemyTab">
                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        @php
                                            $note_current = get_content_locale($pay->instruction, $localeCode);
                                        @endphp
                                        <div class="tab-pane fade  @if ($localeCode == LaravelLocalization::getCurrentLocale()) show active @endif"
                                            id="{{ $pay->name }}-{{ $localeCode }}-tab" role="tabpanel"
                                            aria-labelledby="{{ $pay->name }}-{{ $localeCode }}-tab" tabindex="0">

                                            <textarea id="note_{{ $pay->name }}" rows="5" placeholder="{{ __('Payment Instructions') }}"
                                                name="instruction[{{ $localeCode }}]" class="form-control">{{ $note_current }}</textarea>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- // Payment Instructions section --}}

                    </div>
                </div>
                {{-- Submit  --}}
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ url()->previous() }}"
                        class="btn btn-light btn-active-light-primary me-2">@lang('messages.Cancel')</a>
                    <button onsubmit="save_payment_data()" type="submit" class="btn btn-success"
                        id="btn_{{ $pay->name }}">@lang('messages.Save_Change')</button>
                </div>
            </form>
        </div>
    @endforeach
@endsection

@push('scripts')
    {{-- Payment button disable script --}}
    <script>
        $(document).ready(function() {

            @foreach ($payment_method as $pay)
                $("input[id='section_{{ $pay->name }}']").click(function() {
                    var EValue = $("input[id='section_{{ $pay->name }}']:checked").length > 0;
                    if (EValue) {
                        $('.section_{{ $pay->name }} input').attr('disabled', false);
                        $('.section_{{ $pay->name }} textarea').attr('disabled', false);
                        $('.section_{{ $pay->name }} select').attr('disabled', false);
                    } else {
                        $('.section_{{ $pay->name }} input').attr('disabled', true);
                        $('.section_{{ $pay->name }} textarea').attr('disabled', true);
                        $('.section_{{ $pay->name }} select').attr('disabled', true);
                    }
                });
            @endforeach

        });
    </script>
    {{--// Payment button disable script --}}

    <script>
        $(document).ready(function() {
            @foreach ($payment_method as $pay)
                $('#form_{{ $pay->name }}').submit(function(e) {
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
                        url: "{{ route('dashboard.payment.update', ['id' => $pay->id]) }}",
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
                });
            @endforeach
        });

    </script>
@endpush
