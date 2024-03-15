 {{-- Javascript --}}
 <script src="https://code.jquery.com/jquery-3.6.1.min.js"
     integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
 <script type="text/javascript" src="{{ asset(get_theme_dir('assets')) }}/js/underscore.min.js"></script>
 <script type="text/javascript" src="{{ asset(get_theme_dir('assets')) }}/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script type="text/javascript" src="{{ asset('assets/js/typed.min.js') }}"></script>

 {{-- JS Plugins --}}
 <script type="text/javascript" src="{{ asset(get_theme_dir('plugins')) }}/lazyload/lazyload.js"></script>
 <script type="text/javascript" src="{{ asset(get_theme_dir('plugins')) }}/wow/wow.min.js"></script>
 <script type="text/javascript" src="{{ asset(get_theme_dir('plugins')) }}/preloader/preloader.js"></script>
 <script src="{{ asset(get_theme_dir('plugins')) }}/slick/slick.min.js"></script>
 <script src="{{ asset(get_theme_dir('plugins')) }}/owlcarousel/owl.carousel.min.js"></script>
 {{-- <script src="{{ asset(get_theme_dir('plugins')) }}/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script> --}}
 {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}

 <!-- custom script -->
 @stack('scripts')
 <script>
     $(window).on('load', function() {
         /*------- Preloader --------*/
        $('#preloader').delay(1000).fadeOut(200);
     });

     // Typed Initiate
     if ($('.hero-wrapper').length == 1) {
         var typed_strings = $('.hero-wrapper .typed-text').text();
         var typed = new Typed('.hero-wrapper .typed-result', {
             strings: typed_strings.split(',, '),
             typeSpeed: 100,
             backSpeed: 20,
             smartBackspace: false,
             loop: true
         });
     }
     $(document).ready(function() {
         window.addEventListener("scroll", function() {
             let scrollPosition = window.scrollY;
             const site_header = document.querySelector("nav");
             const header_height = site_header.offsetHeight;

             if (scrollPosition >= header_height) {
                 site_header.classList.add("active");
                
             } else {
               
                 site_header.classList.remove("active");
                 
             }
         });
         // AOS.init();
     });
 </script>
 <script type="text/javascript">
     $(document).ready(function() {

         //initiate lazyload
         responsiveLazyload({
             containerClass: 'js--lazyload',
             loadingClass: 'js--lazyload--loading',
             callback: () => {},
         });

         // Initiate the wowjs
         new WOW().init();

         //counter
         $('.stat-count').each(function() {
             $(this).prop('Counter', 0).animate({
                 Counter: $(this).text()
             }, {

                 //chnage count up speed here
                 duration: 5000,
                 easing: 'swing',
                 step: function(now) {
                     $(this).text(Math.ceil(now));
                 }
             });
         });

     });
 </script>

 @if (get_theme_config('custom_js') == 'enabled')
     <script>
         {!! get_contents_admin('custom_js_code', '', 'all') !!}
     </script>
 @endif
