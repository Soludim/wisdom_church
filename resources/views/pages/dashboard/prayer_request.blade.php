@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <div class="pull-right">
                        <div class="container">
                            <div class="row pull-right" id="status">
                                All: <input style="padding-right:10px" name="request_status" type="radio" value="0" checked />
                                Prayed: <input name="request_status" type="radio" value="1" />
                                Standing: <input name="request_status" type="radio" value="2" />
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-advance table-hover">
                        <h4><i class="fa fa-angle-right"></i> All Prayer Requests - admin only</h4>
                        <hr>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><i class="fa fa-question-circle"></i> Content</th>
                                <th><i class="fa fa-edit"></i> Status</th>
                                <th><i class="fa fa-clock-o"></i> Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="requests">
                            @if ($data->data != null)
                            @for($i=0; $i < count($data->data); $i++)
                                <tr id="{{$data->data[$i]->id}}">
                                    <td>
                                        {{$data->from + $i}}
                                    </td>
                                    <td>{{substr($data->data[$i]->content, 0, 17) }} ...</td>
                                    @if ($data->data[$i]->status == 'standing')
                                    <td id="update{{$data->data[$i]->id}}">
                                        <button data-id="{{$data->data[$i]->id}}" data-status="standing" class="update btn label label-default label-mini">
                                            standing
                                        </button>
                                    </td>
                                    @else
                                    <td id="update{{$data->data[$i]->id}}">
                                        <button data-id="{{$data->data[$i]->id}}" data-status="prayed" class="update btn label label-success label-mini">
                                            prayed!!!
                                        </button>
                                    </td>
                                    @endif

                                    <td>{{date('M', strtotime($data->data[$i]->created_at))}} {{date('d', strtotime($data->data[$i]->created_at)) }}, {{ date('yy', strtotime($data->data[$i]->created_at)) }}</td>

                                    <td>
                                        <button data-id="{{$data->from + $i}}" data-content="{{$data->data[$i]->content}}" type="button" data-toggle="modal" data-target="#viewRequest" class="open-viewRequest btn btn-success btn-xs"><i class="fa fa-check-square-o"></i></button>
                                        <button data-id="{{$data->data[$i]->id}}" class="del btn btn-danger btn-xs">
                                            <i class="fa fa-close"></i>
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
                                <li class="prev {{$data->prev_page_url == null ? 'disabled' : ''}}"><a class="pag" data-page="{{$data->current_page - 1}}" href="javascript:;">← Previous</a></li>
                                    @for($i=1; $i <= $data->last_page; $i++)
                                        <li class="{{ $data->current_page == $i ? 'active' : '' }}"><a class="pag" data-page="{{$i}}" href="javascript:;">{{$i}}</a></li>
                                    @endfor
                                <li class="next {{$data->next_page_url == null ? 'disabled' : ''}}"><a class="pag" data-page="{{$data->current_page + 1}}" href="javascript:;">Next → </a></li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div aria-hidden="true" aria-labelledby="prayerRequestModal" role="dialog" tabindex="-1" id="viewRequest" class="modal fade">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Prayer Request</h5>
                                </div>
                                <div class="modal-body">
                                    <p id="request_content"></p>
                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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
    var page = 1;
    window.onload = function() {
        if (!token){
        return window.location.href = '/login';
    }
    }       

    $(document).on("click", ".open-viewRequest", function() {
        var requestcontent = $(this).data('content');
        var requestid = $(this).data('id');

        $(".modal-body #request_content").text(requestcontent);
        $(".modal-title").text("Prayer Request " + requestid);
    })

    var prayer_status = 0;
    $(document).ready(function() {
        $('#status').change(function() {
            prayer_status = $("input[name=request_status]:checked").val(); //change status
            page = 1; // reset page to 1

            getData(); //call method to get data
        });
    });

    function getData() {
        $.ajax({
            url: `${appUrl}/api/prayerrequest?page=${page}&status=${prayer_status}&api_token=${token}`,
            type: 'get',
            success: function(data) {
                $('#requests').html(null);
                for(let i=0;i< data.data.data.length; i++) {
                $('#requests').append(`
                                <tr id="${data.data.data[i].id}">
                                    <td>
                                        ${data.data.from + i}
                                    </td>
                                    <td>${data.data.data[i].content.substring(0, 17)} ...</td>
                                    ${updateStatus(data.data.data[i])}
                                    <td>${transDate(data.data.data[i].created_at)}</td>

                                    <td>
                                        <button data-id="${data.data.from + i}" data-content="${data.data.data[i].content}" type="button" data-toggle="modal" data-target="#viewRequest" class="open-viewRequest btn btn-success btn-xs"><i class="fa fa-check-square-o"></i></button>
                                        <button data-id="${data.data.data[i].id}" class="del btn btn-danger btn-xs">
                                            <i class="fa fa-close"></i>
                                        </button>
                                    </td>
                                </tr>`)
                } //prayer request list

                $('#paginator').html(null);
                if (data.data.last_page > 1) {
                    $('#paginator').html(`
                    <div class="dataTables_info">Showing ${data.data.from} to ${data.data.to} of ${data.data.total} entries</div>
              <div class="dataTables_paginate paging_bootstrap pagination">
                  <ul>
                      <li class="prev ${data.data.prev_page_url == null ? 'disabled' : ''}"><a class="pag" data-page="${data.data.current_page - 1}" href="javascript:;">← Previous</a></li>
                      ${
                          paginate(data.data)
                      }
                      <li class="next ${data.data.next_page_url == null ? 'disabled' : ''}"><a class="pag" data-page="${data.data.current_page + 1}" href="javascript:;">Next → </a></li>
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

    function updateStatus(request) {
        if(request.status == "standing") {
            return ` <td id="update${request.id}">
                        <button data-id="${request.id}" data-status="standing" class="update btn label label-default label-mini">
                            standing
                        </button>
                    </td>`
        }else {
            return  ` <td id="update${request.id}">
                        <button data-id="${request.id}" data-status="prayed" class="update btn label label-success label-mini">
                            prayed!!!
                        </button>
                    </td>`
        }
                                    
    }
    function paginate(data) {
        let list='';
        for(let i=1; i<= data.last_page; i++) {
            list += `<li class="${data.current_page == i ? 'active' : '' }"><a class="pag" data-page="${i}" href="javascript:;">${i}</a></li>`
        }
        return list;
    }
    
    $('#paginator').on('click', '.pag', function() {
       page = $(this).data('page');
       console.log(page);
       getData();
    });

    $('#requests').on('click', '.del', function() {
        let requestId = $(this).data('id'); //get id of request
        $.ajax({
            url: `${apiUrl}/api/prayerrequest/${requestId}?api_token=${token}`,
            type: 'delete',
            success: function(data) {
                getData();
               //$('#'+requestId).html(null);      //remove deleted request from view
            },
            error: function(error) {
                alert("Something went wrong")
            }

        })
    });

    $('#requests').on('click', '.update', function() {
        let requestId = $(this).data('id'); //get id of request
        let status = $(this).data('status');
        $.ajax({
            url: `${apiUrl}/api/prayerrequest/${requestId}?api_token=${token}`,
            type: 'put',
            success: function(data) {
                getData();
                // if (status == 'prayed')
                // {
                //    $('#update'+requestId).html(`
                //       <button data-id="${requestId}" data-status="standing" class="update btn label label-default label-mini">
                //         standing
                //       </button>
                //     `)
                // } else {
                //     $('#update'+requestId).html(`
                //         <button data-id="${requestId}" data-status="prayed" class="update btn label label-success label-mini">
                //             prayed!!!
                //         </button>
                //     `)
                // }
            },
            error: function(error) {
                alert("Something went wrong")
            }
        })
    })

    function transDate(timestamp) {
        let newd = new  Date(timestamp);

        let month = newd.toLocaleString('default', {month: 'short'});
        let day = newd.getDate();
        let year = newd.getFullYear()
      return month +"  " + day + ", " + year;
    }
</script>
@endsection