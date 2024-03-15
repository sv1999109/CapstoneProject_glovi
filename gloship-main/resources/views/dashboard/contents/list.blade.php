@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div id="area-list">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h4 class="fw-bolder"> {{ $page_title }} </h4>
                        <div class="float-right">
                            <a class="btn btn-primary m-1"
                                href="{{ route('dashboard.posts.add', ['type'=> $type]) }}">
                                <ion-icon name="add-outline"></ion-icon> @lang('messages.Add_New')
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Location List -->
                        <div class="table-responsive location-list">
                            <table class="table list-table align-middle table-borderless" id="table1">
                                <thead>
                                    <tr>
                                    <tr class="text-uppercase">
                                        <th>@lang('messages.ID')</th>
                                        <th>@lang('messages.Title')</th>
                                        <th>@lang('messages.Status')</th>
                                        @if ($type == 'blog')
                                        <th>{{ trans_choice('messages.View', 2) }}</th>
                                        @endif
                                        <th>@lang('messages.Author')</th>
                                        <th>@lang('messages.Created')</th>
                                        <th>@lang('messages.Action')</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- //Location List -->
                    </div>
                    <!--  //.card -->
                </div>

            </div>
        </div>
    </div>
@endsection
@push('css')
    <link href="{{ asset(get_theme_dir('plugins')) }}/datatables/dataTables.bootstrap5.min.css" rel="stylesheet">
    </head>
@endpush

@push('scripts')
    <script src="{{ asset(get_theme_dir('plugins')) }}/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset(get_theme_dir('plugins')) }}/datatables/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('.table').DataTable({
                language: {
                    url: "{{ asset(get_theme_dir('plugins')) }}/datatables/{{LaravelLocalization::getCurrentLocale()}}.json"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.posts.datatable', ['type' => $type]) }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'post_title',
                        name: 'post_title'
                    }, 
                    {
                        data: 'post_status',
                        name: 'post_status'
                    },
                    @if ($type == 'blog')
                    {
                        data: 'post_view',
                        name: 'post_view'
                    },
                    @endif
                    {
                        data: 'post_author',
                        name: 'post_author'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
@endpush
