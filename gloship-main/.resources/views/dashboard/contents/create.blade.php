@php
    
    $post_category = DB::table('categories')
        ->where('status', 1)
        ->get();
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <form id="create_form" data-action="{{ route('dashboard.posts.create', ['type' => $type]) }}" enctype="multipart/form-data"
        method="post">
        @csrf
        @method('POST')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $page_title }}</h3>
            </div>
        </div>
        <div class="row">
            {{-- posts section --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                        {{-- translation tab --}}
                        <ul class="nav nav-tabs mb-3" role="tablist">

                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li class="nav-item" role="presentation">

                                    <button class="nav-link @if ($localeCode == LaravelLocalization::getCurrentLocale()) active @endif"
                                        id="{{ $localeCode }}-tab-a" data-bs-toggle="tab"
                                        data-bs-target="#{{ $localeCode }}-tab" type="button" role="tab"
                                        aria-controls="{{ $localeCode }}-tab"
                                        aria-selected="true">{{ $properties['native'] }}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <div class="tab-pane fade  @if ($localeCode == LaravelLocalization::getCurrentLocale()) show active @endif"
                                    id="{{ $localeCode }}-tab" role="tabpanel" aria-labelledby="{{ $localeCode }}-tab"
                                    tabindex="0">

                                    <div class="form-group mb-3">
                                        <label
                                            class="@if ($localeCode == LaravelLocalization::getCurrentLocale()) required @endif">{{ trans_choice('messages.Title', 1) }}</label>
                                        <input type="text" name="post_title[{{ $localeCode }}]" value=""
                                            class="form-control" @if ($localeCode == LaravelLocalization::getCurrentLocale()) required @endif>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>{{ trans_choice('messages.Content', 2) }}</label>
                                        <textarea id="summernote-{{ $localeCode }}" class="form-control" style="height: 300px"
                                            name="post_content[{{ $localeCode }}]"></textarea>
                                    </div>
                                    <hr>
                                    <div class="form-group mb-3">
                                        <label class="optional">{{ trans_choice('messages.Description', 2) }}</label>
                                        <textarea class="form-control" name="post_excerpt[{{ $localeCode }}]"></textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- / posts section --}}

            {{-- posts settings section --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans_choice('messages.Setting', 1) }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group  mb-3">
                            <label>{{ trans_choice('messages.Status', 1) }}</label>
                            <select class="form-control custom-select" name="post_status">
                                <option value="1">{{ trans_choice('messages.Publish', 2) }}</option>
                                <option value="2">{{ trans_choice('messages.Draft', 1) }}</option>

                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">{{ trans_choice('messages.Featured_Image', 1) }} </label>
                            <input name="featured_image" type="file" id="post_img" class="for"
                                accept="image/*">
                            <div class="mt-3" id="image_preview"></div>
                            <div class="col-lg-12 text-center mt-3" id="preview_file_div">
                                <ul></ul>
                            </div>

                            {{-- <div style="display: none" class="progress progress-md  mb-4 up-progress" id="progress_div">
                                <div class="progress-bar bg-success" role="progressbar" id='bar' aria-valuemin="0"
                                    aria-valuemax="100">
                                    <div class='up-percent' id='percent'>0%</div>
                                </div>
                            </div> --}}
                        </div>

                        @if ($type == 'blog')
                            <div class="form-group mb-3">
                                <label>{{ trans_choice('messages.Category', 1) }}</label>
                                <select name="post_cat[]" class="form-select post_cat" id="post_cat" multiple="multiple"
                                    style="width: 100%;">
                                </select>
                            </div>

                            {{-- new category section --}}
                            <div class="mt-4" id="category_section ">
                                <div class="button-add-new mb-4">
                                    <button type="button" class="btn btn-sm btn-light-primary btn_new_category">
                                        <i class="fas fa-plus fa-fw mx-1"></i>
                                        {{ trans_choice('messages.Add_Category', 1) }}
                                    </button>
                                </div>

                                <div id="new_cat_form" class="p-3 border" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label class="mb-3 required">{{ trans_choice('messages.Name', 1) }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="category_name" name="category_name"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label
                                            class="mb-2 optional">{{ trans_choice('messages.Choose_Category', 2) }}</label>
                                        <select name="category_parent" id="new_category" class="form-select post_cat">
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <button id="add_new_category" type="button" class="btn btn-sm btn-primary">
                                            {{ trans_choice('messages.Add', 1) }}
                                        </button>
                                    </div>
                                </div>

                            </div>
                            {{-- / new category section --}}
                        @endif

                    </div>
                </div>
            </div>
            {{-- / posts settings section --}}
        </div>

        {{-- posts action section --}}
        <div class="col-md-12">
            <div class="card-footer  d-flex justify-content-end py-6 px-9">
                <a href="{{ url()->previous() }}"
                    class="btn btn-light btn-active-light-primary me-2">@lang('messages.Back')</a>
                <button  id="save_post" type="submit" class="btn btn-success ml-1" onclick="needToConfirm = false;">
                    <span class="save">@lang('messages.Save_Change')</span>
                </button>
            </div>
        </div>
        {{-- / posts action section --}}
    </form>
@endsection
@push('css')
    <link href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/summernote/summernote-lite.css"
        rel="stylesheet" />
@endpush
@push('scripts')
    {{-- Page scripts --}}
   
    <script type="text/javascript"
        src="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/summernote/summernote-lite.min.js"></script>
    <script>
        
        //summernote editor
        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            $('#summernote-{{ $localeCode }}').summernote({
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['table', ['table']],
                ]
            })
        @endforeach

        //need to confirm
        var needToConfirm = true;
        window.onbeforeunload = confirmExit;

        function confirmExit() {
            if (needToConfirm)
                return "@lang('messages.Changes_Unsaved')";
        }

        //Category helper
        $(document).ready(function() {
            $(".post_cat").select2({
                language: '{{ LaravelLocalization::getCurrentLocale() }}',
                ajax: {
                    url: "{{ route('dashboard.posts.category.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            q: params.term,
                            //type: 'public'
                        }
                        return query;
                    },

                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: json_locale(item.name),
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
                placeholder: "{{ trans_choice('messages.Choose_Category', 1) }}",
                minimumInputLength: 0,
                allowClear: true
            }).on('change', function(e) {
                //
            });

            //add new category
            var new_category = $('.btn_new_category');
            new_category.on('click', function() {
                $('#new_cat_form').toggle(300);
            });

            $('#add_new_category').click(function(e) {
                $form = $(this)
                var category_name = $('input[id="category_name"]').val();
                var category_parent = $('select[name="category_parent"]').val();

                var post_data = {
                    _token: '{{ csrf_token() }}',
                    quick_add: '1',
                    category_name: category_name,
                    category_parent: category_parent
                };
                //show some response on the button
                $btn = $('button[id="add_new_category"]');
                $btn.prop('type', 'submit');
                $btn.prop('orig_label', $btn.text());
                $btn.prop('disabled', true);
                $btn.html(
                    '<span class="spinner-grow spinner-grow-md mr-05" role="status" aria-hidden="true"></span>'
                );
                $.ajax({
                    type: "POST",
                    url: '{{ route('dashboard.posts.category.create') }}',
                    data: post_data,
                    success: save_category,
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
                        $btn = $('button[id="add_new_category"]');
                        label = $btn.prop('orig_label');
                        if (label) {
                            $btn.prop('type', 'submit');
                            $btn.text(label);
                            $btn.prop('orig_label', '');
                            $btn.prop('disabled', false);
                        }
                    }
                });

            });
            //end: add new category

            /**
             * Save category data.
             * 
             * @param data
             * @return data
             */
            function save_category(data) {

                $btn = $('button[id="add_new_category"]');
                if (data.result == 'success') {
                    $('#new_cat_form').hide();
                    //reverse the response on the button
                    label = $btn.prop('orig_label');
                    if (label) {
                        $btn.prop('type', 'submit');
                        $btn.text(label);
                        $btn.prop('orig_label', '');
                        $btn.prop('disabled', false);
                    }
                    Toastify({
                        text: '<span class="fa fa-check-circle"></span> ' + data.messages,
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#4fbe87",
                    }).showToast();

                } else if (data.result == 'errors') {

                    $.each(data.messages, function(i, item) {
                        Toastify({
                            text: '<span class="fa fa-times-circle"></span> ' + data.messages[i],
                            duration: 10000,
                            close: true,
                            gravity: "top",
                            position: "center",
                            backgroundColor: "red",
                        }).showToast();
                    });


                    //reverse the response on the button
                    label = $btn.prop('orig_label');
                    if (label) {
                        $btn.prop('type', 'submit');
                        $btn.text(label);
                        $btn.prop('orig_label', '');
                        $btn.prop('disabled', false);
                    }
                } else {

                    Toastify({
                        text: '<span class="fa fa-times-circle"></span> ' + data.messages,
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();


                    //reverse the response on the button
                    label = $btn.prop('orig_label');
                    if (label) {
                        $btn.prop('type', 'submit');
                        $btn.text(label);
                        $btn.prop('orig_label', '');
                        $btn.prop('disabled', false);
                    }
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {

            $("#post_img").change(function() {
                $('#image_preview').html("");
                var post_file = document.getElementById("post_img").files.length;
                for (var i = 0; i < post_file; i++) {
                    $('#image_preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) +
                        "' class='img-fluid' style='width:100%'>");
                }
            });
            //start: save data script
            $('#create_form').submit(function(e) {
                e.preventDefault();

                $form = $(this);
                var formData = new FormData(this);
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

                var bar = $('#bar');
                var percent = $('#percent');
                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.posts.create', ['type' => $type]) }}",
                    data: formData,
                    success: function(data) {
                        var percentVal = '100%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                    },
                    complete: function(xhr) {
                        var json_data = $.trim(xhr.responseText);
                        var data = $.parseJSON(json_data);
                        if (data.result == 'success') {

                            //success
                            $('#progress_div').hide();
                            //redirect page
                            $(location).attr('href', data.redirect_url);

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

                        } else if (data.result == 'errors') {

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
                        } else {

                            Toastify({
                                text: data.messages,
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

                    },
                    cache: false,
                    contentType: false,
                    processData: false,
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

            });
            //end: save data script
        });
    </script>
@endpush
