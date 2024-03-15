@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('messages.Perform_Action')</h3>
        </div>
        <div class="card-body">
            <h3> {{ $page_title }}</h3>
        </div>
        <div class="card-footer  py-6 px-9">
            <a href="{{ url()->previous() }}"
                class="btn btn-light btn-active-light-primary me-2">@lang('messages.Cancel')</a>

            <a href="{{ route('dashboard.users.delete', ['id' => $model->id, 'confirm' => 1]) }}"
                class="btn btn-danger ml-1">
                <span class="save">@lang('messages.Delete')</span>
            </a>
        </div>

    </div>
@endsection
