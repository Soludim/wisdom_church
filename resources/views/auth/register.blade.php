<!DOCTYPE html>
<html lang="en">

<head>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>Church | Register</title>

  <!-- Favicons -->
  <link href="{{asset('img/favicon.png')}}" rel="icon">
  <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <link href="{{asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
  <link href="{{asset('css/style1.css')}}" rel="stylesheet">
</head>

<body>
  <div id="login-page" style="margin-top: -80px">
    <div class="container">
      <form class="form-login" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" autocomplete="off">
        {{csrf_field()}}
        <h2 class="form-login-heading">Register now</h2>
        <div class="login-wrap">
          <input type="text" value="{{old('name')}}" name="name" class="form-control" placeholder="Username" autofocus />
          @error('name')
            <p class="text-danger">{{$message}}</p>
          @enderror
          <br />
          <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Email" />
          @error('email')
            <p class="text-danger">{{$message}}</p>
          @enderror
          <br />
          <input type="text" name="lives_in" value="{{old('lives_in')}}" class="form-control" placeholder="Lives In" />
          @error('lives_in')
            <p class="text-danger">{{$message}}</p>
          @enderror
          <br />
          <input type="text" name="contact" value="{{old('contact')}}" class="form-control" placeholder="Contact" />
          @error('contact')
            <p class="text-danger">{{$message}}</p>
          @enderror
          <br />
          <input type="password" name="password" class="form-control" placeholder="Password" />
          @error('password')
            <p class="text-danger">{{$message}}</p>
          @enderror
          <br />
          <p>Choose a profile pic</p>
          <input name="profile_pic" type="file" class="form-control-file" />
          <br />
          <input type="submit" class="btn btn-theme btn-block" value="REGISTER" />
          <hr>
          <div class="registration">
            <a href="/login">
              Already have an account
            </a>
          </div>
        </div>
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Forgot Password ?</h4>
              </div>
              <div class="modal-body">
                <p>Enter your e-mail address below to reset your password.</p>
                <input type="text" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
              </div>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <button class="btn btn-theme" type="button">Submit</button>
              </div>
            </div>
          </div>
        </div>
        <!-- modal -->
      </form>
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="{{asset('lib/jquery.backstretch.min.js')}}"></script>
  <script>
    $.backstretch("{{asset('images/bg_1.jpg')}}", {
      speed: 1000
    });
  </script>
</body>

</html>