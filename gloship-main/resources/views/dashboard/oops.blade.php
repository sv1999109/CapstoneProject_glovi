@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    
    <div class="modal fade bs-example-modal-center" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Oops !</h4>
                        <p class="text-muted mb-4"> @lang('messages.There_Was_Problem').</p>
                        @if (Session::has('message'))
                            <div class="alert alert-warning" role="alert">
                               Ref: {{ Session::get('message') }}
                            </div>
                        @endif
                        <div class="hstack gap-2 justify-content-center mt-3">
                            <a href="{{ route('dashboard.index') }}" class="btn btn-primary">Back to Dashboard</a>
                            <a href="{{ route('contact') }}" class="btn btn-light">Contact Support</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".bs-example-modal-center").modal('show');
            $(body).apend('<div class="modal-backdrop fade show"></div>');
        });
    </script>
@endpush
