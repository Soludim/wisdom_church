@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
  <section class="wrapper site-min-height">
    <div class="row mt">
      <div class="col-lg-12">
        <div class="row content-panel">
          <div class="col-md-12 centered">
            <div class="profile-pic">
              <p>
                <img src="{{Auth::user()->provider ? Auth::user()->profile_pic : asset('storage/' . Auth::user()->profile_pic)}}" class="img-circle" />
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-10 mt">
        <div class="row">
          <div class="col-lg-12 col-lg-offset-2 detailed">
            <h4 class="mb">Personal Information</h4>
            <form autocomplete="off" method="post" action="{{ route('profile.update', Auth::user()->id)}}" enctype="multipart/form-data" class="form-horizontal">
              {{csrf_field()}}
              @method('put')
              <div class="form-group">
                <label class="col-lg-2 control-label"> Avatar</label>
                <div class="col-lg-6">
                  <input type="file" name="profile_pic" class="form-control-file" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Username</label>
                <div class="col-lg-6">
                  <input type="text" required name="name" value="{{Auth::user()->name}}" class="form-control" />
                  @error('name')
                  <p class="text-danger">{{$message}}</p>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Lives In</label>
                <div class="col-lg-6">
                  <input type="text" required name="lives_in" value="{{Auth::user()->lives_in}}" class="form-control" />
                  @error('lives_in')
                  <p class="text-danger">{{$message}}</p>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Contact</label>
                <div class="col-lg-6">
                  <input type="text" required value="{{Auth::user()->contact}}" name="contact" class="form-control" />
                  @error('contact')
                  <p class="text-danger">{{$message}}</p>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Email</label>
                <div class="col-lg-6">
                  <input type="text" id="email" disabled value="{{Auth::user()->email}}" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Role</label>
                <div class="col-lg-6">
                  <input type="text" value="{{Auth::user()->role->name}}" disabled id="role" class="form-control" />
                </div>
              </div>
              <div class="form-group col-lg-8">
                <div class="pull-right">
                  <button class="btn btn-theme" type="submit">Save</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-12 col-lg-offset-2 detailed mt">
            <h3 class="mb">Change Password</h3>
            <!-- @if($errors->any)
            @foreach($errors->all() as $error)
             <ul>
               <li>{{$error}}</li>
             </ul>
             @endforeach
            @endif -->
            <form role="form" method="post" action="{{ route('passwordreset') }}" class="form-horizontal">
              {{csrf_field()}}
              @method('put')
              <div class="form-group">
                <label class="col-lg-2 control-label">Old Password</label>
                <div class="col-lg-6">
                  <input type="password" name="old_password" class="form-control">
                  @error('old_password')
                  <p class="text-danger">{{$message}}</p>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">New Password</label>
                <div class="col-lg-6">
                  <input type="password" name="new_password" class="form-control">
                  @error('new_password')
                  <p class="text-danger">{{$message}}</p>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Confirm Password</label>
                <div class="col-lg-6">
                  <input type="password" name="new_password_confirmation" class="form-control">
                </div>
              </div>
              <div class="form-group col-lg-8">
                <div class="pull-right">
                  <button class="btn btn-theme" type="submit">Change</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>
<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/common-scripts.js')}}"></script>
<script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
<script class="include" type="text/javascript" src="{{asset('lib/jquery.dcjqaccordion.2.7.js')}}"></script>

@endsection