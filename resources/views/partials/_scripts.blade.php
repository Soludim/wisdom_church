<script src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{asset('js/jquery-migrate-3.0.1.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.easing.1.3.js')}}"></script>
<script src="{{asset('js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('js/jquery.stellar.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('js/aos.js')}}"></script>
<script src="{{asset('js/jquery.animateNumber.min.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<!-- <script src="{{asset('js/jquery.mb.YTPlayer.min.js')}}"></script> -->
<script src="{{asset('js/scrollax.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script>
    var session = @json(session('message'));
    if(session) {
        var type = session.alert_type
      switch (type) {
        case 'success':
          toastr.success(session.message)
          break;
        case 'error':
          toastr.error(session.message)
          break;
        case 'info':
          toastr.info(session.message)
          break;
        }
}
</script>