@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
  <section class="wrapper">
    <div style="padding:8px">
      <div class="row mt">
          @if($event != null)
          <div class="col-lg-3">
            <img src="{{asset('storage/'. $event->coverImage)}}" width="100%" style="border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
            <p>Date: {{$event->date != null ? $event->date : "Not Set"}}</p>
            <p>Time: {{$event->time != null ? date('h:i a', strtotime($event->time)) : "Not Set"}}</p>
            <p>Venue: {{$event->venue != null ? $event->venue : "Not Set"}} </p>
            <p>Created on: {{date('F', strtotime($event->created_at))}} {{date('d', strtotime($event->created_at)) }}, {{ date('yy', strtotime($event->created_at)) }}</p>
          </div>
          <div class="col-lg-9">
             <h2 class=""style="padding: 8px; text-align: center;">{{$event->name}}</h2>
             <p>{!!$event->details!!}</p>
          </div>
          @endif
      </div>
    </div>
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