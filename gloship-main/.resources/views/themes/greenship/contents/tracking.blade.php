{{-- //Tracking Statuses
    '0' => 'Pending',
    '1' => 'Created',
    '2' => 'Pending Pickup Confirmation',
    '3' => 'Ready for shipment',
    '4' => 'Shipped',
    '5' => 'Arrives at',
    '6' => 'Custom Clearing',
    '7' => 'Ready for Pickup',
    '8' => 'Out for Delievering',
    '9' => 'Failed Delivery Attempts',
    '10' => 'Canceled',
    '11' => 'Shipping On-Hold',
    '12' => 'Returned',
    '13' => 'Delivered',
    '14' => 'Rejected'
  --}}

@extends(get_theme_dir('layouts.app'))
@section('content')
    @include(get_theme_dir('layouts.partials.page-heading-empty'))
    <div id="tracking-page" class="features_page">
        <div class="container">

            @if (isset($track))
                <div class="tracking-detail-section mb-5 mt-5">

                    <div class="card">

                        @if ($track->status == 0 || $track->status == 14)
                            <div class="card-body">
                                <div class="alert alert-{{ get_status_color($track->status, 'shipments') }} alert-dismissible fade show"
                                    role="alert">

                                    <strong>@lang('messages.Shipment_Status'):</strong>
                                    {{ get_status('shipments', $track->status) }}.
                                    <blockquote> {{ get_status('shipment-notes', $track->status) }}</blockquote>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <h3 class="card-title text-muted text-center">

                                    {{ get_status('shipments', $track->status) }}

                                    {{-- only show current location if shipment status is arrives, ready for pickup, custom clearance --}}
                                    @if ($track->status == 5 || $track->status == 6 || $track->status == 7)
                                        {{-- add "at" to location --}}
                                        @if ($track->status == 6 || $track->status == 7)
                                            at
                                        @endif
                                        {{-- //add "at" to location --}}

                                        {{ $track->current_location }}
                                    @endif
                                </h3>

                                <h5 class="card-subtitle text-muted text-center text-sm">
                                    <small>
                                        <i>
                                            @lang('messages.Last_Updated_On')
                                            <x-date-time-zone :date="\Carbon\Carbon::parse($track->updated_at)" format="l jS \of F Y h:i:s A" /> UTC(
                                            <x-date-time-zone :date="Carbon\Carbon::parse($track->updated_at)" format="p" />)
                                        </i>
                                    </small>
                                </h5>
                                <div class="row mt-5">
                                    <div class="col-md-10" style="float: none; margin:auto">
                                        <ul class="cbp_track">

                                            {{--  Delivered Shipment --}}
                                            @if ($track->status != 10)
                                                <li class="shipment-item">
                                                    @if ($track->delivery_date)
                                                        <time class="cbp_tmtime">
                                                            <span>
                                                                <x-date-time-zone :date="\Carbon\Carbon::parse($track->delivery_date)" format="j M, Y" />
                                                            </span>

                                                            @if ($track->status != 13)
                                                                <span>@lang('messages.Estimated')</span>
                                                            @endif
                                                        </time>
                                                    @endif
                                                    <div class="cbp_tmicon"> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel empty">
                                                        <h2><strong> {{ get_status('shipments', '13') }}</strong></h2>
                                                        @if ($track->status == 13)
                                                            <blockquote>{{ get_status('shipment-notes', $track->status) }}
                                                            </blockquote>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endif
                                            {{-- // Delivered Shipment --}}

                                            {{-- Failed Delivery Attempts --}}
                                            @if ($track->status == 9)
                                                <li class="shipment-item bg-error">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <x-date-time-zone :date="\Carbon\Carbon::parse($track->updated_at)" format="H:i A" />
                                                        </span>
                                                        <span>{{ \Carbon\Carbon::parse($track->updated_at)->diffForHumans() }}</span>
                                                    </time>
                                                    <div class="cbp_tmicon text-bg-danger"> <i class="fa fa-times"></i>
                                                    </div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> {{ get_status('shipments', $track->status) }}</strong>
                                                        </h2>
                                                        @if ($track->status == 9)
                                                            <blockquote>{{ get_status('shipment-notes', $track->status) }}
                                                            </blockquote>
                                                        @endif

                                                    </div>
                                                </li>
                                            @endif
                                            {{-- //  Failed Delivery Attempts --}}

                                            {{-- Out for Delivering --}}
                                            @if ($track->status != 10 && $track->status != 11 && $track->delivery_type == 2)
                                                <li
                                                    class="shipment-item @if ($track->status >= 8) bg-passed @endif">

                                                    <div class="cbp_tmicon"> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> {{ get_status('shipments', '8') }}</strong></h2>
                                                        @if ($track->status == 8)
                                                            <blockquote>{{ get_status('shipment-notes', $track->status) }}
                                                            </blockquote>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endif
                                            {{-- //Out for Delivering --}}

                                            {{-- Shipping On-Hold --}}
                                            @if ($track->status == 11)
                                                <li
                                                    class="shipment-item @if ($track->status >= 8) bg-passed @endif">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <x-date-time-zone :date="\Carbon\Carbon::parse($track->updated_at)" format="H:i A" />
                                                        </span>
                                                        <span>{{ \Carbon\Carbon::parse($track->updated_at)->diffForHumans() }}</span>
                                                    </time>

                                                    <div class="cbp_tmicon"> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> {{ get_status('shipments', $track->status) }}</strong>
                                                        </h2>
                                                        @if ($track->status == 11)
                                                            <blockquote>{{ get_status('shipment-notes', $track->status) }}
                                                            </blockquote>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endif
                                            {{-- //Shipping On-Hold --}}

                                            {{-- Current Location --}}
                                            @if ($track->status == 5 || $track->status == 6 || $track->status == 7)
                                                <li class="shipment-item bg-passed">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <x-date-time-zone :date="\Carbon\Carbon::parse($track->updated_at)" format="H:i A" />
                                                        </span>
                                                        <span>{{ \Carbon\Carbon::parse($track->updated_at)->diffForHumans() }}</span>
                                                    </time>
                                                    <div class="cbp_tmicon "> <i class="fa fa-map-marker-alt"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2>
                                                            <strong>
                                                                {{ get_status('shipments', $track->status) }}
                                                                {{-- add "at" to location --}}
                                                                @if ($track->status == 6 || $track->status == 7)
                                                                    at
                                                                @endif
                                                                {{-- //add "at" to location --}}

                                                                {{ $track->current_location }}
                                                            </strong>
                                                        </h2>
                                                        <blockquote>{{ get_content_locale($track->note) }}</blockquote>

                                                    </div>
                                                </li>
                                            @endif
                                            {{-- //  Current Location --}}

                                            {{--  Shipped Shipment --}}
                                            @if ($track->status != 10)
                                                <li
                                                    class="shipment-item  @if ($track->status >= 4 && $track->status != 10) bg-passed @endif">
                                                    @if ($track->shipped_date)
                                                        <time class="cbp_tmtime">
                                                            @if ($track->status >= 4)
                                                                <span>
                                                                    <x-date-time-zone :date="\Carbon\Carbon::parse(
                                                                        $track->shipped_date,
                                                                    )" format="H:i A" />
                                                                </span>
                                                                <span>{{ \Carbon\Carbon::parse($track->shipped_date)->diffForHumans() }}</span>
                                                            @endif
                                                        </time>
                                                    @endif

                                                    <div class="cbp_tmicon "> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> {{ get_status('shipments', '4') }}</strong></h2>
                                                        @if ($track->status == 4)
                                                            <blockquote>{{ get_status('shipment-notes', $track->status) }}
                                                            </blockquote>
                                                        @elseif($track->status >= 4)
                                                            {{ __('Your parcel has been shipped') }}
                                                        @endif
                                                    </div>
                                                </li>
                                            @endif
                                            {{-- // Shipped Shipment --}}

                                            {{--  Ready For Shipment --}}
                                            @if ($track->status == 3)
                                                <li class="shipment-item bg-passed">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <x-date-time-zone :date="\Carbon\Carbon::parse($track->updated_at)" format="H:i A" />
                                                        </span>
                                                        <span>{{ \Carbon\Carbon::parse($track->updated_at)->diffForHumans() }}</span>
                                                    </time>
                                                    <div class="cbp_tmicon "> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> {{ get_status('shipments', $track->status) }}</strong>
                                                        </h2>
                                                        @if ($track->status == 3)
                                                            <blockquote>{{ get_status('shipment-notes', $track->status) }}
                                                            </blockquote>
                                                        @endif

                                                    </div>
                                                </li>
                                            @endif
                                            {{-- //  Ready For Shipment --}}

                                            {{--  Pending Pickup Confirmation --}}
                                            @if ($track->status == 2)
                                                <li class="shipment-item bg-passed">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <x-date-time-zone :date="\Carbon\Carbon::parse($track->updated_at)" format="H:i A" />
                                                        </span>
                                                        <span>{{ \Carbon\Carbon::parse($track->updated_at)->diffForHumans() }}</span>
                                                    </time>
                                                    <div class="cbp_tmicon "> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> {{ get_status('shipments', $track->status) }}</strong>
                                                        </h2>
                                                        @if ($track->status == 2)
                                                            <blockquote>{{ get_status('shipment-notes', $track->status) }}
                                                            </blockquote>
                                                        @endif

                                                    </div>
                                                </li>
                                            @endif
                                            {{-- //  Pending Pickup Confirmation --}}

                                            {{-- Canceled Shipment --}}
                                            @if ($track->status == 10)
                                                <li class="shipment-item bg-error">
                                                    <time class="cbp_tmtime">

                                                        <span>{{ \Carbon\Carbon::parse($track->updated_at)->format('H:i A') }}</span>
                                                        <span>{{ \Carbon\Carbon::parse($track->updated_at)->diffForHumans() }}</span>
                                                    </time>
                                                    <div class="cbp_tmicon text-bg-danger"> <i class="fa fa-times"></i>
                                                    </div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> {{ get_status('shipments', $track->status) }}</strong>
                                                        </h2>
                                                        @if ($track->status == 10)
                                                            <blockquote>{{ get_status('shipment-notes', $track->status) }}
                                                            </blockquote>
                                                        @endif

                                                    </div>
                                                </li>
                                            @endif
                                            {{-- // Canceled Shipment --}}

                                            <li class="shipment-item bg-passed">
                                                <time class="cbp_tmtime">
                                                    <span>
                                                        <x-date-time-zone :date="\Carbon\Carbon::parse($track->created_at)" format="H:i A" />
                                                    </span>
                                                    <span>{{ \Carbon\Carbon::parse($track->created_at)->diffForHumans() }}</span>
                                                </time>
                                                <div class="cbp_tmicon "><i class="fa fa-check"></i></div>
                                                <div class="cbp_tmlabel">
                                                    <time class="no-desktop text-muted text-sm float-right"
                                                        datetime="2017-11-03T13:22">
                                                        <span>{{ $track->created_at->diffForHumans() }}</span>
                                                    </time>
                                                    <h2><strong> {{ get_status('shipments', '1') }}</strong></h2>
                                                    @if ($track->status == 1)
                                                        <blockquote>{{ get_status('shipment-notes', $track->status) }}
                                                        </blockquote>
                                                    @else
                                                        {{ __('Your label has been created') }}
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="fact-tab" data-bs-toggle="tab"
                                                    data-bs-target="#fact-tab-pane" type="button" role="tab"
                                                    aria-controls="fact-tab-pane"
                                                    aria-selected="true">@lang('messages.Shipment_Fact')</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                    data-bs-target="#logs-tab-pane" type="button" role="tab"
                                                    aria-controls="logs-tab-pane"
                                                    aria-selected="false">@lang('messages.Shipment_Logs')</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="fact-tab-pane" role="tabpanel"
                                                aria-labelledby="fact-tab" tabindex="0">
                                                <div class="table-responsive mt-5">

                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th
                                                                    class="pl-0 font-weight-bold text-muted text-uppercase">
                                                                    @lang('messages.Origin')</th>
                                                                <th class="text-right text-muted text-uppercase">
                                                                    @lang('messages.Destination')</th>
                                                                <th class="pr-0 text-right text-muted text-uppercase">
                                                                    @lang('messages.Tracking_Number')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="font-weight-boldest">
                                                                <td> {{ get_name($track->sender_state, 'states') }},
                                                                    {{ get_name($track->sender_country, 'countries') }}
                                                                </td>
                                                                <td> {{ get_name($track->receiver_state, 'states') }},
                                                                    {{ get_name($track->receiver_country, 'countries') }}
                                                                </td>
                                                                <td> {{ $track->code }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <table class="table table-bordered mt-5">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 59%"
                                                                    class="pl-0 font-weight-bold text-muted text-uppercase">
                                                                    {{ trans_choice('messages.Item', 2) }}</th>
                                                                <th class="text-right  text-muted text-uppercase">
                                                                    @lang('messages.Weight_Kg')</th>
                                                                <th class="pr-0 text-right  text-muted text-uppercase">
                                                                    @lang('messages.Quantity')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($packages as $package)
                                                                <tr class="font-weight-boldest">
                                                                    <td style="width: 59%"><strong>
                                                                            {{ $package->description }}</strong></td>
                                                                    <td> {{ $package->weight }}</td>
                                                                    <td> {{ $package->qty }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="logs-tab-pane" role="tabpanel"
                                                aria-labelledby="logs-tab" tabindex="0">

                                                <div class="col-md-10 mt-5" style="float: none; margin:auto">
                                                    <ul class="cbp_track">

                                                        @foreach ($logs as $log)
                                                            @if ($log->note != '')
                                                                <li class="shipment-item bg-passed">
                                                                    <time class="cbp_tmtime">
                                                                        <span>{{ $log->created_at->diffForHumans() }}</span>
                                                                    </time>
                                                                    <div class="cbp_tmicon bg-passed"><i
                                                                            class="fa fa-comment"></i>
                                                                    </div>
                                                                    <div class="cbp_tmlabel">
                                                                        <time
                                                                            class="no-desktop text-muted text-sm float-right"
                                                                            datetime="2017-11-03T13:22">
                                                                            <span>{{ $log->created_at->diffForHumans() }}</span>
                                                                        </time>

                                                                        <blockquote>
                                                                            {{ get_status('shipment-notes', $log->note) }}
                                                                        </blockquote>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            @else
                <div class="card mb-5" style="max-width: 800px; float: none; margin: auto;">
                    <div class="row header top text-center mt-2 p-5 card-body">
                        <div class="col-md-12">
                            <h1 class="mb-3 h-title">@lang('messages.Shipment_Tracking')</h1>

                            @if (isset($error))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>@lang('messages.Error_Occured')</strong> {{ $error }}
                                </div>
                            @endif'

                            <h3 style="font-size: 20px; line-height: 1.5; color:#333333">@lang('messages.Track_Shipment_Subtitle')</h3>
                        </div>

                        <form class="form" action="" method="GET">
                            <div class="mb-3">
                                <input type="text" placeholder="{{ __('messages.Tracking_Number_Input') }}"
                                    class="form-control track-input input-rounded" name="code">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100"><span class="bi bi-search me-2"></span> @lang('messages.Track')</button>
                            </div>
                        </form>

                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
@push('css')
    <style>
        .cbp_track,
        .cbp_track>li {
            position: relative
        }

        .button,
        .button-outline {
            vertical-align: middle;
            zoom: 1;
            -webkit-transition: .2s linear;
            -moz-transition: .2s linear;
            -ms-transition: .2s linear;
            -o-transition: .2s linear
        }

        .button,
        .button-clear,
        .button-outline {
            display: inline-block;
            -webkit-font-smoothing: antialiased
        }

        .button,
        .button-clear,
        .button-outline,
        .cbp_track>li .cbp_tmicon,
        .navbar.normal {
            -webkit-font-smoothing: antialiased
        }

        #blogpost h6 a,
        .button-clear,
        .button-clear:hover,
        .button-outline:hover,
        .button:hover,
        .call-to-action-below-alt a:hover,
        .cbp_track>li .cbp_tmlabel h2 a:hover {
            text-decoration: none
        }

        .cbp_track {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .cbp_track:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--color-primary);
            left: 20%;
            margin-left: -6px
        }

        .cbp_track>li:first-child .cbp_tmtime span.large {
            color: #444;
            font-size: 17px !important;
            font-weight: 700
        }

        .cbp_track>li:first-child .cbp_tmicon {
            color: #fff
        }

        .cbp_track>li:nth-child(odd) .cbp_tmtime span:last-child {
            color: #444;
            font-size: 13px
        }

        .cbp_track>li:nth-child(odd) .cbp_tmlabel {
            background: #f0f1f3
        }

        .cbp_track>li:nth-child(odd) .cbp_tmlabel:after {
            border-right-color: #f0f1f3
        }

        .cbp_track>li .empty span {
            color: #777
        }

        .cbp_track>li .cbp_tmtime {
            display: block;
            width: 23%;
            padding-right: 70px;
            position: absolute
        }

        .cbp_track>li .cbp_tmtime span {
            display: block;
            text-align: right
        }

        .cbp_track>li .cbp_tmtime span:first-child {
            font-size: 15px;
            color: #3d4c5a;
            font-weight: 700
        }

        .cbp_track>li .cbp_tmtime span:last-child {
            font-size: 14px;
            color: #444
        }

        .cbp_track>li .cbp_tmlabel {
            margin: 0 0 15px 25%;
            background: #f0f1f3;
            padding: 1.2em;
            position: relative;
            border-radius: 5px
        }

        .cbp_track>li .cbp_tmlabel:after {
            right: 100%;
            border: 10px solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-right-color: #f0f1f3;
            top: 10px
        }

        .cbp_track>li .cbp_tmlabel blockquote {
            font-size: 16px
        }

        .cbp_track>li .cbp_tmlabel .map-checkin {
            border: 5px solid rgba(235, 235, 235, .2);
            -moz-box-shadow: 0 0 0 1px #ebebeb;
            -webkit-box-shadow: 0 0 0 1px #ebebeb;
            box-shadow: 0 0 0 1px #ebebeb;
            background: #fff !important
        }

        .cbp_track>li .cbp_tmlabel h2 {
            margin: 0;
            padding: 0 0 10px;
            line-height: 26px;
            font-size: 16px;
            font-weight: 400
        }

        .cbp_track>li .cbp_tmlabel h2 a,
        .cbp_track>li .cbp_tmlabel h2 span {
            font-size: 15px
        }

        .cbp_track>li .cbp_tmlabel p {
            color: #444
        }

        .cbp_track>li .cbp_tmicon {
            width: 40px;
            height: 40px;
            speak: none;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            font-size: 1.4em;
            line-height: 40px;
            position: absolute;
            color: #fff;
            background: #f5f5f6;
            border-radius: 50%;
            box-shadow: 0 0 0 5px var(--color-primary);
            text-align: center;
            left: 20%;
            top: 0;
            margin: 0 0 0 -25px
        }

        @media screen and (max-width: 992px) and (min-width:768px) {
            .cbp_track>li .cbp_tmtime {
                padding-right: 60px
            }
        }

        @media screen and (max-width: 65.375em) {
            .cbp_track>li .cbp_tmtime span:last-child {
                font-size: 12px
            }
        }

        @media screen and (max-width: 47.2em) {

            .cbp_track:before,
            .cbp_track>li .cbp_tmicon {
                left: 5%
            }

            .cbp_track>li .cbp_tmlabel {
                margin: 0 0 15px 15%
            }

            .cbp_track>li .cbp_tmtime {
                display: none
            }
        }

        :focus,
        a:focus,
        button:focus {
            outline: 0
        }

        .button {
            padding: 20px 40px;
            font-weight: 700;
            font-size: 17px;
            color: #fff !important;
            border: 0;
            background-color: var(--color-primary);
            transition: .2s linear
        }

        .button:hover {
            background-color: var(--color-primary);
        }

        .button:hover .arw,
        .call-to-action-button a:hover .arw {
            position: relative;
            left: 1px
        }

        .button:active {
            box-shadow: inset 0 3px 3px rgba(0, 0, 0, .29)
        }

        .button.button-small {
            padding: 10px 33px;
            border: 1px solid #68a2ee;
            font-size: 14px;
            font-weight: 500
        }

        .button.outline {
            border: 3px solid #fff
        }

        .blue-band .button.outline {
            background: #274f95
        }

        .blue-band.separator {
            padding-top: 25px !important;
            padding-bottom: 25px !important
        }

        .button.outline:hover {
            border-color: #43b22f
        }

        .blue-band .button.outline:hover {
            border-color: #2d5cae;
            background: #2d5cae
        }

        .button.transparent {
            background: 0 0
        }

        .button.transparent:hover {
            background: #36c
        }

        .button-outline {
            color: #fff;
            padding: 18px 40px;
            border: 2px solid #fff;
            border-radius: 0;
            font-size: 16px;
            font-weight: 400;
            background: rgba(0, 0, 0, .15);
            text-shadow: 1px 1px 1px rgba(0, 0, 0, .1);
            transition: .2s linear
        }

        .bg-passed .cbp_tmicon {
            background-color: var(--color-primary) !important;
            color: #ffffff;
        }

        .shipment-item h2 strong {
            color: #666;
        }

        .bg-passed h2 strong {
            color: #000000 !important;
        }

        .bg-error .cbp_tmicon {
            background-color: red !important;
            color: #ffffff;
        }

        .bg-error h2 strong {
            color: red !important;
        }

        .card {
            border-radius: 1px;
        }
            
        
        .card {
            border: none;
            margin-bottom: 24px;
            -webkit-box-shadow: 0 0 13px 0 rgba(236, 236, 241, .44);
            box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
        }
    </style>
@endpush
