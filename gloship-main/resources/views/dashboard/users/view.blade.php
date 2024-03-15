@php
    $addresses = DB::table('addresses')
        ->where('owner_id', $user->id)
        ->get();
    $role = $user->role;
    $avatar_char1 = substr($user->firstname, 0, 1);
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    {{-- .s-view --}}
    <div class="s-view mb-5 mb-xl-10">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        @if ($user->avatar)
                            <div class="avatar avatar-xlx me-3 bg-rgba-primary m-0 me-50">
                                <img src="{{ asset($user->avatar) }}" class="avatar-lg rounded-circle p-1 img-thumbnail" alt="" srcset="">
                               
                            </div>
                        @else
                            <div class="avatar-lg xrounded-circle p-1 img-thumbnail">
                                <span class="avatar-sm">
                                    <span class="avatar-title bg-light rounded text-body fs-4">
                                        <i class="bi bi-person"></i>
                                    </span>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card-title mt-3">
                            <h3 class="fw-bolder m-0">
                                {{ __('messages.Profile') }} : {{ $user->firstname }} {{ $user->lastname }}
                                <small class="btn btn-sm btn-{{ get_status_color($user->status) }}">
                                    <span class="">{{ get_status('', $user->status) }}
                                </small>
                            </h3>
                            <span class="text-muted">
                                <ion-icon name="person-outline" class="icon"></ion-icon>
                                @php
                                    if ($role == 5) {
                                        echo trans_choice('messages.Admin', 1) . ' <span class="fa fa-check-circle text-warning"></span>';
                                    }
                                    if ($role == 4) {
                                        echo trans_choice('messages.Moderator', 1) . ' <span class="fa fa-check-circle text-primary"></span>';
                                    }
                                    if ($role == 3) {
                                        echo trans_choice('messages.Staff', 1);
                                    }
                                    if ($role == 2) {
                                        echo trans_choice('messages.Delivery_Agent', 1);
                                    }
                                    if ($role == 1) {
                                        echo trans_choice('messages.Customer', 1);
                                    }
                                @endphp

                            </span>
                        </div>

                        {{-- Quick Actions Tools --}}
                        <div class="card-tool mt-2">
                            @can('do_customer')
                                {{-- action: Edit --}}
                                <a class="btn btn-sm btn-outline-primary m-1"
                                    href="{{ route('dashboard.users.edit', ['id' => $user->id]) }}">
                                    <ion-icon name="create-outline"></ion-icon> @lang('messages.Edit')
                                </a>
                            @endcan

                            @can('do_staff')
                                {{-- action: Message --}}
                                {{-- <a class="btn btn-sm btn-outline-success m-1"
                                    href="{{ route('dashboard.users.message', ['id' => $user->id]) }}">
                                    <ion-icon name="mail-outline"></ion-icon> @lang('messages.Message')
                                </a> --}}
                            @endcan

                            @can('do_staff')
                                {{-- action: Call --}}
                                <a class="btn btn-sm btn-outline-secondary m-1" href="tel:{{ $user->phone }}">
                                    <ion-icon name="call-outline"></ion-icon> @lang('messages.Call')
                                </a>
                            @endcan

                            @can('do_moderator')
                                {{-- action: Delete --}}
                                <a class="btn btn-sm btn-outline-danger m-1"
                                    href="{{ route('dashboard.users.delete', ['id' => $user->id]) }}">
                                    <ion-icon name="trash-outline"></ion-icon> @lang('messages.Delete')
                                </a>
                            @endcan
                        </div>
                        {{-- // Quick Actions Tools --}}

                    </div>
                </div>
            </div>
        </div>

        {{-- User Info --}}
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <h4 class="card-label text-uppercase">@lang('messages.Details')</h4>
                    <hr>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.User_Type') }}</strong></h6>
                            <p class="text-muted">
                                @php
                                    if ($role == 5) {
                                        echo trans_choice('messages.Admin', 1);
                                    }
                                    if ($role == 4) {
                                        echo trans_choice('messages.Moderator', 1);
                                    }
                                    if ($role == 3) {
                                        echo trans_choice('messages.Staff', 1);
                                    }
                                    if ($role == 2) {
                                        echo trans_choice('messages.Delivery_Agent', 1);
                                    }
                                    if ($role == 1) {
                                        echo trans_choice('messages.Customer', 1);
                                    }
                                @endphp

                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Username') }}</strong></h6>
                            <p class="text-muted">{{ $user->username }}</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Name') }}</strong></h6>
                            <p class="text-muted">{{ $user->firstname }} {{ $user->lastname }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Phone') }}</strong></h6>
                            <p class="text-muted">
                                {{ $user->phone }}
                                @if ($user->phone_status == 1)
                                    <span class="fa fa-check-circle text-primary"></span>
                                @else
                                    <a id="phone_status" class="m-1" data-bs-toggle="modal" data-bs-target="#phone_verify" href="#">
                                        @lang('messages.Verify')
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Email') }}</strong></h6>
                            <p class="text-muted">
                                {{ $user->email }}
                                @if ($user->email_status == 1)
                                    <span class="fa fa-check-circle text-primary"></span>
                                @else
                                    <a id="email_status" class="m-1">
                                        @lang('messages.Verify')
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.Branch', 1) }}</strong></h6>
                            <p class="text-muted">{{ get_dataBy_id($user->branch, 'branches', 'name') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ trans_choice('messages.Country', 1) }}</strong></h6>
                            <p class="text-muted">{{ country_name($user->country) }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Registered') }}</strong></h6>
                            <p class="text-muted">
                                <x-date-time-zone :date="\Carbon\Carbon::parse($user->created_at)" format="Y-m-d H:i A" />
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong>{{ __('messages.Last_Login') }}</strong></h6>
                            <p class="text-muted">
                                <x-date-time-zone :date="\Carbon\Carbon::parse($user->last_login)" format="Y-m-d H:i A" />
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- User Shipment --}}
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="flex-grow-1">
                    <h5 class="card-title mb-0">{{ __('messages.Shipment_List') }}</h5>
                </div>
                <div class="flex-shrink-0">
                    <div class="d-flex flex-wrap align-items-start gap-2">
                        <a class="btn btn-primary add-btn" href="{{ route('dashboard.shipments.create', ['id' => $user->id]) }}">
                            <i class="bi bi-plus-circle align-baseline me-1"></i> @lang('messages.Add_New')
                        </a>
                    </div>
                </div>
            </div>
           
            <div class="card-body">
                <div class="table-responsive list-shipment">
                    <table class="table" id="user_shipment">
                        <thead>
                            <tr class="text-uppercase">
                                <th>@lang('messages.Tracking_Number')</th>
                                <th>@lang('messages.Status')</th>
                                <th>@lang('messages.Sender')</th>
                                <th>@lang('messages.Receiver')</th>
                                <th>@lang('messages.Origin')</th>
                                <th>@lang('messages.Destination')</th>
                                <th>@lang('messages.Created')</th>
                                <th>@lang('messages.Action')</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- User Address --}}
        <div class="card">
            
            <div class="card-header d-flex align-items-center">
                <div class="flex-grow-1">
                    <h5 class="card-title mb-0"> @lang('messages.Address_Book')</h5>
                </div>
                <div class="flex-shrink-0">
                    <div class="d-flex flex-wrap align-items-start gap-2">
                        <a class="btn btn-primary add-btn" href="{{ route('dashboard.address.add', ['id' => $user->id]) }}">
                            <i class="bi bi-plus-circle align-baseline me-1"></i> @lang('messages.Add_New')
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive covered addresses-list">
                    <table class="table list-table table-nowrap align-middle table-borderless table-collapsed table-nowrap"
                        id="user_address">
                        <thead>

                            <tr class="text-uppercase">
                                <th>@lang('messages.Address_Type')</th>
                                <th width="50%">{{ trans_choice('messages.Address', 1) }}</th>
                                <th>@lang('messages.Created')</th>
                                <th>@lang('messages.Action')</th>
                            </tr>

                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    {{-- // .s-view --}}

    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="phone_verify" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="phone_verify" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <form id="phone_verify_form" method="post">
                    @method('POST')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title text-center">{{ trans_choice('messages.Verification', 1) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>@lang('messages.Phone'): {{ $user->phone }}</p>
                        <p id="send_code"><a id="send_code_link" class="btn btn-info">@lang('messages.Send_Code')</a></p>
                        <div style="display: none;" id="code_input" class="form-group m-2">
                            <p>@lang('messages.Verify_Phone_Code')</p>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-c" data-bs-dismiss="modal">@lang('messages.Cancel')</button>
                        <button id="code_btn" type="submit" class="btn btn-primary"
                            style="display: none;">@lang('messages.Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .s-view .avatar.avatar-xlx img {
            width: 100px;
            height: 100px;
        }

        .profile-img {
            border-radius: 50% !important;
        }

        table:not(.table-sm) thead th {
            border-bottom: none;
            background-color: #e9e9eb;
            color: #666;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .list-table {
            border-collapse: separate;
            border-spacing: 0 12px
        }

        .list-table tr {
            background-color: #fff
        }

        .table-nowrap td,
        .table-nowrap th {
            white-space: nowrap;
        }

        .table-borderless>:not(caption)>*>* {
            border-bottom-width: 0;
        }

        .table>:not(caption)>*>* {
            padding: 0.75rem 0.75rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }
    </style>

    <link href="{{ asset(get_theme_dir('plugins')) }}/datatables/dataTables.bootstrap5.min.css" rel="stylesheet">
    </head>
@endpush
@push('scripts')
    <script src="{{ asset(get_theme_dir('plugins')) }}/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset(get_theme_dir('plugins')) }}/datatables/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(function() {

            //Verification
            //emall
            $('#email_status').click(function(e) {
                $('#email_status').hide();
                var post_data = {
                    send_code: 1,
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    type: "POST",
                    url: '{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'verify']) }}',
                    data: post_data,
                    success: save_data,
                    dataType: 'json',

                });
            });

            // phone
            $('#send_code_link').click(function(e) {
                $('#send_code').hide();
                $('#code_input').show();
                $('#code_btn').show();


                var post_data = {
                    send_code: 2,
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    type: "POST",
                    url: '{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'verify']) }}',
                    data: post_data,
                    success: true,
                    dataType: 'json',

                });
            });
            $('#phone_verify_form').submit(function(e) {
                e.preventDefault();

                var code = $('input[name="code"]').val();
                var post_data = {
                    code: code,
                    _token: '{{ csrf_token() }}'
                };
                //show some response on the button

                $('#code_btn').html(
                    '<span class="spinner-grow spinner-grow-md mr-05" role="status" aria-hidden="true"></span>'
                );
                $.ajax({
                    type: "POST",
                    url: '{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'verify']) }}',
                    data: post_data,
                    success: function(data) {

                        if (data.result == 'success') {

                            //success
                            $('#phone_verify').hide();
                            $('#phone_status').html('<span class="fa fa-check-circle text-primary"></span>');
                            Toastify({
                                text: '<span class="fa fa-check-circle"></span> ' + data
                                    .messages,
                                duration: 10000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "#4fbe87",
                            }).showToast();
                        }
                        else {
                            //error
                            Toastify({
                                text: '<span class="fa fa-times-circle"></span> ' + data
                                    .messages,
                                duration: 10000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "red",
                            }).showToast();
                        }
                        //reverse the response on the button
                        $('#code_btn').html('{{ __('messages.Verify') }}');

                    },
                    dataType: 'json',
                    error: error_data
                });
            });


            //User Shipments
            var table = $('#user_shipment').DataTable({
                language: {
                    url: "{{ asset(get_theme_dir('plugins')) }}/datatables/{{ LaravelLocalization::getCurrentLocale() }}.json"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.shipments.datatable', ['type' => 'user', 'id' => $user->id]) }}",
                columns: [{
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'sender_name',
                        name: 'sender_name'
                    },
                    {
                        data: 'receiver_name',
                        name: 'receiver_name'
                    },
                    {
                        data: 'sender_country',
                        name: 'sender_country'
                    },
                    {
                        data: 'receiver_country',
                        name: 'receiver_country'
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
            //User address book
            var table = $('#user_address').DataTable({
                language: {
                    url: "{{ asset(get_theme_dir('plugins')) }}/datatables/{{ LaravelLocalization::getCurrentLocale() }}.json"
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.address.datatable', ['type' => 'user', 'id' => $user->id]) }}",
                columns: [{
                        data: 'address_type',
                        name: 'address_type'
                    },
                    {
                        data: 'address',
                        name: 'address'
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
