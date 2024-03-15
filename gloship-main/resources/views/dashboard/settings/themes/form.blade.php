@foreach ($item as $key2 => $options)
    <div class="card">
        <div class="card-body">
            @if ($key != '')
                <div class="accordion row" id="accordion{{ $key }}">
                    @foreach ($options as $key3 => $option_value)
                        <form id="form_{{ $key3 }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="col-md-12">
                                <div class="accordion-item">

                                    <h2 class="accordion-header s-title text-primary" id="ac1-{{ $key3 }}">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#{{ $key3 }}-ac1-collapsed" aria-expanded="true"
                                            aria-controls="ac1-{{ $key3 }}">
                                            {{ trans_choice('messages.' . $option_value, 1) }}
                                        </button>

                                    </h2>
                                    <div id="{{ $key3 }}-ac1-collapsed" class="accordion-collapse collapse"
                                        aria-labelledby="ac1-{{ $key }}"
                                        data-bs-parent="#accordion{{ $key }}">
                                        <div class="accordion-body p-3 ">

                                            <div class="form-check form-switch">
                                                <input name="display" value="enabled" class="form-check-input"
                                                    type="checkbox" id="c-{{ $key3 }}"
                                                    @if (get_theme_config($key3) == 'enabled') checked @endif>
                                                <label class="form-check-label"
                                                    for="c-{{ $key3 }}">@lang('messages.Enable')</label>
                                            </div>
                                            <div class="form-group mt-2">

                                                @foreach (get_contents_admin('get', $key3) as $skey)
                                                    @if ($key == 'homepage')
                                                        <div class="tab-content" id="{{ $skey->config_key }}_Tab">


                                                            <ul class="nav nav-tabs mt-3"
                                                                id="{{ $skey->config_key }}_Tablist" role="tablist">

                                                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                                    <li class="nav-item" role="presentation">

                                                                        <button
                                                                            class="nav-link @if ($localeCode == LaravelLocalization::getCurrentLocale()) active @endif"
                                                                            id="{{ $skey->config_key }}-{{ $localeCode }}-tab-a"
                                                                            data-bs-toggle="tab"
                                                                            data-bs-target="#{{ $skey->config_key }}-{{ $localeCode }}-tab"
                                                                            type="button" role="tab"
                                                                            aria-controls="{{ $localeCode }}-tab"
                                                                            aria-selected="true">{{ $properties['native'] }}</button>

                                                                    </li>
                                                                @endforeach
                                                            </ul>


                                                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                                @php
                                                                    $note_current = get_content_locale(get_contents_admin($skey->config_key, '', 'all'), $localeCode);
                                                                @endphp
                                                                <div class="tab-pane fade  @if ($localeCode == LaravelLocalization::getCurrentLocale()) show active @endif"
                                                                    id="{{ $skey->config_key }}-{{ $localeCode }}-tab"
                                                                    role="tabpanel"
                                                                    aria-labelledby="{{ $localeCode }}-tab"
                                                                    tabindex="0">


                                                                    <textarea rows="3" name="{{ $skey->config_key }}[{{ $localeCode }}]"
                                                                        class="form-control @error("$skey->config_key[$localeCode]") is-invalid @enderror">{{ old("note[$localeCode]", $note_current) }}</textarea>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    @if ($key == 'styling')
                                                        <input size="10" class="form-control form-control-lg"
                                                            type="color" name="{{ $skey->config_key }}"
                                                            value="{{ get_contents_admin($skey->config_key, '', 'all') }}">
                                                    @endif

                                                    @if ($key == 'logo')
                                                        <div class="mb-3" id="image_preview_{{ $key3 }}">
                                                            @if (get_theme_config($key3) == 'enabled')
                                                                <img src="{{ asset(get_contents_admin($skey->config_key, '', 'all')) }}"
                                                                    style="width: 200px; height: auto;" alt="Logo"
                                                                    class="">
                                                            @endif
                                                        </div>

                                                        <input size="10" class="form-control" type="file"
                                                            name="{{ $skey->config_key }}" id="logo_{{ $key3 }}" accept="image/*">

                                                        <div style="display: none"
                                                            class="progress progress-md  mb-4 up-progress"
                                                            id="progress_div_{{ $key3 }}">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                id='bar_{{ $key3 }}' aria-valuemin="0" aria-valuemax="100">
                                                                <div class='up-percent' id='percent_{{ $key3 }}'>0%</div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($key == 'custom')
                                                    <textarea name="{{ $skey->config_key }}" id="{{ $skey->config_key }}" class="form-control" cols="30" rows="10">{{ get_contents_admin($skey->config_key, '', 'all') }}</textarea>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" class="btn btn-success"
                                                    id="">@lang('messages.Save_Change')</button>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @push('scripts')
                            <script>
                                $(document).ready(function() {
                                    $("#logo_{{ $key3 }}").change(function() {
                                        $('#image_preview_{{ $key3 }}').html("");
                                        var post_file = document.getElementById("logo_{{ $key3 }}").files.length;
                                        for (var i = 0; i < post_file; i++) {
                                            $('#image_preview_{{ $key3 }}').append("<img src='" + URL.createObjectURL(event.target.files[i]) +
                                                "' class='img-fluid' style='width:200px'>");
                                        }
                                    });
                                    $('#form_{{ $key3 }}').submit(function(e) {
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
                                        @if ($key == 'logo')
                                            var formData = new FormData(this);
                                            var bar = $('#bar_{{ $key3 }}');
                                            var percent = $('#percent_{{ $key3 }}');
                                            $.ajax({
                                                beforeSend: function() {
                                                    document.getElementById("progress_div_{{ $key3 }}").style.display = "block";
                                                    var percentVal = '0%';
                                                    bar.width(percentVal)
                                                    percent.html(percentVal);
                                                },
                                                uploadProgress: function(event, position, total, percentComplete) {
                                                    var percentVal = percentComplete + '%';
                                                    bar.width(percentVal)
                                                    percent.html(percentVal);
                                                },
                                                type: "POST",
                                                url: "{{ route('dashboard.theme.option.update', ['section' => $key3]) }}",
                                                data: formData,
                                                success: function(data) {
                                                    var percentVal = '100%';
                                                    bar.width(percentVal)
                                                    percent.html(percentVal);
                                                },
                                                complete: function(xhr) {
                                                    $('#progress_div_{{ $key3 }}').hide();
                                                    var json_data = $.trim(xhr.responseText);
                                                    var data = $.parseJSON(json_data);

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

                                                    if (data.result == 'success') {

                                                        //success
                                                        Toastify({
                                                            text: '<span class="fa fa-check-circle"></span> ' +
                                                                data.messages,
                                                            duration: 10000,
                                                            close: true,
                                                            gravity: "top",
                                                            position: "center",
                                                            backgroundColor: "#4fbe87",
                                                        }).showToast();

                                                    } else if (data.result == 'errors') {

                                                        $.each(data.messages, function(i, item) {
                                                            Toastify({
                                                                text: '<span class="fa fa-times-circle"></span> ' +
                                                                    data.messages[i],
                                                                duration: 10000,
                                                                close: true,
                                                                gravity: "top",
                                                                position: "center",
                                                                backgroundColor: "red",
                                                            }).showToast();
                                                        });

                                                    } else {

                                                        Toastify({
                                                            text: data.messages,
                                                            duration: 10000,
                                                            close: true,
                                                            gravity: "top",
                                                            position: "center",
                                                            backgroundColor: "red",
                                                        }).showToast();

                                                    }

                                                },
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                error: error_data
                                            });
                                        @else

                                            $.ajax({
                                                type: "POST",
                                                url: "{{ route('dashboard.theme.option.update', ['section' => $key3]) }}",
                                                data: $form.serialize(),
                                                success: save_data,
                                                dataType: 'json',
                                                error: error_data
                                            });
                                        @endif
                                    });
                                });
                            </script>
                        @endpush
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endforeach
