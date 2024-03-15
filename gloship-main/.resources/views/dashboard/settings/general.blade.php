@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div id="general-settings">
        <div class="row">
            <div class="col-md-2 mb-2 mb-md-0">

                {{-- Navtabs --}}
                <ul class="nav nav-pills flex-column nav-left">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link @if ($type == 'general') active @endif" id="pill-general"
                            data-bs-toggle="pill" href="#general" aria-controls="settings-general-tab"
                            aria-labelledby="settings-general-tab" role="tab" aria-expanded="true">
                            <span class="font-weight-bold">{{ __('messages.General') }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link  @if ($type == 'notification') active @endif" id="pill-notifications"
                            data-bs-toggle="pill" href="#notifications" aria-controls="pill-notifications" role="tab"
                            aria-expanded="false">
                            <span class="font-weight-bold">{{ trans_choice('messages.Notification', 2) }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link  @if ($type == 'contacts') active @endif" id="pill-contacts"
                            data-bs-toggle="pill" href="#contacts" aria-controls="pill-contacts" role="tab"
                            aria-expanded="false">
                            <span class="font-weight-bold">{{ __('messages.Contacts') }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link  @if ($type == 'social') active @endif" id="pill-social"
                            data-bs-toggle="pill" href="#social" aria-expanded="false">
                            <span class="font-weight-bold">{{ __('messages.Social') }}</span>
                        </a>
                    </li>

                </ul>
                {{-- // Navtabs --}}
            </div>
            <div class="col-md-10">
                {{-- form --}}
                <form id="save_config_form" data-action="" method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="page" value="general">
                    <div class="form-body-section">
                        <div class="tab-content" id="setting-pill-general">

                            {{-- Basic Info Panel --}}
                            @include(get_theme_dir('settings.sections.general.basic', 'dashboard'))
                            {{-- // Basic Info --}}

                            {{-- Contacts Panel --}}
                            @include(get_theme_dir('settings.sections.general.contact', 'dashboard'))
                            {{-- // Contacts Panel --}}
                            {{-- Contacts Panel --}}
                            @include(get_theme_dir('settings.sections.general.notification', 'dashboard'))
                            {{-- // Contacts Panel --}}

                            {{-- Socials Media Settings --}}
                            @include(get_theme_dir('settings.sections.general.social', 'dashboard'))


                            {{-- Submit  --}}
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ url()->previous() }}"
                                    class="btn btn-light btn-active-light-primary me-2">@lang('messages.Cancel')</a>
                                <button type="submit" class="btn btn-success" id="">@lang('messages.Save_Change')</button>
                            </div>
                        </div>
                    </div>

                </form>
                {{-- //form --}}
            </div>
        </div>
    </div>
@endsection


@push('css')
    <style>
        .fade:not(.show) {
            opacity: 0;
            display: none;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {

            //start: save config data script
            $('#save_config_form').submit(function(e) {
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
                    url: "",
                    data: $form.serialize(),
                    success: save_config_data,
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
            //end: save config data script
        });


        /**
         * save data in specified stotage
         * 
         * @param data
         * @return data
         */
        function save_config_data(data) {

            if (data.result == 'success') {

                //success
                Toastify({
                    text: data.messages,
                    duration: 10000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "green",
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

            } else if (data.result == 'errors') {

                $.each(data.messages, function(i, item) {
                    Toastify({
                        text: data.messages[i],
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                });

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
            } else {

                Toastify({
                    text: data.messages,
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

        }
    </script>
@endpush
