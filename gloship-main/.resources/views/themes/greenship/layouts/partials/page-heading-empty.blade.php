<section class="page-banner bg-main2">
    
    <div class="container">
        <div class="row">
            <div class="col">
               
            </div>
        </div>
    </div>

</section>

@push('css')
    <style>
        .navbar {
            background: var(--color-white) !important;
            height: 70px;
            z-index: 999999999;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(65, 57, 134, 0.5);
        }
        @media (max-width: 991px) {
        .navbar {
            height: auto;
        }
    }
    .page-banner {
        padding-top: 50px;
        height: 130px;
    }
    .page-title {
      
    padding: 60px 0;
}
    </style>
@endpush