@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <form id="form_update" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="card small-card">
            <div class="card-header">
                <h2 class="card-title">{{ $page_title }}</h2>
            </div>
            <div class="card-body">
                <div class="alert alert-light-success" role="alert">
                    {{ __('messages.Corresponding_Files') }}
                    <br>
                    <b>{{ __('messages.Recommended_Backup_Files') }}</b>
                </div>
                
                <div class="form-group mb-3">
                    <label>Update_[version].zip </label>
                    <input class="form-control" type="file" name="update_file" id="update_file" accept=".zip" required>
                </div>
                
                <div class="form-group mb-3">
                    <div style="display: none" class="progress progress-md  mb-4 up-progress" id="progress_div">
                        <div class="progress-bar bg-success" role="progressbar" id='bar' aria-valuemin="0"
                            aria-valuemax="100">
                            <div class='up-percent' id='percent'>0%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-block">@lang('messages.Update')</button>
            </div>
        </div>

    </form>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('#form_update').submit(function(e) {
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
                var formData = new FormData(this);
                var bar = $('#bar');
                var percent = $('#percent');
                $.ajax({
                    beforeSend: function() {
                        document.getElementById("progress_div").style.display = "block";
                        var percentVal = '0%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                    },
                    type: "POST",
                    url: "{{ route('dashboard.system.update') }}",
                    data: formData,
                    success: function(data) {
                        var percentVal = '100%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                        $('#update_file').val("");
                    },
                    complete: function(xhr) {
                       
                        var json_data = $.trim(xhr.responseText);
                        var data = $.parseJSON(json_data);

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

                        if (data.result == 'success') {
                            $('#progress_div').hide();
                            //success
                            Toastify({
                                text: '<span class="fa fa-check-circle"></span> ' +
                                    data.messages,
                                duration: 10000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "#4fbe87",
                            }).showToast();

                        } else if (data.result == 'errors') {
                            $('#progress_div').hide();

                            $.each(data.messages, function(i, item) {
                                Toastify({
                                    text: '<span class="fa fa-times-circle"></span> ' +
                                        data.messages[i],
                                    duration: 10000,
                                    close: true,
                                    gravity: "top",
                                    position: "center",
                                    backgroundColor: "red",
                                }).showToast();
                            });

                        } else {

                            $('#progress_div').hide();
                            Toastify({
                                text: data.messages,
                                duration: 10000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "red",
                            }).showToast();

                        }

                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: error_data
                });
            });
        });
    </script>
@endpush
