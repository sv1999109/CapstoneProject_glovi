{{-- Notifications Settings --}}
<div role="tabpanel" class="tab-pane fade  @if ($type == 'notification') show active @endif" id="notifications"
    aria-labelledby="settings-mail-tab">
    <div class="card-header mb-3">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('messages.Alert_Notifications') }}</h3>
        </div>
    </div>
    <hr class="divider">
    {{-- notifications --}}
    <div class="card">
        <div class="card-body">
            <p class="fw-bolder">@lang('messages.Alert_Notifications')</p>
            <div class="box row">
                <div class="col-md-6 pb-2">
                    <div class="box-item-notification">
                        <div class="row">
                            <div class="col-8">
                                <i class="bi bi-bell bi-sub fs-4 text-gray-600"></i>
                                {{ trans_choice('messages.Shipment', 1) }}
                            </div>
                            <div class="col-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="shipment_notification"
                                        value="enabled" id="shipment_notification"
                                        @if (get_config('shipment_notification') == 'enabled') checked @endif>
                                    <label class="form-check-label" for="shipment_notification"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pb-2">
                    <div class="box-item-notification">
                        <div class="row">
                            <div class="col-8">
                                <i class="bi bi-bell bi-sub fs-4 text-gray-600"></i>
                                {{ trans_choice('messages.Invoice', 1) }}
                                <br>
                            </div>
                            <div class="col-4 text-right">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="invoice_notification"
                                        value="enabled" id="invoice_notification"
                                        @if (get_config('invoice_notification') == 'enabled') checked @endif>
                                    <label class="form-check-label" for="invoice_notification"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pb-2">
                    <div class="box-item-notification">
                        <div class="row">
                            <div class="col-8">
                                <i class="bi bi-bell bi-sub fs-4 text-gray-600"></i>
                                @lang('messages.Account')
                                <br>
                            </div>
                            <div class="col-4 text-right">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="account_notification"
                                        value="enabled" id="account_notification"
                                        @if (get_config('account_notification') == 'enabled') checked @endif>
                                    <label class="form-check-label" for="account_notification"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pb-2">
                    <div class="box-item-notification">
                        <div class="row">
                            <div class="col-8">
                                <i class="bi bi-bell bi-sub fs-4 text-gray-600"></i>
                                @lang('messages.Insite_Alert')
                                <br>
                            </div>
                            <div class="col-4 text-right">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="site_notification"
                                        value="enabled" id="site_notification"
                                        @if (get_config('site_notification') == 'enabled') checked @endif>
                                    <label class="form-check-label" for="site_notification"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="divider">
    {{-- email section --}}
    <div class="card">

        <div class="card-body ">
            <div class="form-group row mb-3">
                <label class="col-sm-5"></label>
                <div class="col-sm-7">
                    <div class="form-check form-switch">
                        <input name="email_notification" class="form-check-input" type="checkbox" value="enabled"
                            id="email_notification" @if (get_config('email_notification') == 'enabled') checked @endif>
                        <label class="form-check-label" for="email_notification">
                            @lang('messages.Email_Alert')
                        </label>
                    </div>
                </div>
            </div>
            <div class="mail_form_settings">
                <div class="form-group row mb-3">
                    <label
                        class="col-sm-5 text-left control-label col-form-label">{{ __('messages.Default_Mailer') }}</label>
                    <div class="col-sm-7">
                        <select name="default_mailer" value="1" class="form-select" id="default_mailer">
                            <option value="smtp" @if (get_config('default_mailer') == 'smtp') selected @endif>SMTP</option>
                            <option value="sendmail" @if (get_config('default_mailer') == 'sendmail') selected @endif>Sendmail</option>
                            <option value="mailgun" @if (get_config('default_mailer') == 'mailgun') selected @endif>Mailgun</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-5 text-left control-label col-form-label">{{ __('messages.Sender') }}
                        {{ __('messages.Name') }}</label>
                    <div class="col-sm-7">
                        <input type="text" name="default_mailer_sender_name" class="form-control"
                            id="default_mailer_sender_name" value="{{ get_config('default_mailer_sender_name') }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-5 text-left control-label col-form-label">{{ __('messages.Sender') }}
                        {{ __('messages.Email') }}</label>
                    <div class="col-sm-7">
                        <input type="text" name="default_mailer_sender_email" class="form-control"
                            id="default_mailer_sender_email" value="{{ get_config('default_mailer_sender_email') }}">
                    </div>
                </div>
                {{-- smtp section --}}
                <div class="smtp-section" id="mail-form-set" style="display: @if (get_config('default_mailer') == 'smtp') block @else none @endif">
                    <div class="form-group row mb-3">
                        <label class="col-sm-5 text-left control-label col-form-label">{{ __('Encryption') }}</label>
                        <div class="col-sm-7">
                            <select name="default_mailer_encryption" class="form-select"
                                id="default_mailer_encryption">
                                <option value="ssl" @if (get_config('default_mailer_encryption') == 'ssl') selected @endif>SSL</option>
                                <option value="tls" @if (get_config('default_mailer_encryption') == 'tls') selected @endif>TLS</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-5 text-left control-label col-form-label">{{ __('Host') }}</label>
                        <div class="col-sm-7">
                            <input type="text" name="default_mailer_host" class="form-control"
                                id="default_mailer_host" value="{{ get_config('default_mailer_host') }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-5 text-left control-label col-form-label">{{ __('Port') }}</label>
                        <div class="col-sm-7">
                            <input type="text" name="default_mailer_port" class="form-control"
                                id="default_mailer_port" value="{{ get_config('default_mailer_port') }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            class="col-sm-5 text-left control-label col-form-label">{{ __('messages.Username') }}</label>
                        <div class="col-sm-7">
                            <input type="text" name="default_mailer_username" class="form-control"
                                id="default_mailer_username" value="{{ get_config('default_mailer_username') }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            class="col-sm-5 text-left control-label col-form-label">{{ __('messages.Password') }}</label>
                        <div class="col-sm-7">
                            <input type="password" name="default_mailer_password" class="form-control"
                                id="default_mailer_password" value="{{ get_config('default_mailer_password') }}">
                        </div>
                    </div>
                </div>

                {{-- mailgun section --}}
                <div class="mailgun-section" id="mail-form-set"
                    style="display: @if (get_config('default_mailer') == 'mailgun') block @else none @endif">
                    <div class="form-group row mb-3">
                        <label
                            class="col-sm-5 text-left control-label col-form-label">{{ __('Mailgun Domain') }}</label>
                        <div class="col-sm-7">
                            <input type="text" name="default_mailer_mailgun_domain" class="form-control"
                                id="default_mailer_mailgun_domain"
                                value="{{ get_config('default_mailer_mailgun_domain') }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-5 text-left control-label col-form-label">{{ __('Mailgun') }}
                            @lang('messages.Secret_Key')</label>
                        <div class="col-sm-7">
                            <input type="text" name="default_mailer_mailgun_key" class="form-control"
                                id="default_mailer_mailgun_key"
                                value="{{ get_config('default_mailer_mailgun_key') }}">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- sms section --}}
    <div class="card">
        <div class="card-body ">
            <div class="form-group row mb-3">
                <label class="col-sm-5"></label>
                <div class="col-sm-7">
                    <div class="form-check form-switch">
                        <input name="sms_notification" class="form-check-input" type="checkbox" value="enabled"
                            id="sms_notification" @if (get_config('sms_notification') == 'enabled') checked @endif>
                        <label class="form-check-label" for="sms_alert">
                            @lang('messages.SMS_Alert')
                        </label>
                    </div>
                </div>
            </div>
            <div class="sms_form_settings">
                <div class="form-group row mb-3">
                    <label
                        class="col-sm-5 text-left control-label col-form-label">{{ __('messages.Gateway') }}</label>
                    <div class="col-sm-7">
                        <select name="default_sms_gateway" class="form-select" id="default_sms_gateway">
                            <option value="twilo" @if (get_config('default_sms_gateway') == 'twilo') selected @endif>Twilo</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-5 text-left control-label col-form-label">{{ __('messages.Sender') }}
                        {{ __('messages.Number') }}</label>
                    <div class="col-sm-7">
                        <input type="text" name="sms_sender_number" class="form-control" id="sms_sender_number"
                            value="{{ get_config('sms_sender_number') }}">
                    </div>
                </div>
                {{-- twilo section --}}
                <div class="twilo-section" id="mail-form-set" style="display: block">
                    <div class="form-group row mb-3">
                        <label class="col-sm-5 text-left control-label col-form-label">{{ __('Twilo SID') }}</label>
                        <div class="col-sm-7">
                            <input type="text" name="sms_twilo_sid" class="form-control" id="sms_twilo_sid"
                                value="{{ get_config('sms_twilo_sid') }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            class="col-sm-5 text-left control-label col-form-label">{{ __('Twilo Auth token') }}</label>
                        <div class="col-sm-7">
                            <input type="text" name="sms_twilo_auth_token" class="form-control"
                                id="sms_twilo_auth_token" value="{{ get_config('sms_twilo_auth_token') }}">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@push('scripts')
    {{-- Notifications script --}}
    <script>
        $(document).ready(function() {
            $("input[id='email_notification']").click(function() {
                var EValue = $("input[id='email_notification']:checked").length > 0;
                if (EValue) {
                    $('.mail_form_settings input').attr('disabled', false);
                    $('.mail_form_settings select').attr('disabled', false);
                } else {
                    $('.mail_form_settings input').attr('disabled', true);
                    $('.mail_form_settings select').attr('disabled', true);
                }
            });

            $('#default_mailer').change(function() {
                var Value = $(this).val();
                //sendmail selected
                if (Value == 'sendmail') {
                    $('.sendmail-section input').attr('disabled', false);
                    $('.sendmail-section').show();
                    $('.smtp-section').hide();
                    $('.smtp-section input').attr('disabled', true);
                    $('.mailgun-section').hide();
                    $('.mailgun-section input').attr('disabled', true);
                }
                //smtp selected
                if (Value == 'smtp') {
                    $('.sendmail-section input').attr('disabled', true);
                    $('.sendmail-section').hide();
                    $('.smtp-section').show();
                    $('.smtp-section input').attr('disabled', false);
                    $('.mailgun-section').hide();
                    $('.mailgun-section input').attr('disabled', true);


                }
                //mailgun selected
                if (Value == 'mailgun') {
                    $('.sendmail-section input').attr('disabled', true);
                    $('.sendmail-section').hide();
                    $('.smtp-section').hide();
                    $('.smtp-section input').attr('disabled', true);
                    $('.mailgun-section').show();
                    $('.mailgun-section input').attr('disabled', false);
                }

            });

            $("input[id='sms_notification']").click(function() {
                var EValue = $("input[id='sms_notification']:checked").length > 0;
                if (EValue) {
                    $('.sms_form_settings input').attr('disabled', false);
                    $('.sms_form_settings select').attr('disabled', false);
                } else {
                    $('.sms_form_settings input').attr('disabled', true);
                    $('.sms_form_settings select').attr('disabled', true);
                }
            });

        });
    </script>
    {{-- / Notifications script --}}
@endpush
