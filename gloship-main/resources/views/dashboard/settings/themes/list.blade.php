@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div id="list">
        <h2>
            @lang('messages.Available_Theme') ({{ list_themes('in_db')->count() }}) 
            <a class="text-sm" href="{{ route('dashboard.settings.themes.add') }}">@lang('messages.Add')</a>
        </h2>
        <div class="row">
            @foreach (list_themes('in_db') as $item)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center">
                                {{ $item->name }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <a data-bs-toggle="modal" data-bs-target="#theme-{{ $item->id }}" href="#{{ $item->id }}">
                                <img class="img-fluid js--lazyload" src="{{ asset('assets/themes/' . $item->slug . '/screenshot.png') }}" data-lazyload="{{ asset('assets/themes/' . $item->slug . '/screenshot.png') }}"
                                    alt="{{ $item->name }}">
                            </a>
                        </div>
                        <div class="card-footer">
                            <span class="float-left">
                                @lang('messages.Version'):
                                {{ get_theme_config_data('version', $item->slug) }}
                            </span>
                            <span class="float-right">
                                @lang('messages.Author'):
                                {{ get_theme_config_data('author', $item->slug) }}
                            </span>

                            <div class="float-left">
                                <div class="badges">
                                    <span
                                        class="badge bg-{{ get_status_color($item->status) }} font-12">{{ get_status('', $item->status) }}</span>
                                </div>
                            </div>
                            <div class="float-right">
                                @if ($item->status == 1)
                                    <a class="btn rounded-pill btn-light-secondary m-1"
                                        href="{{ route('dashboard.settings.themes.option', ['slug' => 'homepage']) }}">
                                        {{ trans_choice('messages.Theme', 1) }} {{ trans_choice('messages.Setting', 2) }}
                                    </a>
                                @endif
                                @if ($item->status == 2)
                                    <a class="btn rounded-pill btn-light-secondary m-1" href="#"
                                        data-bs-toggle="modal" data-bs-target="#theme-{{ $item->id }}"
                                        href="#{{ $item->id }}">
                                        {{ trans_choice('messages.Theme', 1) }} @lang('messages.Info')
                                    </a>
                                    <a data-bs-toggle="modal" class="btn btn-sm rounded-pill btn-primary m-1"
                                        data-bs-target="#theme-activate-{{ $item->id }}" href="#{{ $item->id }}">
                                        @lang('messages.Activate')
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                {{--  Modal Theme Info  --}}
                <div class="modal fade" id="theme-{{ $item->id }}" tabindex="-1" aria-labelledby="myModalLabel17"
                    aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel17"> {{ $item->name }}
                                    {{ trans_choice('messages.Theme', 1) }} </h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img class="img-fluid js--lazyload" src="{{ asset('assets/themes/' . $item->slug . '/screenshot.png') }}" data-lazyload="{{ asset('assets/themes/' . $item->slug . '/screenshot.png') }}"
                                    alt=" {{ $item->name }}">
                                <hr>
                                <p>
                                    <b>@lang('messages.Theme_Description'):</b> {{ get_theme_config_data('description', $item->slug) }}
                                </p>
                                <p>
                                    <b>@lang('messages.Theme_Version'):</b> {{ get_theme_config_data('version', $item->slug) }}
                                </p>
                                <p>
                                    <b>@lang('messages.Require'):</b> {{ get_config('system_software') }}
                                    v{{ get_theme_config_data('require', $item->slug) }}+
                                </p>
                                <p>
                                    <b>@lang('messages.Author'):</b>
                                    {{ get_theme_config_data('author', $item->slug) }}
                                </p>
                                <p>
                                    <b>@lang('messages.Tags'):</b> {{ get_theme_config_data('tags', $item->slug) }}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">@lang('messages.Close')</span>
                                </button>
                                @if ($item->status == 1)
                                    <a class="btn btn-light-success"
                                        href="{{ route('dashboard.settings.themes.option', ['slug' => 'homepage']) }}">
                                        {{ trans_choice('messages.Theme', 1) }} {{ trans_choice('messages.Setting', 2) }}
                                    </a>
                                @else
                                    <a class="btn btn-light-success" data-bs-toggle="modal"
                                        data-bs-target="#theme-activate-{{ $item->id }}" href="#{{ $item->id }}">
                                        @lang('messages.Activate')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Theme Activation --}}
                <div class="modal fade" id="theme-activate-{{ $item->id }}" tabindex="-1"
                    aria-labelledby="myModal{{ $item->id }}" aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModal{{ $item->id }}">@lang('messages.Activate')
                                    {{ $item->name }} {{ trans_choice('messages.Theme', 1) }} </h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="alert alert-light-success" role="alert">
                                    {{ __('Are you sure you want to switch this template to your default theme?') }}
                                </div>

                                @if (DB::table('theme_settings')->where('theme', $item->slug)->count() == 0 ||
                                    DB::table('theme_contents')->where('theme', $item->slug)->count() == 0)
                                    <div class="alert alert-light-danger" role="alert">
                                        <strong>{{ __('Warning') }}:</strong>
                                        {{ __('This theme is properly configured and main cause some errors after activation') }}
                                    </div>
                                @endif
                                @if (!\File::exists('resources/views/themes/' . $item->slug . '/home.blade.php'))
                                    <div class="alert alert-light-danger" role="alert">
                                        <strong>{{ __('Warning') }}:</strong>
                                        {{ __('Homepage file is empty') }}
                                    </div>
                                @endif

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">@lang('messages.Close')</span>
                                </button>
                                @if ($item->status == 1)
                                    <a class="btn btn-light-success"
                                        href="{{ route('dashboard.settings.themes.option', ['slug' => 'homepage']) }}">
                                        {{ trans_choice('messages.Theme', 1) }} {{ trans_choice('messages.Setting', 2) }}
                                    </a>
                                @else
                                    <a class="btn btn-success"
                                        href="{{ route('dashboard.settings.themes.activate', ['slug' => $item->slug]) }}">
                                        @lang('messages.Activate')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
