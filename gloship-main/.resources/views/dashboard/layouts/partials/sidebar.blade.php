@php
    //settings
    $user_lang = LaravelLocalization::getCurrentLocale();
    $user = Auth()->user();
    $role = Auth()->user()->role;
    $owner = Auth()->user()->id;
@endphp
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
       
        <a href="{{ route('dashboard.index') }}" class="logo logo-light">
            <span class="logo-sm">
                {{-- @if (get_theme_config('site_logo_dashboard') == 'enabled')
                    <img src="{{ asset(get_contents_admin('logo_dashboard', '', 'all')) }}?v"
                        alt="{{ get_content_locale(get_config('site_name')) }}" class="sidebar-logo" height="22">
                @endif --}}
            </span>
            <span class="logo-lg">
                @if (get_theme_config('site_logo_dashboard') == 'enabled')
                    <img src="{{ asset(get_contents_admin('logo_dashboard', '', 'all')) }}"
                        alt="{{ get_content_locale(get_config('site_name')) }}" height="22">
                @endif
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <!-- End LOGO-->

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link menu-link  {{ menu_active('dashboard.index') }}"> <i class="ph-gauge"></i> <span
                            data-key="t-calendar">@lang('messages.Dashboard')</span> </a>
                </li>


                @if (Auth()->user()->role != 2)
                    <li class="nav-item">
                        <a href="{{ route('dashboard.shipments.create') }}"
                            class="nav-link menu-link  {{ menu_active('dashboard.shipments.create') }}">
                            <i class="ph-folder-plus-thin"></i>
                            <span>@lang('messages.Create_Shipment')</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('dashboard.shipments.filter', ['status' => 'status', 's' => '0']) }}"
                        class="nav-link menu-link">
                        <i class="ph-alarm-thin"></i>
                        <span>{{ trans_choice('messages.Pending', 2) }}</span>
                        @if ($role == 1)
                            <span class="badge badge-pill bg-danger" data-key="t-hot">
                                {{ DB::table('shipments')->whereRaw("status = 0 AND owner_id = '$owner'")->count() }}
                            </span>
                        @elseif($role > 3)
                            <span class="badge badge-pill bg-danger" data-key="t-hot">
                                {{ DB::table('shipments')->whereRaw('status = 0')->count() }} </span>
                        @endif
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('dashboard.shipments') }}"
                        class="nav-link menu-link {{ menu_active('dashboard.shipments') }} {{ @$s != 0 ? 'active' : '' }}">
                        <i class="ph-airplane-tilt-thin"></i>
                        <span>@lang('messages.Manage_Shipment')</span>
                    </a>
                </li>

                @if (Auth()->user()->role != 2)
                    <li class="menu-title"><i class="ri-more-fill"></i> <span
                            data-key="t-apps">{{ trans_choice('messages.Customer', 2) }}</span></li>

                    @can('do_customer')
                        <li class="nav-item ">
                            <a href="{{ route('dashboard.address') }}"
                                class="nav-link menu-link {{ menu_active('dashboard.address') }}">
                                <i class="ph-address-book-thin"></i>
                                <span>@lang('messages.Address_Book')</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.shipments.invoices') }}"
                                class="nav-link menu-link  {{ menu_active('dashboard.shipments.invoices') }}">
                                <i class="ph-file-text"></i>
                                <span>{{ trans_choice('messages.Manage_Invoice', 2) }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.transactions') }}"
                                class="nav-link menu-link {{ menu_active('dashboard.transactions') }}">
                                <i class="ph-file-text"></i>
                                <span>{{ trans_choice('messages.Payment', 2) }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('do_staff')
                        <li class="menu-title"><i class="ri-more-fill"></i> <span
                                data-key="t-apps">{{ trans_choice('messages.Tool', 2) }}</span></li>
                    @endcan
                @endif

                @can('do_moderator')
                    <li class="nav-item ">
                        <a href="#Location"
                            class="nav-link menu-link collapsed {{ menu_active('dashboard.location.list') }}"
                            data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Location">
                            <i class="ph-storefront"></i> <span
                                data-key="t-Location">{{ trans_choice('messages.Location', 2) }}</span>
                        </a>
                        <div class="collapse menu-dropdown" id="Location">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link  {{ menu_active('dashboard.areas', 2) }}"
                                        href="{{ route('dashboard.areas') }}">
                                        {{ trans_choice('messages.Area', 2) }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  {{ menu_active('dashboard.branches') }}" data-key="t-Branches"
                                        href="{{ route('dashboard.branches') }}">
                                        <span>{{ trans_choice('messages.Branch', 2) }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ menu_active('dashboard.location.list', ['type' => 'cities']) }}"
                                        data-key="t-City"
                                        href="{{ route('dashboard.location.list', ['type' => 'cities']) }}">{{ trans_choice('messages.City', 2) }}</a>
                                </li>
                                <li class="nav-item {{ menu_active('dashboard.location.list', ['type' => 'countries']) }}">
                                    <a class="nav-link" data-key="t-countries"
                                        href="{{ route('dashboard.location.list', ['type' => 'countries']) }}">{{ trans_choice('messages.Country', 2) }}</a>
                                </li>
                                <li class="nav-item {{ menu_active('dashboard.location.list', ['type' => 'states']) }}">
                                    <a class="nav-link" data-key="t-City"
                                        href="{{ route('dashboard.location.list', ['type' => 'states']) }}">{{ trans_choice('messages.State', 2) }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('do_staff')
                    <li class="nav-item">
                        <a href="#UserN" class="nav-link menu-link {{ menu_active('dashboard.users') }} collapsed"
                            data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="UserN">
                            <i class="ph-user-circle"></i>
                            <span data-key="t-User">{{ trans_choice('messages.User', 2) }}</span>
                        </a>
                        <div class="collapse menu-dropdown" id="UserN">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ menu_active('dashboard.users') }}">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.users', ['user_type' => 1]) }}">{{ trans_choice('messages.Customer', 2) }}</a>
                                </li>
                                @can('do_moderator')
                                    <li class="nav-item {{ menu_active('dashboard.users') }}">
                                        <a class="nav-link"
                                            href="{{ route('dashboard.users', ['user_type' => 2]) }}">{{ trans_choice('messages.Delivery_Agent', 2) }}</a>
                                    </li>
                                    <li class="nav-item {{ menu_active('dashboard.users') }}">
                                        <a class="nav-link"
                                            href="{{ route('dashboard.users', ['user_type' => 3]) }}">{{ trans_choice('messages.Staff', 2) }}</a>
                                    </li>
                                @endcan
                                @can('do_admin')
                                    <li class="nav-item {{ menu_active('dashboard.users') }}">
                                        <a class="nav-link"
                                            href="{{ route('dashboard.users', ['user_type' => 4]) }}">{{ trans_choice('messages.Moderator', 2) }}</a>
                                    </li>
                                    <li class="nav-item {{ menu_active('dashboard.users', ['user_type' => 1]) }}">
                                        <a class="nav-link"
                                            href="{{ route('dashboard.users', ['user_type' => 5]) }}">{{ trans_choice('messages.Administrator', 2) }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('do_moderator')
                    <li class="nav-item  {{ menu_active('dashboard.settings.shipments') }}">
                        <a href="#ShipmentN" class="nav-link menu-link collapsed" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="ShipmentN">
                            <i class="ph-truck-thin"></i>
                            <span>{{ trans_choice('messages.Shipment', 1) }}</span>
                        </a>
                        <div class="collapse menu-dropdown" id="ShipmentN">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ menu_active('dashboard.shipments.settings') }}">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.shipments.settings') }}">@lang('messages.Shipment_Settings')</a>
                                </li>
                                <li class="nav-item {{ menu_active('dashboard.shipments.cost') }}">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.shipments.cost') }}">@lang('messages.Shipping_Cost')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('do_admin')
                    <li class="nav-item  {{ menu_active('dashboard.settings') }}">
                        <a href="#SettingN" class="nav-link menu-link collapsed" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="SettingN">
                            <i class="ph-wrench"></i>
                            <span>{{ trans_choice('messages.System', 1) }}</span>
                        </a>
                        <div class="collapse menu-dropdown" id="SettingN">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ menu_active('dashboard.settings', ['type' => 'general']) }}">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.settings', ['type' => 'general']) }}">{{ trans_choice('messages.General', 1) }}
                                        {{ trans_choice('messages.Setting', 2) }}</a>
                                </li>
                                <li class="nav-item {{ menu_active('dashboard.currencies') }}">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.currencies') }}">{{ trans_choice('messages.Currency', 2) }}</a>
                                </li>
                                <li class="nav-item {{ menu_active('dashboard.settings.payment') }}">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.settings.payment') }}">{{ trans_choice('messages.Payment_Method', 2) }}</a>
                                </li>
                                <li class="nav-item {{ menu_active('dashboard.settings.languages') }}">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.settings.languages') }}">{{ trans_choice('messages.Language', 2) }}</a>
                                </li>
                                <li class="nav-item {{ menu_active('dashboard.settings.themes') }}">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.settings.themes') }}">{{ trans_choice('messages.Theme', 2) }}
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ menu_active('dashboard.settings.themes.option', ['slug' => 'homepage']) }}">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.settings.themes.option', ['slug' => 'homepage']) }}">
                                        @lang('messages.Theme_Setting')
                                    </a>
                                </li>
                                <li class="nav-item {{ menu_active('dashboard.settings', ['type' => 'system']) }}">
                                    <a class="nav-link" href="{{ route('dashboard.settings', ['type' => 'system']) }}">
                                        {{ trans_choice('messages.System_Info', 1) }} </a>
                                </li>
                                <li class="nav-item {{ menu_active('dashboard.settings', ['type' => 'update']) }}">
                                    <a class="nav-link" href="{{ route('dashboard.settings', ['type' => 'update']) }}">
                                        {{ trans_choice('messages.Update_System', 1) }} </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('do_moderator')
                    <li class="nav-item  {{ menu_active('dashboard.posts') }}">
                        <a href="#PostN" class="nav-link menu-link collapsed" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="PostN">
                            <i class="ri-file-list-3-line"></i>
                            <span>{{ trans_choice('messages.Post', 2) }}</span>
                        </a>
                        <div class="collapse menu-dropdown" id="PostN">
                            <ul class="nav nav-sm flex-column">
                                @php
                                    $list = get_contents_list();
                                @endphp
                                @foreach ($list as $key => $item)
                                    @php
                                        $trans_val = ucfirst($item);
                                    @endphp
                                    <li class="nav-item {{ route('dashboard.posts', ['type' => $item]) }}">
                                        <a class="nav-link"
                                            href="{{ route('dashboard.posts', ['type' => $item]) }}">{{ trans_choice("messages.$trans_val", 2) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endcan

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
