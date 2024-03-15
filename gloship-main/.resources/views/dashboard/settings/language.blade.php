@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    {{-- Default Language Form --}}
    <form id="setlocale" data-action="{{ route('dashboard.languages.setlocale') }}" method="post">
        @csrf
        @method('POST')
        <div class="form-body-section">
            <div>
                {{-- Default Language Settings --}}
                @include(get_theme_dir('settings.sections.language.language', 'dashboard'))
                {{-- // Default Language Settings --}}
            </div>
        </div>
    </form>
    {{-- // Default Language Form --}}
    <div class="card">
        <div class="card-header">
            <h4 class="fw-bolder"> @lang('messages.Supported_Languages') </h4>
            <div class="float-right">
                <a class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#lang-create" href="#">
                    <ion-icon name="add-outline"></ion-icon> @lang('messages.Add_Language')
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Language List -->
            <div class="table-responsive language-list">
                <table class="table project-table table-centered table-nowrap" id="table1">
                    <thead>
                        <tr class="text-uppercase">
                            <th>@lang('messages.Name')</th>
                            <th>@lang('messages.Code')</th>
                            <th>@lang('messages.Native_Name')</th>
                            <th>@lang('messages.Status')</th>
                            <th>@lang('messages.Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($languages as $lang)
                            <tr>
                                <td>
                                    <span class="fi fi-{{ $lang->flag_code }}"></span>
                                    {{ $lang->name }}
                                </td>
                                <td class="">{{ $lang->code }} </td>
                                <td>{{ $lang->native }} </td>
                                <td>
                                    <div class="badges">
                                        <span
                                            class="badge bg-{{ get_status_color($lang->status) }} font-12">{{ get_status('', $lang->status) }}</span>
                                    </div>
                                </td>
                                <td>
                                    {{-- Action: url --}}

                                    {{-- a: Edit --}}
                                    <a data-bs-toggle="modal" class="btn btn-sm btn-outline-primary m-1"
                                        data-bs-target="#lang-edit-{{ $lang->id }}" href="#{{ $lang->id }}">
                                        <i class='fa fa-edit'></i> @lang('messages.Edit')
                                    </a>

                                    {{-- a: Delete --}}
                                    -
                                    <a data-bs-toggle="modal" class="btn btn-sm btn-outline-primary m-1"
                                        data-bs-target="#lang-delete-{{ $lang->id }}" href="#{{ $lang->id }}">
                                        <i class='fa fa-trash'></i> @lang('messages.Delete')
                                    </a>
                                    {{-- // Action: url --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- //Language List -->
        </div>
        <!--  //.card -->
    </div>
    {{-- // Default Language Form --}}

    {{-- Language edit modal --}}
    @include(get_theme_dir('settings.sections.language.modal', 'dashboard'), [
        'languages' => $languages,
    ])
    {{-- //Language edit modal --}}
@endsection


@push('css')
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets')) }}/dashboard/vendors/simple-datatables/style.css?v1.0">
@endpush

@push('scripts')
    <script src="{{ asset(get_theme_dir('assets')) }}/dashboard/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endpush
@push('css')
    <style>
        .fade:not(.show) {
            opacity: 0;
            display: none;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {

            //start: save data script
            $('#setlocale').submit(function(e) {
                e.preventDefault();

                $form = $(this);
                //show some response on the button
                $('button[type="submit"]', $form).each(function() {
                    $btn = $(this);
                    $btn.prop('type', 'button');
                    $btn.prop('orig_label', $btn.text());
                    $btn.prop('disabled', true);
                    $btn.html(
                        ' <span class="spinner-grow spinner-grow-md mr-05" role="status" aria-hidden="true"></span>'
                    );
                });

                var code = $('select[name="code"]').val();
                //validate input field
                if (code != '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.languages.setlocale') }}",
                        data: $form.serialize(),
                        success: save_data,
                        dataType: 'json',
                        error: function() {
                            Toastify({
                                text: "{{ __('messages.Unable_To_Process') }}",
                                duration: 10000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "red",
                            }).showToast();
                            //reverse the response on the button
                            $('button[type="button"]', $form).each(function() {
                                $btn = $(this);
                                label = $btn.prop('orig_label');
                                if (label) {
                                    $btn.prop('type', 'submit');
                                    $btn.text(label);
                                    $btn.prop('orig_label', '');
                                    $btn.prop('disabled', false);
                                }
                            });
                        }
                    });
                } else {
                    //some required fields are empty 
                    Toastify({
                        text: "{{ __('messages.Fill_Required_Field_First') }}",
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                    //reverse the response on the button
                    $('button[type="button"]', $form).each(function() {
                        $btn = $(this);
                        label = $btn.prop('orig_label');
                        if (label) {
                            $btn.prop('type', 'submit');
                            $btn.text(label);
                            $btn.prop('orig_label', '');
                            $btn.prop('disabled', false);
                        }
                    });
                }
            });
            //end: save data script
        });
    </script>
@endpush
