@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div id="user-list">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">{{ $page_title }}</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a class="btn btn-primary add-btn" href="{{ route('dashboard.users.add') }}">
                                    <i class="bi bi-plus-circle align-baseline me-1"></i> @lang('messages.Add_New')
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--  Users List -->
                        <div class="table-responsive  users-list">
                            <table
                                class="table list-table table-nowrap align-middle table-borderless table-collapsed table-nowrap"
                                id="table1">
                                <thead>
                                    <tr>
                                    <tr class="text-uppercase">
                                        <th>@lang('ID')</th>
                                        <th></th>
                                        <th>@lang('messages.Username')</th>
                                        <th>@lang('messages.Contacts')</th>
                                        <th>@lang('messages.Role')</th>
                                        <th>@lang('messages.Status')</th>
                                        <th>@lang('messages.Action')</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- // Users List -->
                    </div>
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
                    url: "{{ asset(get_theme_dir('plugins')) }}/datatables/{{ LaravelLocalization::getCurrentLocale() }}.json"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.users.datatable', ['user_type' => $user_type]) }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'avatar',
                        name: 'avatar'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'firstname',
                        name: 'firstname'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
