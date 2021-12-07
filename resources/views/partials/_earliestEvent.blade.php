<section class="ftco-bible-study">
    <div class="container-wrap">
        <div class="col-md-12 wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-md-flex">
                        <div class="one-forth ftco-animate">
                            @if($data->earliestEvent)
                            <h3>Earliest Event</h3>
                            <p><span style="font-weight: bold">{{$data->earliestEvent->name }}: </span>{{substr($data->earliestEvent->details, 0, 75) }} ...</p>
                            @else
                                <h3 style="margin-top:20px">Earliest Event</h3>
                                <p style="height:20px"></p>
                            @endif
                        </div>

                        <div class="one-half d-md-flex align-items-md-center ftco-animate">
                            @if($data->earliestEvent)
                            <div class="countdown-wrap">
                                <p class="countdown d-flex">
                                    <span id="days"></span>
                                    <span id="hours"></span>
                                    <span id="minutes"></span>
                                    <span id="seconds"></span>
                                </p>
                            </div>
                            <div class="button">
                                <p><a href="{{url('/event/' . Crypt::encrypt($data->earliestEvent->id))}}" class="btn btn-primary p-3">Events Details</a></p>
                            </div>
                            @else
                            <div class="one-half d-md-flex align-items-md-center ftco-animate">
                                <h3 style="padding: 10px 30px"> No Count down event</h3>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let lat = @json($data->earliestEvent);
    if (lat) {
        // Set the date we're counting down to
        let dateTime = lat.date + ' ' + lat.time;
        var countDownDate = new Date(dateTime).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now an the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in an element with id="demo"
            // document.getElementById("demo").innerHTML = days + "Days " + hours + "Hours "
            // + minutes + "Minutes " + seconds + "Seconds ";

            // Display the result in an element with id="demo"
            document.getElementById("days").innerHTML = days + " <small>days</small>";
            document.getElementById("hours").innerHTML = hours + " <small>hours</small> ";
            document.getElementById("minutes").innerHTML = minutes + " <small>minutes</small> ";
            document.getElementById("seconds").innerHTML = seconds + " <small>seconds</small> ";

            // If the count down is finished, write some text 
            if (distance < 0) {
                clearInterval(x);
                //document.getElementById("demo").innerHTML = "The Wedding Ceremony is Over";
            }
        }, 1000);
    }
</script>