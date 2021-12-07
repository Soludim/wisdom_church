@extends('pages.dashboard.dash_main')

@section('content')
<section id="container">
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper">
      <div class="row mt">
        <div class="col-md-12">
          <div class="content-panel">
          <div class="row pull-right" style="margin-right: 3px">
            <label>Search: <input type="text" id="sort_name" placeholder="by topic..."></label>
          </div>
            <table class="table table-striped table-advance table-hover">
              <h4 style="font-size: bold"><i class="fa fa-angle-right"></i > Sermons </h4>
              <div style="padding-left: 10px">
                <a href="/dsermon/create" class="btn btn-theme">Create Sermon</a>
              </div>
              <br />
              <hr>
              <thead>
                <tr>
                  <th>#</th>
                  <th><i class="fa fa-bookmark"></i> Topic</th>
                  <th><i class="fa fa-user"></i> Preached by</th>
                  <th><i class="fa fa-clock-o"></i> Date</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="sermons">
              @if ($data->data != null)
                @for($i=0; $i < count($data->data); $i++)
                <tr id="{{$data->data[$i]->id}}">
                  <td>
                    {{$data->from + $i}}
                  </td>
                  <td>
                  @if (strlen($data->data[$i]->topic) < 40)
                  {{$data->data[$i]->topic}}
                  @else
                  {{substr($data->data[$i]->topic, 0, 40)}} ...
                  @endif  
                  </td>
                  <td>{{$data->data[$i]->speaker_position}} {{$data->data[$i]->speaker_name}}</td>
                  <td>{{date('M', strtotime($data->data[$i]->created_at))}} {{date('d', strtotime($data->data[$i]->created_at)) }}, {{ date('yy', strtotime($data->data[$i]->created_at)) }}</td>
                  <td>
                    <a href="{{ url('dsermon/' . $data->data[$i]->id . '/details') }}" class="btn btn-success btn-xs"><i class="fa fa-check-square-o"></i></a>
                    <a href="{{ url('dsermon/' . $data->data[$i]->id . '/edit') }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
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
var search = ''; //topic to sort by
var appUrl = "{{ env('APP_URL') }}";
var page = 1;
    $('#paginator').on('click', '.pag', function() {
       page = $(this).data('page');
       getData();
    });

    function sortSermons(inp) {
        inp.addEventListener('input', function(e) {
            search = inp.value; //set search string to input value
            getData(); //call method to get data
        })
    }

    function getData() {
        $.ajax({
            url: `${apiUrl}/api/sermon?page=${page}&topic=${search}`,
            type: 'get',
            success: function(data) {
              $('#sermons').html(null);
               for(let i=0;i< data.sermons.data.length; i++) {
                    $('#sermons').append(`
                    <tr id="${data.sermons.data[i].id}">
                  <td>
                    ${data.sermons.from + i}
                  </td>
                  <td>
                  ${data.sermons.data[i].topic.length < 40 ? data.sermons.data[i].topic : data.sermons.data[i].topic.substring(0, 40)}  
                  </td>
                  <td>${data.sermons.data[i].speaker_position} ${data.sermons.data[i].speaker_name}</td>
                  <td>${transDate(data.sermons.data[i].created_at)}</td>
                  <td>
                      <a href="/dsermon/${data.sermons.data[i].id}/details" class="btn btn-success btn-xs"><i class="fa fa-check-square-o"></i></a>
                      <a href="/dsermon/${data.sermons.data[i].id}/edit" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                      <button data-id="${data.sermons.data[i].id}" class="del btn btn-danger btn-xs">
                        <i class="fa fa-trash-o "></i>
                      </button>
                  </td>
                </tr>
                    `)
                } //sermons list

                $('#paginator').html(null);
                if (data.sermons.last_page > 1) {
                    $('#paginator').html(`
                    <div class="dataTables_info">Showing ${data.sermons.from} to ${data.sermons.to} of ${data.sermons.total} entries</div>
              <div class="dataTables_paginate paging_bootstrap pagination">
                  <ul>
                      <li class="prev ${data.sermons.prev_page_url == null ? 'disabled' : ''}"><a class="pag" data-page="${data.sermons.current_page - 1}" href="prev:;">← Previous</a></li>
                      ${
                          paginate(data.sermons)
                      }
                      <li class="next ${data.sermons.next_page_url == null ? 'disabled' : ''}"><a class="pag" data-page="${data.sermons.current_page + 1}" href="next:;">Next → </a></li>
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


    $('#sermons').on('click', '.del', function() {
        let sermonId = $(this).data('id'); //get id of request
        $.ajax({
            url: `${apiUrl}/api/sermon/${sermonId}?api_token=${token}`,
            type: 'delete',
            success: function(data) {
                getData();
               //$('#'+sermonId).html(null);      //remove deleted sermon from view
            },
            error: function(error) {
                alert("Something went wrong")
            }

        })
    });

    sortSermons(document.getElementById('sort_name'));
    function transDate(timestamp) {
        let newd = new  Date(timestamp);

        let month = newd.toLocaleString('default', {month: 'short'});
        let day = newd.getDate();
        let year = newd.getFullYear()
      return month +"  " + day + ", " + year;
    }
</script>
@endsection
