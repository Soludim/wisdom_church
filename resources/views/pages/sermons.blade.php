@extends('main')

@section('title', 'Sermons')

@section('content')

<section id="home" class="video-hero js-fullheight" style="height: 700px; background-image: url({{asset('images/bg_1.jpg')}});  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
    <div class="overlay js-fullheight"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="/">Home</a></span> <span>Sermons</span></p>
                <h1 class="mb-3 mt-0 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Sermons</h1>
            </div>
        </div>
    </div>
</section>

@include('partials._earliestEvent')

<section class="ftco-section">
    <div class="container">
        <div class="row">
            @if($data->sermons->data != null)
            @foreach($data->sermons->data as $sermon)
            <div class="col-md-4 ftco-animate">
                <div class="sermons">
                    <a href="{{url('/sermon/' . Crypt::encrypt($sermon->id))}}" class="img mb-2" style="background-image: url({{asset('storage/'. $sermon->coverImage)}});">
                    </a>
                    <div class="text">
                        <h3><a href="{{url('/sermon/' . Crypt::encrypt($sermon->id))}}">{{$sermon->topic}}</a></h3>
                        <span class="position">{{$sermon->speaker_position}} {{$sermon->speaker_name}}</span>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h3 style="margin-left:auto; margin-right:auto">NO SERMONS AVAILABLE</h3>
            @endif
        </div>
        @if($data->sermons->last_page != 1)
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    <ul>
                        <li class="{{$data->sermons->prev_page_url == null ? 'disabled' : ''}}"><a href="{{url('sermons/'. Crypt::encrypt($data->sermons->current_page - 1))}}">&lt;</a></li>
                        @for($i=1; $i <= $data->sermons->last_page; $i++)
                            <li class="{{ $data->sermons->current_page == $i ? 'active' : '' }}"><a href="{{url('sermons/'. Crypt::encrypt($i))}}">{{$i}}</a></li>
                            @endfor
                            <li class="{{$data->sermons->next_page_url == null ? 'disabled' : ''}}"><a href="{{url('sermons/'.Crypt::encrypt($data->sermons->current_page + 1))}}">&gt;</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection