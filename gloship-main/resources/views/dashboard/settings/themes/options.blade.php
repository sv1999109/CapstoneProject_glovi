@php
    $theme_options = json_decode($theme_options, true);
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
{{-- contents --}}
    <div class="row">
        <div class="col-md-3 mb-2 mb-md-0">
            {{-- Navtabs --}}
            <ul class="nav nav-pills flex-column nav-left">
                <li class="nav-item" role="presentation">
                    @foreach ($theme_options as $key => $item)
                        <a class="nav-link @if ($section == $key) active @endif" id="pill-{{ $key }}"
                            data-bs-toggle="pill" href="#{{ $key }}" aria-controls="settings-{{ $key }}-tab"
                            aria-labelledby="settings-{{ $key }}-tab" role="tab" aria-expanded="true">
                            <span class="font-weight-bold">{{ ucfirst($key) }}</span>
                        </a>
                    @endforeach

                </li>
            </ul>
            {{-- // Navtabs --}}
        </div>
        <div class="col-md-9">

            <div class="tab-content" id="setting-pill">
                @foreach ($theme_options as $key => $item)
                    <div role="tabpanel" class="tab-pane fade @if ($section == $key) show active @endif"
                        id="{{ $key }}" aria-labelledby="settings-{{ $key }}-tab">
                        <div class="card-header mb-3">
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0">
                                    {{ ucfirst($key) }} {{ trans_choice('messages.Setting', 2) }}
                                </h3>
                            </div>
                        </div>

                        <hr class="divider">
                        @include(get_theme_dir('settings.themes.form', 'dashboard'), [
                            'key' => $key,
                            'item' => $item,
                        ])
                        
                    </div>
                @endforeach

            </div>

        </div>
    </div>
@endsection


@push('css')
    <style>
        .accordion-header {
            margin-bottom: 0;
        }

        .accordion-button {
            text-align: left;
        }

        .accordion-body {
            padding: 1.5rem 1.5rem;
        }

        .accordion-button:not(.collapsed) {
            color: #202944;
            background-color: #F3F4F6;
        }

        .accordion-button:focus {
            border-color: #2c8b11;
        }

        .accordion-button {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            padding: 1.5rem 1.5rem;
            font-size: 1rem;
            color: #1F2937;
            text-align: left;
            background-color: rgba(0, 0, 0, 0);
            border: 0.0625rem solid #E5E7EB;
            border-radius: 0;
            overflow-anchor: none;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, border-radius 0.15s ease;
        }

        .accordion-button::after {
            flex-shrink: 0;
            width: var(--bs-accordion-btn-icon-width);
            height: var(--bs-accordion-btn-icon-width);
            margin-left: auto;
            content: "-";
            background-image: var(--bs-accordion-btn-icon);
            background-repeat: no-repeat;
            background-size: var(--bs-accordion-btn-icon-width);
            transition: var(--bs-accordion-btn-icon-transition);
        }
    </style>
@endpush
