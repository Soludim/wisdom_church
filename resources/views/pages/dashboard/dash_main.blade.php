<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>Dashboard</title>

  <!-- Favicons -->
  <!-- <link href="{{asset('img/favicon.png')}}" rel="icon">
  <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon"> -->

  <!-- Bootstrap core CSS -->
  <link href="{{asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <!--external css-->
  <link href="{{asset('lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="{{asset('css/style1.css')}}" rel="stylesheet">
  <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap-datepicker/css/datepicker.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap-daterangepicker/daterangepicker.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap-timepicker/compiled/timepicker.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('css/zabuto_calendar.css')}}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js" defer></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

  <script src="{{asset('lib/chart-master/Chart.js')}}"></script>
</head>

<body>
  <section id="container">

    @include('partials.dashboard._header')

    @include('partials.dashboard._sidebar')

    @yield('content')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
    <script>
    var session = @json(session('message'));
    if(session) {
        var type = session.alert_type
      switch (type) {
        case 'success':
          toastr.success(session.message);
          break;
        case 'error':
          toastr.error(session.message);
          break;
        case 'info':
          toastr.info(session.message)
          break;
        }
} 
    </script>
</body>

</html>