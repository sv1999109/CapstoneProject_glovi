{{-- Language  modal --}}
@if (isset($languages))
    @foreach ($languages as $lang)
        {{-- edit --}}
        <div class="modal fade text-left" id="lang-edit-{{ $lang->id }}" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-lg-x modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="{{ route('dashboard.languages.update', ['id' => $lang->id]) }}" class="form"
                        method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="modal" value="lang-edit-{{ $lang->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel110">
                                @lang('messages.Edit') {{ trans_choice('messages.Language', 1) }} : {{ $lang->name }}
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label required">@lang('messages.Name')</label>
                                    <input type="text" name="name" value="{{ $lang->name }}"
                                        class="form-control @error('name') is-invalid @enderror" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="code" class="form-label required">@lang('messages.Code')</label>
                                    <input type="text" name="code" value="{{ $lang->code }}"
                                        class="form-control @error('code') is-invalid @enderror" required>

                                </div>
                                <div class="form-group mb-3">
                                    <label for="native" class="form-label required">@lang('messages.Native_Name')</label>
                                    <input type="text" name="native" value="{{ $lang->native }}"
                                        class="form-control @error('native') is-invalid @enderror" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="native" class="form-label optional">@lang('messages.Region') </label>
                                    <input type="text" name="regional" value="{{ $lang->regional }}" class="form-control">
                                    <small id="helpId" class="form-text text-success">i.e: fr-FR, en-US, en-GB...</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="native" class="form-label optional">@lang('messages.Flag_Code')</label>
                                    <input type="text" name="flag_code" value="{{ $lang->flag_code }}"
                                        class="form-control @error('flag_code') is-invalid @enderror" required>
                                    <small id="helpId" class="form-text text-success">i.e: fr, us ,gb , cn,
                                        es...</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="native" class="form-label">@lang('messages.Status')</label>
                                    <select name="status" class="form-select">
                                        <option value="1" @if ($lang->status == 1) selected @endif>
                                            {{ get_status('', '1') }}</option>
                                        <option value="2" @if ($lang->status == 2) selected @endif>
                                            {{ get_status('', '2') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="">@lang('messages.Close')</span>
                            </button>

                            <button type="submit" class="btn btn-success ml-1" ddata-bs-dismiss="modal">
                                <i class="bx bx-check "></i>
                                <span class="">@lang('messages.Save_Change')</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- delete modal --}}
        <div class="modal fade text-left" id="lang-delete-{{ $lang->id }}" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel110">
                            @lang('messages.Perform_Action')
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('messages.Delete') {{ $lang->name }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                            <span class=""> @lang('messages.Cancel')</span>
                        </button>
                        <a class="btn btn-danger ml-1"
                            href="{{ route('dashboard.languages.delete', ['id' => $lang->id]) }}">
                            @lang('messages.Yes')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- create --}}
    <div class="modal fade text-left" id="lang-create" tabindex="-1" aria-labelledby="myModalLabel110"
        aria-modal="true" role="dialog">
        <div class="modal-lg-x modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form action="{{ route('dashboard.languages.create') }}" class="form" method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="modal" value="lang-create">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel110">
                            @lang('messages.Add_Language')
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label required">@lang('messages.Name')</label>
                                <input type="text" name="name" value="" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="code" class="form-label required">@lang('messages.Code')</label>
                                <input type="text" name="code" value="" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="native" class="form-label required">@lang('messages.Native_Name')</label>
                                <input type="text" name="native" value="" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="native" class="form-label optional">@lang('messages.Region') </label>
                                <input type="text" name="regional" value="" class="form-control">
                                <small id="helpId" class="form-text text-success">i.e: fr-FR, en-US, en-GB...</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="native" class="form-label optional">@lang('messages.Flag_Code') </label>
                                <input type="text" name="flag_code" value="" class="form-control">
                                <small id="helpId" class="form-text text-success">i.e: fr, us ,gb , cn,
                                    es...</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="native" class="form-label">@lang('messages.Status')</label>
                                <select name="status" class="form-select">
                                    <option value="1">{{ get_status('', '1') }}</option>
                                    <option value="2">{{ get_status('', '2') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">@lang('messages.Close')</span>
                        </button>

                        <button type="submit" class="btn btn-success ml-1" ddata-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">@lang('messages.Add')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
{{-- / Language  modal --}}
