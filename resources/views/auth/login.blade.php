<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>Church | Login</title>

  <!-- Favicons -->
  <link href="{{asset('img/favicon.png')}}" rel="icon">
  <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <link href="{{asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <link href="{{asset('css/style1.css')}}" rel="stylesheet">
</head>

<body>
  <div id="login-page">
    <div class="container">
      <form class="form-login" action="{{ route('login') }}" method="POST">
        {{csrf_field()}}
        <h2 class="form-login-heading">sign in now</h2>
        <div class="login-wrap">
          <input type="text" name="email" value="{{old('email')}}" class="form-control" placeholder="Email" autofocus>
          @error('email')
          <p class="text-danger">{{$message}}</p>
          @enderror
          <br>
          <input type="password" name="password" class="form-control" placeholder="Password" />
          @error('password')
          <p class="text-danger">{{$message}}</p>
          @enderror
          <label class="checkbox">
            <span class="pull-right">
              <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
            </span>
          </label>
          <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> LOGIN</button>
          <hr>
          <div class="login-social-link centered">
            <p>or you can sign in via your social network</p>
            <a href="{{ url('/login/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
            <a href="{{ url('/login/google') }}" class="btn btn-theme04" type="button"><i class="fa fa-google-plus"></i> GMail</a>
          </div>
          <div class="registration">
            Don't have an account yet?<br />
            <a href="/register">
              Create an account
            </a>
          </div>
        </div>
      </form>
      <!-- Modal -->
      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Forgot Password ?</h4>
            </div>
            <form action="{{ route('password.email') }}" method="POST">
              {{csrf_field()}}
              <div class="modal-body">
                <p>Enter your e-mail address below to reset your password.</p>
                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
                @if(session('status'))
                <div>
                  {{session('status')}}
                </div>
                @endif
              </div>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <input class="btn btn-theme" type="submit" value="Submit" />
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- modal -->
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="{{asset('lib/jquery.backstretch.min.js')}}"></script>
  <script>
    let session = @json(session('status'));
    if (session) {
      toastr.success("{{ Session::get('status') }}");
      console.log('here')
    }
  </script>
  <script>
    $.backstretch("{{asset('images/bg_1.jpg')}}", {
      speed: 1000
    });
  </script>
</body>

</html>