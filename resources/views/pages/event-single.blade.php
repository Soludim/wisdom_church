@extends('main')

@section('title', 'Event Single')

@section('content')
<section id="home" class="video-hero js-fullheight" style="height: 700px; background-image: url({{asset('images/bg_1.jpg')}});  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
    <div class="overlay js-fullheight"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="/">Home</a> <span>Event Single</span></p>
                <h1 class="mb-3 mt-0 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Event Single</h1>
            </div>
        </div>
    </div>
</section>

@include('partials._earliestEvent')

<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-3 ftco-animate">
                <img src="{{asset('storage/'. $data->event->coverImage)}}" width="100%" style="border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
                <p>Date: {{$data->event->date != null ? $data->event->date : "To be communicated"}}</p>
                <p>Time: {{$data->event->time != null ? date('h:i a', strtotime($data->event->time)) : "To be communicated"}}</p>
                <p>Venue: {{$data->event->venue != null ? $data->event->venue : "To be communicated"}} </p>
                <p>Posted on: {{date('F', strtotime($data->event->created_at))}} {{date('d', strtotime($data->event->created_at)) }}, {{ date('yy', strtotime($data->event->created_at)) }}</p>
            </div>
            <div class="col-md-9 ftco-animate">
                <h2 class="mb-3">{{$data->event->name}}</h2>
                <div>
                    {!!$data->event->details!!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection