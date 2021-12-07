@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
  <section class="wrapper">
    <div style="padding:8px">
      <div class="row mt">
        @if($sermon != null)
        <div class="col-lg-3">
          <img src="{{asset('storage/'. $sermon->coverImage)}}" width="100%" style="border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
          @if ($sermon->video_url != null)
          <p>Video Url: <a href="{{$sermon->video_url}}"> Link available</a> </p>
          @else
          <p>Video Url: No link attached</p>
          @endif
          <img src="{{asset('storage/'. $sermon->speaker_image)}}" width="30%" style="height:20% ;border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
          <p>Speaker: {{$sermon->speaker_position}} {{$sermon->speaker_name}}</p>
          <p>Created on: {{date('M', strtotime($sermon->created_at))}} {{date('d', strtotime($sermon->created_at)) }}, {{ date('yy', strtotime($sermon->created_at)) }}</p>
        </div>
        <div class="col-lg-9">
          <h2 class="" style="padding: 8px; text-align: center;">{{$sermon->topic}}</h2>
          <p>{!!$sermon->content!!}</p>
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