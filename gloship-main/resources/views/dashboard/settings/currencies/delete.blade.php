
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="row">
        <div class="col-md-12x">
            <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">@lang('messages.Perform_Action')</h3>
                    </div>
                    <div class="card-body">
                        <h6> {!!  $page_data !!}</h6>
                    </div>
                    <div class="card-footer  py-6 px-9">
                        <a href="{{ route('dashboard.shipments.cost')}}"
                            class="btn btn-light btn-active-light-primary me-2">@lang('messages.Cancel')</a>

                        <a href="{{ route("dashboard.shipments.cost.delete", ['id' => $model->id, 'confirm' => 1]) }}" class="btn btn-danger ml-1">
                            <span class="save">@lang('messages.Delete')</span>
                        </a>
                    </div>

            </div>
        </div>
    </div>
@endsection
