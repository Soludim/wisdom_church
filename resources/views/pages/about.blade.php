@extends('main')

@section('title', 'About')

@section('content')
<section id="home" class="video-hero js-fullheight" style="height: 700px; background-image: url({{asset('images/bg_1.jpg')}});  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
    <div class="overlay js-fullheight"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="/">Home</a></span> <span>About</span></p>
                <h1 class="mb-3 mt-0 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">About Us</h1>
            </div>
        </div>
    </div>
</section>

@include('partials._earliestEvent')

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

<section class="ftco-section-3 bg-light">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-md-4 py-5 nav-link-wrap aside-stretch">
                <div class="nav ftco-animate flex-column nav-pills text-md-right" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active pr-5" id="v-pills-mission-tab" data-toggle="pill" href="#v-pills-master" role="tab" aria-controls="v-pills-mission" aria-selected="true">Mission</a>

                    <a class="nav-link pr-5" id="v-pills-vission-tab" data-toggle="pill" href="#v-pills-buffet" role="tab" aria-controls="v-pills-vission" aria-selected="false">Vission</a>
                </div>
            </div>
            <div class="col-md-8 pt-5 pb-5 pl-md-5 d-flex align-items-center">

                <div class="tab-content ftco-animate pl-md-5" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="v-pills-mission" role="tabpanel" aria-labelledby="v-pills-mission-tab">
                        <span class="icon mb-3 d-block flaticon-bed"></span>
                        <h2 class="mb-4">Wisdom Church Mission</h2>
                        <p class="lead">"Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean."</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt voluptate, quibusdam sunt iste dolores consequatur</p>
                        <p>Inventore fugit error iure nisi reiciendis fugiat illo pariatur quam sequi quod iusto facilis officiis nobis sit quis molestias asperiores rem, blanditiis! Commodi exercitationem vitae deserunt qui nihil ea, tempore et quam natus quaerat doloremque.</p>
                    </div>

                    <div class="tab-pane fade" id="v-pills-vission" role="tabpanel" aria-labelledby="v-pills-vission-tab">
                        <span class="icon mb-3 d-block flaticon-tray"></span>
                        <h2 class="mb-4">Wisdom Church Vission</h2>
                        <p>There is as far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt voluptate, quibusdam sunt iste dolores consequatur</p>
                        <p>Inventore fugit error iure nisi reiciendis fugiat illo pariatur quam sequi quod iusto facilis officiis nobis sit quis molestias asperiores rem, blanditiis! Commodi exercitationem vitae deserunt qui nihil ea, tempore et quam natus quaerat doloremque.</p>
                        <p><a href="#" class="btn btn-primary">Learn More</a></p>
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
                <h2>Our Leaders</h2>
            </div>
        </div>
        <div class="row">
            @foreach($data->leaders as $leader)
            <div class="col-md-4 ftco-animate">
                <div class="block-10 d-md-flex align-items-center">
                    <!-- <img src="{{asset('storage/'. $leader->profile_pic)}}" /> -->
                    <div class="img" style="background-image: url({{asset('storage/'. $leader->profile_pic)}})"></div>
                    <div class="person-info pl-md-3">
                        <span class="name">{{$leader->name}}</span>
                        <span class="position">{{$leader->role->name}}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection