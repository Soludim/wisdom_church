@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
  <section class="wrapper">
    <div style="padding:8px">
      <div class="row mt">
          @if($post != null)
          <div class="col-lg-3">
            <img src="{{asset('storage/'. $post->coverImage)}}" width="100%" style="border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
            <p>Creater: {{$post->user->name}}</p>
            <p>Category: {{$post->category->name}}</p>
            <p>Created on: {{date('M', strtotime($post->created_at))}} {{date('d', strtotime($post->created_at)) }}, {{ date('yy', strtotime($post->created_at)) }}</p>
            <p>Comments: {{$post->comments_count}} <i class="fa fa-comments-o"></i></p>
          </div>
          <div class="col-lg-9">
             <h2 class=""style="padding: 8px; text-align: center;">{{$post->title}}</h2>
             <p>{!!$post->content!!}</p>
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