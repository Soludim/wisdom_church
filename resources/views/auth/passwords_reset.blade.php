<!DOCTYPE html>
<html lang="en">

<head>
    <title>PASSWORD RESET</title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <link href="{{asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
</head>

<body>
    <div style="padding: 15px">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title">RESET PASSWORD</p>
                </div>
                <div class="panel-body">
                    <p>Reset password for {{$email}}</p>
                    @if ($errors->any())
                    <div style="margin-top:10px">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('password.update') }}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$email}}" name="email" />
                        <input type="hidden" value="{{$token}}" name="token" />
                        <input type="password" name="password" class="form-control" placeholder="passoword" />
                        <input type="password" name="password_confirmation" class="form-control" placeholder="confirm passoword" />
                        <div class="pull-right">
                            <input type="submit" class="btn btn-theme" value="Submit" />
                        </div>
                    </form>
                </div>
            </div>
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