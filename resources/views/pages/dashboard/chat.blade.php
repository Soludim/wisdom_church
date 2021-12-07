@extends('pages.dashboard.dash_main')
@section('content')
<section id="main-content">
  <section class="wrapper site-min-height">
    <div class="chat-room mt">
      <aside class="mid-side">
        <div class="chat-room-head">
          <h3>{{Auth::user()->name}}'s Room</h3>
          <form action="#" class="pull-right position">
            <input type="text" placeholder="Search" class="form-control search-btn ">
          </form>
        </div>
        <div class="room-desk">
          <h4 class="pull-left">My Rooms</h4>
          @if(in_array(Auth::user()->role_id, config('app.permissions')))
          <!--Create Room button only visible for allowed people-->
          <button data-toggle="modal" data-target="#chatmodal" class="pull-right btn btn-theme02">+ Create Room</button>
          @endif

          @include('partials.dashboard._create-chat-modal')
          @foreach($data as $data)
          <div class="room-box">
            <h5 class="text-primary"><a href="{{ url('chat_room/' . Crypt::encrypt($data->chat->id)) }}">{{$data->chat->name}}</a></h5>
            <p>{{$data->chat->info}}</p>
          </div>
          @endforeach
        </div>
      </aside>
    </div>
  </section>
</section>
</section>

<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
<script class="include" type="text/javascript" src="{{asset('lib/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
<!--common script for all pages-->
<script src="{{asset('lib/common-scripts.js')}}"></script>
@endsection