@extends('main')

@section('title', 'Home')
@section('content')
<section id="home" class="video-hero js-fullheight" style="height: 700px; background-image: url({{asset('images/bg_1.jpg')}});  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
    <div class="overlay js-fullheight"></div>
    <a class="player" data-property="{videoURL:'https://www.youtube.com/watch?v=5m--ptwd_iI',containment:'#home', showControls:false, autoPlay:true, loop:true, mute:false, startAt:0, opacity:1, quality:'default'}"></a>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Needing <strong>Jesus Christ</strong> Together</h1>
                <p data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><a href="/contact" class="btn btn-primary btn-outline-white px-4 py-3">Save your spirit</a></p>
            </div>
        </div>
    </div>
</section>

@include('partials._earliestEvent')

<section class="ftco-section-2">
    <div class="container-fluid">
        <div class="section-2-blocks-wrapper d-flex row no-gutters">
            <div class="img col-md-6 ftco-animate" style="background-image: url({{asset('images/about.jpg')}});">
                <a href="" class="button popup-vimeo"><span class="ion-ios-play"></span></a>
            </div>
            <div class="text col-md-6 ftco-animate">
                <div class="text-inner align-self-start">

                    <h3>Loving God, Loving Others and Serving the World</h3>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>

                    <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
            <div class="col-md-6 text-center heading-section ftco-animate">
                <span class="subheading">Our Services</span>
                <h2 class="mb-4">Giving light to someone</h2>
                <p>You, my brothers and sisters, were called to be free. But do not use your freedom to indulge
                    the flesh; rather, serve one another humbly in love.
                </p>
                <p>Galatians 5:13</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services d-block text-center">
                    <a href="/contact">
                        <div class="d-flex justify-content-center">
                            <div class="icon d-flex justify-content-center mb-3"><span class="align-self-center flaticon-planet-earth"></span></div>
                        </div>
                    </a>
                    <div class="media-body p-2 mt-3">
                        <h3 class="heading">I'm New Here</h3>
                        <p>All manner of people are needed by God. Join us to serve our maker. You are warmly welcome!!!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services d-block text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon d-flex justify-content-center mb-3"><span class="align-self-center flaticon-maternity"></span></div>
                    </div>
                    <div class="media-body p-2 mt-3">
                        <h3 class="heading">Care Ministries</h3>
                        <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
                    </div>
                </div>
            </div>
            @include('partials._prayerRequestModal')
            <div class="col-md-6 col-lg-3 d-flex align-self-stretch ftco-animate" style="cursor:pointer" data-toggle="modal" data-target="#requestModal">
                <div class="media block-6 services d-block text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon d-flex justify-content-center mb-3"><span class="align-self-center flaticon-pray"></span></div>
                    </div>
                    <div class="media-body p-2 mt-3">
                        <h3 class="heading">Prayer Request</h3>
                        <p>This is the prayer link where members can send their prayer requests on their heart. Let senior pastors intercede for you.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services d-block text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon d-flex justify-content-center mb-3"><span class="align-self-center flaticon-podcast"></span></div>
                    </div>
                    <div class="media-body p-2 mt-3">
                        <h3 class="heading">Podcasts</h3>
                        <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row no-gutters justify-content-center mb-5 pb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
                <span class="subheading">Sermons</span>
                <h2 class="mb-4">Watch our sermons</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
            </div>
        </div>
        <div class="row">
            @foreach($data->sermons as $sermon)
            <div class="col-md-4 ftco-animate">
                <div class="sermons">
                    <a href="{{url('/sermon/' . Crypt::encrypt($sermon->id))}}" class="img mb-2" style="background-image: url({{asset('storage/'. $sermon->coverImage)}});">
                    </a>
                    <div class="text">
                        <h3>
                            <a href="{{url('/sermon/' . Crypt::encrypt($sermon->id))}}">
                                @if (strlen($sermon->topic) > 43)
                                {{substr($sermon->topic,0,43)}}...
                                @else
                                {{$sermon->topic}}
                                @endif
                            </a>
                        </h3>
                        <span class="position">{{$sermon->speaker_position}} {{$sermon->speaker_name}}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <p><a href="/sermons" class="btn btn-primary btn-outline-primary p-3">Watch all sermons</a></p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section testimony-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
                <span class="subheading">Read, Get Inspired, and Share Your Story</span>
                <h2 class="mb-2">Testimonies</h2>
            </div>
        </div>
        @include('partials._testifyModal')
        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel ftco-owl">
                    @if ($data->testimonies != null)
                    @foreach ($data->testimonies as $testimony)
                    <div class="item text-center">
                        <div class="testimony-wrap p-2 pb-3">
                            <div class="user-img mb-4" style="background-image: url({{asset('storage/' . $testimony->user->profile_pic)}})">
                                <span class="quote d-flex align-items-center justify-content-center">
                                    <i class="icon-quote-left"></i>
                                </span>
                            </div>
                            <div class="text">
                                <div style="height: 140px">
                                    <p class="mb-5">{{$testimony->content}}</p>
                                </div>
                                <p class="name" style="color:#4f92ff">{{$testimony->user->name}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="pull-right">
                    <button type="button" data-toggle="modal" data-target="#testifyModal" class="btn btn-default">Testify</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-counter" id="section-counter">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
                <h2>Church Achievements</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4 d-flex justify-content-center counter-wrap ftco-animate">
                <div class="block-18 text-center">
                    <div class="text">
                        <strong class="number" data-number="20254">0</strong>
                        <span>Churches around the world</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 d-flex justify-content-center counter-wrap ftco-animate">
                <div class="block-18 text-center">
                    <div class="text">
                        <strong class="number" data-number="4200000">0</strong>
                        <span>Members around the globe</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 d-flex justify-content-center counter-wrap ftco-animate">
                <div class="block-18 text-center">
                    <div class="text">
                        <strong class="number" data-number="8600000">0</strong>
                        <span>Save life &amp; Donations</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
                <span class="subheading">Blog</span>
                <h2>Recent Blog</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
            </div>
        </div>
        <div class="row">


            @foreach($data->posts as $post)
            <div class="col-md-4 ftco-animate">
                <div class="blog-entry" data-aos-delay="100">
                    <a href="{{url('/post/' . Crypt::encrypt($post->id))}}" class="block-20" style="background-image: url({{asset('storage/' . $post->coverImage) }});">
                    </a>
                    <div class="text p-4">
                        <div class="meta mb-3">
                            <div><a href="#">{{date('M', strtotime($post->updated_at))}} {{date('d', strtotime($post->updated_at)) }}, {{ date('yy', strtotime($post->updated_at)) }}</a></div>
                            <div><a href="#">{{$post->user->name}}</a></div>
                            <div><a href="#" class="meta-chat"><span class="icon-chat"></span> {{$post->comments_count}}</a></div>
                        </div>
                        <div style="height: 45px">
                            <h3 class="heading">
                                <a href="{{url('/post/' . Crypt::encrypt($post->id))}}">
                                    @if (strlen($post->title) < 41) {{$post->title}} @else {{substr($post->title, 0, 41)}}... @endif </a> </h3> </div> </div> </div> </div> @endforeach </div> </div> </section> @endsection