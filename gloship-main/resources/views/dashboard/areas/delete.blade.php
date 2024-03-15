@php
    $countries = DB::table('countries')->where('status', 1)->distinct()->get();
    $states = DB::table('states')->where('country_id', $area->country_id)->distinct()->get();
    $cities = DB::table('cities')->where('state_id', $area->state_id)->distinct()->get();

@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="row">
        <div class="col-md-12x">
            <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">@lang('messages.Perform_Action')</h3>
                    </div>
                    <div class="card-body">
                        <p> {{ country_name($area->country_id)}}
                            &raquo; {{get_dataBy_id($area->state_id, 'states', 'name')}} 
                            &raquo; {{get_dataBy_id($area->city_id, 'cities', 'name')}}
                            &raquo; <strong>@lang('messages.Delete') {{ trans_choice('messages.Area', 1) }}
                            &raquo;  {{ $area->name}}</strong> </p>
                    </div>
                    <div class="card-footer  py-6 px-9">
                        <a href="{{ route('dashboard.areas')}}"
                            class="btn btn-light btn-active-light-primary me-2">@lang('messages.Cancel')</a>

                        <a href="{{ route("dashboard.address.delete", ['id' => $area->id, 'confirm' => 1]) }}" class="btn btn-danger ml-1">
                            <span class="save">@lang('messages.Delete')</span>
                        </a>
                    </div>

            </div>
        </div>
    </div>
@endsection