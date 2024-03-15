@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <!-- contents -->
    <div class="card">
        <div class="card-header">
            <h4 class="fw-bolder">@lang('messages.System_Info')</h4>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-6 text-left control-label col-form-label">{{ __('messages.System_Software') }} </label>
                <div class="col-sm-6">
                    {{ get_config('system_software') }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 text-left control-label col-form-label">{{ __('messages.Software_Version') }} </label>
                <div class="col-sm-6">
                    {{ get_config('system_software_version') }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 text-left control-label col-form-label">{{ __('messages.System_Framework') }}
                </label>
                <div class="col-sm-6">
                    Laravel {{ app()->version() }} 
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 text-left control-label col-form-label">{{ __('PHP Version') }}
                </label>
                <div class="col-sm-6">
                    {{ phpversion() }}
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-6 text-left control-label col-form-label">{{ trans_choice('messages.Theme', 1) }} </label>
                <div class="col-sm-6">
                    {{ get_theme_config_data('name', get_config('site_theme')) }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-6 text-left control-label col-form-label">{{ __('messages.Theme_Version') }} </label>
                <div class="col-sm-6">
                    {{ get_theme_config_data('version', get_config('site_theme')) }}
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button type="button" id="clear" class="btn btn-light-success me-2">
                <ion-icon name="reload-outline" class="icon"></ion-icon>
                 @lang('messages.Purge_Cache')
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("button[id='clear']").click(function() {
                $.ajax({
                    type: "GET",
                    url: "{{ url('clear') }}"
                }).done(function(data) {
                    Toastify({
                        text: data,
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#4fbe87",
                    }).showToast();
                });
            });
        });
    </script>
@endpush
