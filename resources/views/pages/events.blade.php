@extends('main')

@section('title', 'Events')

@section('content')
<section id="home" class="video-hero js-fullheight" style="height: 700px; background-image: url({{asset('images/bg_1.jpg')}});  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
    <div class="overlay js-fullheight"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="/">Home</a></span> <span>Events</span></p>
                <h1 class="mb-3 mt-0 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Events</h1>
            </div>
        </div>
    </div>
</section>

@include('partials._earliestEvent')

<section class="ftco-section ftco-section-2">
    <div class="container">
        <div class="row">
            @if($data->events->data != null)
            @foreach($data->events->data as $event)
            <div class="col-md-6">
                <div class="event-entry d-flex ftco-animate">
                    <div class="meta mr-4">
                        @if($event->date)
                        <p>
                            <span>{{date('d', strtotime($event->date)) }}</span>
                            <span>{{date('F', strtotime($event->date))}} {{ date('yy', strtotime($event->date)) }}</span>
                        </p>
                        @endif
                    </div>
                    <div class="text">
                        <h3 class="mb-2"><a href="{{url('/event/' . Crypt::encrypt($event->id))}}">{{$event->name}}</a></h3>
                        <p class="mb-4"><span>{{$event->time}} at {{$event->venue}}</span></p>
                        <a href="{{url('/event/' . Crypt::encrypt($event->id))}}" class="img mb-4" style="background-image: url({{asset('storage/' . $event->coverImage)}});"></a>
                        <p>{{substr($event->details, 0, 100)}} ...</p>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h3 style="margin-left:auto; margin-right:auto">NO EVENTS AVAILABLE</h3>
            @endif

        </div>
        @if($data->events->last_page != 1)
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    <ul>
                        <li class="{{$data->events->prev_page_url == null ? 'disabled' : ''}}"><a href="{{url('events/'. Crypt::encrypt($data->events->current_page - 1))}}">&lt;</a></li>
                        @for($i=1; $i <= $data->events->last_page; $i++)
                        <li class="{{ $data->events->current_page == $i ? 'active' : '' }}"><a href="{{url('events/'. Crypt::encrypt($i))}}">{{$i}}</a></li>
                        @endfor
                        <li class="{{$data->events->next_page_url == null ? 'disabled' : ''}}"><a href="{{url('events/'.Crypt::encrypt($data->events->current_page + 1))}}">&gt;</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection