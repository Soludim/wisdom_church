@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
  <section class="wrapper">
    <div class="row">
      <div class="col-lg-9 main-chart">
        <!--CUSTOM CHART START -->
        <div class="border-head">
          <h3>USER VISITS</h3>
        </div>
        <div class="custom-bar-chart">
          <ul class="y-axis">
            <li><span>10.000</span></li>
            <li><span>8.000</span></li>
            <li><span>6.000</span></li>
            <li><span>4.000</span></li>
            <li><span>2.000</span></li>
            <li><span>0</span></li>
          </ul>
          <div class="bar">
            <div class="title">JAN</div>
            <div class="value tooltips" data-original-title="8.500" data-toggle="tooltip" data-placement="top">85%</div>
          </div>
          <div class="bar ">
            <div class="title">FEB</div>
            <div class="value tooltips" data-original-title="5.000" data-toggle="tooltip" data-placement="top">50%</div>
          </div>
          <div class="bar ">
            <div class="title">MAR</div>
            <div class="value tooltips" data-original-title="6.000" data-toggle="tooltip" data-placement="top">60%</div>
          </div>
          <div class="bar ">
            <div class="title">APR</div>
            <div class="value tooltips" data-original-title="4.500" data-toggle="tooltip" data-placement="top">45%</div>
          </div>
          <div class="bar">
            <div class="title">MAY</div>
            <div class="value tooltips" data-original-title="3.200" data-toggle="tooltip" data-placement="top">32%</div>
          </div>
          <div class="bar ">
            <div class="title">JUN</div>
            <div class="value tooltips" data-original-title="6.200" data-toggle="tooltip" data-placement="top">62%</div>
          </div>
          <div class="bar">
            <div class="title">JUL</div>
            <div class="value tooltips" data-original-title="7.500" data-toggle="tooltip" data-placement="top">75%</div>
          </div>
        </div>
        <!--custom chart end-->

        <div class="row mt">
          <!-- USER STATUS STATISTICS -->
          <div class="col-md-4 col-sm-4 mb">
            <div class="darkblue-panel pn">
              <div class="darkblue-header">
                <h5>REGISTERED USERS</h5>
              </div>
              <h1 class="mt"><i class="fa fa-user fa-3x"></i></h1>
              <p>TOTAL COUNT: {{$data->registeredUsers}}</p>
              <footer>
                <div class="centered">
                  <h5>NEW ONES: {{$data->todayStat->users}}</h5>
                </div>
              </footer>
            </div>
          </div>
          <!-- /col-md-4 -->

          <!--Earliest Event-->
          <div class="col-md-4 col-sm-4 mb">
          @if($data->earliestEvent)
            <div class="weather-2 pn">
              <div class="weather-2-header">
                <div class="row">
                  <div class="col-sm-6 col-xs-6">
                    <p>EARLIEST EVENT</p>
                  </div>
                  <div class="col-sm-6 col-xs-6 goright">
                    <p class="small">Date: {{$data->earliestEvent->date != null ? $data->earliestEvent->date : "Not Set"}}</p>
                  </div>
                </div>
              </div>
              <!-- /weather-2 header -->
              <div class="row centered">
                <p>{{$data->earliestEvent->name}}</p>
                <img src="{{asset('storage/'. $data->earliestEvent->coverImage)}}" class="img-circle" width="120">
              </div>
              <div class="row data">
                <div class="goleft">
                  <h5>Venue: {{$data->earliestEvent->venue != null ? $data->earliestEvent->venue : "Not Set"}}</h5>
                  <h5>Time: {{$data->earliestEvent->time != null ? date('h:i a', strtotime($data->earliestEvent->time)) : "Not Set"}} </h5>
                </div>
              </div>
            </div>
          @else
          <div class="weather-2 pn">
              <div class="weather-2-header">
                 <h5>EARLIEST EVENT</h5>
              </div>
              <!-- /weather-2 header -->
              <div class="row centered">
                <p>No Event</p>
              </div>
              <div class="row data">
                <div class="goleft">
                  <h5></h5>
                  <h5></h5>
                </div>
              </div>
            </div>
          @endif
            <!--  /darkblue panel -->
          </div>
          <!-- /col-md-4 -->

          <!-- PRAYER REQUEST PANEL -->
          <div class="col-md-4 col-sm-4 mb">
            <div class="grey-panel pn donut-chart">
              <div class="grey-header">
                <h5>PRAYER REQUESTS</h5>
              </div>
              <canvas id="prayerRequestStats" height="120" width="120" style="width: 120px; height: 120px;"></canvas>
              <script>
                var prayedRequests = parseInt("{{$data->prayedRequests}}");
                var standingRequests = parseInt("{{$data->standingRequests}}");
                var total = (prayedRequests + standingRequests) ? (prayedRequests + standingRequests) : 1;

                var doughnutData = [{
                    value: prayedRequests * 100 / total,
                    color: "#FF6B6B"
                  },
                  {
                    value: standingRequests * 100 / total,
                    color: "#fdfdfd"
                  }
                ];
                var myDoughnut = new Chart(document.getElementById("prayerRequestStats").getContext("2d")).Doughnut(doughnutData);
              </script>
              <div class="row">
                <div class="col-sm-6 col-xs-6 goleft">
                  <p>Prayed: {{$data->prayedRequests}} <br /> Standing: {{$data->standingRequests}}</p>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <h2>@if(($data->prayedRequests + $data->standingRequests) <= 0)
                     <p>0%</p>
                    @else
                     <p>{{ceil($data->prayedRequests * 100 /($data->prayedRequests + $data->standingRequests))}}%</p>
                    @endif
                  </h2>
                </div>
              </div>
            </div>
          </div>
          <!-- END PRAYER REQUEST PANEL -->
        </div>


        <div class="row">
          <!-- TESTIMONy PANEL -->
          <div class="col-md-4 mb">
            <div class="green-panel pn">
              <div class="green-header">
                <h5>TESTIMONIES</h5>
              </div>
              <h1 class="mt"><i class="fa fa-tasks fa-3x"></i></h1>
              <p>TOTAL COUNT: {{$data->testimoniesCount}}</p>
              <footer>
                <div class="centered">
                  <h5>NEW ONES: {{$data->todayStat->testimonies}}</h5>
                </div>
              </footer>
            </div>
          </div>
          <!-- END TESTIMONy PANEL -->

          <!-- SERMONS PANEL -->
          <div class="col-md-4 mb">
            <div class="darkblue-panel pn">
              <div class="darkblue-header">
                <h5>SERMONS</h5>
              </div>
              <h1 class="mt"><i class="fa fa-book fa-3x"></i></h1>
              <footer>
                <div class="centered">
                  <h5>TOTAL COUNT : {{$data->sermonCount}}</h5>
                </div>
              </footer>
            </div>
          </div>
          <!-- END SERMONS PANEL -->

          <!-- POSTS PANEL -->
          <div class="col-md-4 mb">
            <div class="darkblue-panel pn">
              <div class="darkblue-header">
                <h5>POSTS</h5>
              </div>
              <h1 class="mt"><i class="fa fa-tasks fa-3x"></i></h1>
              <footer>
                <div class="centered">
                  <h5>TOTAL COUNT : {{$data->postCount}}</h5>
                </div>
              </footer>
            </div>
          </div>
          <!-- END POSTS PANEL -->
        </div>
        <!-- /row -->

      </div>
      <!-- /col-lg-9 END SECTION MIDDLE -->
      <!-- **********************************************************************************************************************************************************
              RIGHT SIDEBAR CONTENT
              *********************************************************************************************************************************************************** -->
      <div class="col-lg-3 ds">
        <!-- MAIL SECTION -->
        <h4 class="centered mt">TODAY'S MAIL</h4>
        <a href="https://gmail.com/" target="_blank" class="desc">
          <div class="thumb">
            <span class="badge bg-theme"><i class="fa fa-envelope"></i></span>
          </div>
          <div class="details">
            <p>
              <muted>Received Mail Count</muted>
              <br />
              {{$data->todayStat->mail_received}} Mails received today<br />
            </p>
          </div>
        </a>

        <!-- CHURCH LEADERS SECTION -->
        <h4 class="centered mt">CHURCH LEADERS</h4>
        @foreach($data->churchLeaders as $leader)
        <div class="desc">
          <div class="thumb">
            <img class="img-circle" src="{{asset('storage/'.$leader->profile_pic)}}" width="35px" height="35px">
          </div>
          <div class="details">
            <p>
              <a href="#">{{$leader->name}}</a><br />
              <muted>{{$leader->role->name}}</muted>
            </p>
          </div>
        </div>
        @endforeach

        <!-- CALENDAR-->
        <div id="calendar" class="mb">
          <div class="panel green-panel no-margin">
            <div class="panel-body">
              <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                <div class="arrow"></div>
                <h3 class="popover-title" style="disadding: none;"></h3>
                <div id="date-popover-content" class="popover-content"></div>
              </div>
              <div id="my-calendar"></div>
            </div>
          </div>
        </div>
        <!-- / calendar -->
      </div>
      <!-- /col-lg-3 -->
    </div>
    <!-- /row -->
  </section>
</section>

<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
<script class="include" type="text/javascript" src="{{asset('lib/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
<!--common script for all pages-->
<script src="{{asset('lib/common-scripts.js')}}"></script>
<script src="{{asset('lib/jquery.sparkline.js')}}"></script>
<!--common script for all pages-->
<script type="text/javascript" src="{{asset('lib/gritter/js/jquery.gritter.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/gritter-conf.js')}}"></script>
<!--script for this page-->
<script src="{{asset('lib/sparkline-chart.js')}}"></script>
<script src="{{asset('lib/zabuto_calendar.js')}}"></script>

<script type="application/javascript">
  $(document).ready(function() {
    $("#date-popover").popover({
      html: true,
      trigger: "manual"
    });
    $("#date-popover").hide();
    $("#date-popover").click(function(e) {
      $(this).hide();
    });

    $("#my-calendar").zabuto_calendar({
      action: function() {
        return myDateFunction(this.id, false);
      },
      action_nav: function() {
        return myNavFunction(this.id);
      },
      ajax: {
        url: "show_data.php?action=1",
        modal: true
      },
      legend: [{
          type: "text",
          label: "Special event",
          badge: "00"
        },
        {
          type: "block",
          label: "Regular event",
        }
      ]
    });
  });

  function myNavFunction(id) {
    $("#date-popover").hide();
    var nav = $("#" + id).data("navigation");
    var to = $("#" + id).data("to");
    console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
  }
</script>
@endsection