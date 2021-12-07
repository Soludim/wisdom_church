@extends('main')

@section('title', 'Blog')

@section('content')

<section id="home" class="video-hero js-fullheight" style="height: 700px; background-image: url({{asset('images/bg_1.jpg')}});  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
    <div class="overlay js-fullheight"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="/">Home</a></span> <span>Blog</span></p>
                <h1 class="mb-3 mt-0 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Blog</h1>
            </div>
        </div>
    </div>
</section>

@include('partials._earliestEvent')

<section class="ftco-section">
    <div class="container">
        <div class="row">
            @if($data->posts->data != null)
            @foreach($data->posts->data as $post)
            <div class="col-md-4 ftco-animate">
                <div class="blog-entry">
                    <a href="{{url('/post/' . Crypt::encrypt($post->id))}}" class="block-20" style="background-image: url({{asset('storage/' . $post->coverImage)}});">
                    </a>
                    <div class="text p-4 d-block">
                        <div class="meta mb-3">
                            <div>{{date('F', strtotime($post->created_at))}} {{date('d', strtotime($post->created_at)) }}, {{ date('yy', strtotime($post->created_at)) }}</div>
                            <div>{{$post->user->name}}</div>
                            <div class="meta-chat"><span class="icon-chat"></span> {{$post->comments_count}}</div>
                        </div>
                        <h3 class="heading" style="height: 45px">
                            <a href="{{url('/post/' . Crypt::encrypt($post->id))}}">
                            @if (strlen($post->title) < 41)
                            {{$post->title}}
                            @else
                            {{substr($post->title, 0, 41)}}...
                             @endif
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        @if($data->posts->last_page != 1)
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    <ul>
                        <li class="{{$data->prev_page_url == null ? 'disabled' : ''}}"><a href="{{url('blog/'. Crypt::encrypt($data->posts->current_page - 1))}}">&lt;</a></li>
                        @for($i=1; $i <= $data->posts->last_page; $i++)
                            <li class="{{ $data->posts->current_page == $i ? 'active' : '' }}"><a href="{{url('blog/'. Crypt::encrypt($i))}}">{{$i}}</a></li>
                            @endfor
                            <li class="{{$data->posts->next_page_url == null ? 'disabled' : ''}}"><a href="{{url('blog/'.Crypt::encrypt($data->posts->current_page + 1))}}">&gt;</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection