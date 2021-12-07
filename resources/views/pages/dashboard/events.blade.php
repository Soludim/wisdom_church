@extends('pages.dashboard.dash_main')

@section('content')
<section id="container">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row mt">
                <div class="col-md-12">
                    <div class="content-panel">
                    <div class="pull-right" style="padding-right:5px">
                      <label>Search: <input type="text" id="sort_name" placeholder="by name..."></label>
                    </div>
                        <table class="table table-striped table-advance table-hover">
                            <h4 style="font-size: bold"><i class="fa fa-angle-right"></i> Events </h4>
                            <div style="padding-left: 10px">
                                <a href="{{url('devent/create')}}" class="btn btn-theme">Create Event</a>
                            </div>
                            <br />
                            <hr>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><i class="fa fa-bookmark"></i> Name</th>
                                    <th><i class="fa fa-calender-o"></i> Date</th>
                                    <th><i class="fa fa-clock"></i> Time</th>
                                    <th><i class="fa fa-map-marker"></i> Venue</th>
                                    <th><i class="fa fa-edit"></i> Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="events">
                                @if ($data->data != null)
                                @for($i=0; $i < count($data->data); $i++)
                                    <tr id="{{$data->data[$i]->id}}">
                                        <td>{{$data->from + $i}}</td>
                                        <td>{{$data->data[$i]->name}}</td>
                                        <td>{{!$data->data[$i]->date ? 'Not Set' : $data->data[$i]->date}}</td>
                                        <td>{{!$data->data[$i]->time ? 'Not Set' : $data->data[$i]->time}}</td>
                                        <td>{{!$data->data[$i]->venue ? 'Not Set' : $data->data[$i]->venue}}</td>
                                        @if($data->data[$i]->standing && $data->data[$i]->date)
                                        <td><span class="label label-success label-mini">standing</span></td>
                                        @elseif(!$data->data[$i]->standing && $data->data[$i]->date)
                                        <td><span class="label label-default label-mini">passed!!</span></td>
                                        @else
                                        <td></td>
                                        @endif
                                        <td>
                                            <a href="{{ url('event/' . $data->data[$i]->id . '/details') }}" class="btn btn-success btn-xs"><i class="fa fa-check-square-o"></i></a>
                                            <a href="{{ url('devent/' . $data->data[$i]->id . '/edit') }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                            <button data-id="{{$data->data[$i]->id}}" class="del btn btn-danger btn-xs">
                                                <i class="fa fa-trash-o "></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endfor
                                    @endif
                            </tbody>
                        </table>
                        @if($data->last_page != 1)
                        <div class="row-fluid" id="paginator">
                           <div class="dataTables_info">Showing {{$data->from}} to {{$data->to}} of {{$data->total}} entries</div>
                           <div class="dataTables_paginate paging_bootstrap pagination">
                           <ul>
                              <li class="prev {{$data->prev_page_url == null ? 'disabled' : ''}}"><a class="pag" data-page="{{$data->current_page - 1}}" href="prev:;">← Previous</a></li>
                              @for($i=1; $i <= $data->last_page; $i++)
                              <li class="{{ $data->current_page == $i ? 'active' : '' }}"><a class="pag" data-page="{{$i}}" href="page{{$i}}:;">{{$i}}</a></li>
                              @endfor
                              <li class="next {{$data->next_page_url == null ? 'disabled' : ''}}"><a class="pag" data-page="{{$data->current_page + 1}}" href="next:;">Next → </a></li>
                           </ul>
                         </div>
                        </div>
                        @endif
                    </div>
                </div>
        </section>
    </section>
</section>


<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
<script class="include" type="text/javascript" src="{{asset('lib/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
<!--common script for all pages-->
<script src="{{asset('lib/common-scripts.js')}}"></script>
<script>

var token = "{{Auth::user() ? Auth::user()->api_token : null}}";
var appUrl = "{{ env('APP_URL') }}";
var search = ''; //name to sort by
var page = 1;
    $('#paginator').on('click', '.pag', function() {
       page = $(this).data('page');
       getData();
    });

    function sortEvents(inp) {
        inp.addEventListener('input', function(e) {
            search = inp.value; //set search string to input value
            page = 1;
            getData(); //call method to get data
        })
    }

    function getData() {
        $.ajax({
            url: `${appUrl}/api/event?page=${page}&name=${search}`,
            type: 'get',
            success: function(data) {
                $('#events').html(null);
               for(let i=0;i< data.events.data.length; i++) {
                    $('#events').append(`
                    <tr id="${data.events.data[i].id}">
                    <tr id="${data.events.data[i].id}">
                        <td>${data.events.from + i}</td>
                        <td>${data.events.data[i].name}</td>
                        <td>${!data.events.data[i].date ? 'Not Set' : data.events.data[i].date}</td>
                        <td>${!data.events.data[i].time ? 'Not Set' : data.events.data[i].time}</td>
                        <td>${!data.events.data[i].venue ? 'Not Set' : data.events.data[i].venue}</td>
                        ${status(data.events.data[i])}
                        <td>
                           <a href="/event/${data.events.data[i].id}/details"  class="btn btn-success btn-xs"><i class="fa fa-check-square-o"></i></a>
                           <a href="/devent/${data.events.data[i].id}/edit" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                           <button data-id="${data.events.data[i].id}" class="del btn btn-danger btn-xs">
                             <i class="fa fa-trash-o"></i>
                           </button>
                        </td>
                  </tr>
                    `)
               }


                 $('#paginator').html(null);
                if (data.events.last_page > 1) {
                    $('#paginator').html(`
                    <div class="dataTables_info">Showing ${data.events.from} to ${data.events.to} of ${data.events.total} entries</div>
                       <div class="dataTables_paginate paging_bootstrap pagination">
                         <ul>
                           <li class="prev ${data.events.prev_page_url == null ? 'disabled' : ''}"><a class="pag" data-page="${data.events.current_page - 1}" href="prev:;">← Previous</a></li>
                           ${
                             paginate(data.events)
                            }
                           <li class="next ${data.events.next_page_url == null ? 'disabled' : ''}"><a class="pag" data-page="${data.events.current_page + 1}" href="next:;">Next → </a></li>
                         </ul>
                       </div>
                    `)
              }
            },
            error: function(error) {
                alert("Something went wrong")
            }
        })
    }

    function paginate(data) {
        let list='';
        for(let i=1; i<= data.last_page; i++) {
            list += `<li class="${data.current_page == i ? 'active' : '' }"><a class="pag" data-page="${i}" href="page${i}:;">${i}</a></li>`
        }
        return list;
    }

    function status(event) {
        if(event.standing && event.date)
            return '<td><span class="label label-success label-mini">standing</span></td>';
        else if(!event.standing && event.date)
            return '<td><span class="label label-default label-mini">passed!!</span></td>';
        else
            return '<td></td>';
                                    
    }

    $('#events').on('click', '.del', function() {
        let eventId = $(this).data('id'); //get id of request
        $.ajax({
            url: `${appUrl}/api/event/${eventId}?api_token=${token}`,
            type: 'delete',
            success: function(data) {
                getData();
               //$('#'+eventId).html(null);      //remove deleted event from view
            },
            error: function(error) {
                alert("Something went wrong")
            }

        })
    });

    sortEvents(document.getElementById('sort_name'));
    function transDate(timestamp) {
        let newd = new  Date(timestamp);

        let month = newd.toLocaleString('default', {month: 'short'});
        let day = newd.getDate();
        let year = newd.getFullYear()
      return month +"  " + day + ", " + year;
    }
</script>


@endsection
