@extends('main')

@section('title', 'Contact')

@section('content')
<section id="home" class="video-hero js-fullheight" style="height: 700px; background-image: url(images/bg_1.jpg);  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
    <div class="overlay js-fullheight"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="/">Home</a></span> <span>Contact</span></p>
                <h1 class="mb-3 mt-0 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Contact</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section contact-section ftco-degree-bg">
    <div class="container bg-light">
        <div class="row d-flex mb-5 contact-info">
            <div class="col-md-12 mb-4">
                <h2 class="h4">Contact Information</h2>
            </div>
            <div class="w-100"></div>
            <div class="col-md-3">
                <p><span>Address:</span> {{config('app.church_address')}}</p>
            </div>
            <div class="col-md-3">
                <p><span>Phone:</span> <a href="tel://{{config('app.contact_phone')}}">{{config('app.contact_phone')}}</a></p>
            </div>
            <div class="col-md-3">
                <p><span>Email:</span> <a href="mailto:{{config('app.contact_mail')}}">{{config('app.contact_mail')}}</a></p>
            </div>
        </div>
        <div class="row block-9">
            <div class="col-md-6 pr-md-5">
                <form method="post" action="{{route('contact.store')}}">
                    @csrf()
                    <div class="form-group">
                        <input type="text" name="name" required class="form-control" placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" name="email" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" name="Subject" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea cols="30" required name="message" rows="7" class="form-control" placeholder="Message"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                    </div>
                </form>

            </div>

            <div class="col-md-6" id="map"></div>
        </div>
    </div>
</section>
@endsection