@extends('pages.dashboard.dash_main')

@section('content')
<section id="container">


  <!--main content start-->
  <section id="main-content">
    <section class="wrapper">
      <div class="row mt">
        <div class="col-md-12">
          <div class="content-panel">
            <div class="pull-right">
            <label>Search: <input type="text" id="sort_name" placeholder="by title..."></label>
            </div>
            <table class="table table-striped table-advance table-hover">
              <h4><i class="fa fa-angle-right"></i> My Posts </h4>
              <hr>
              <thead>
                <tr>
                  <th>#</th>
                  <th><i class="fa fa-bookmark"></i> Title</th>
                  <th><i class="fa fa-tags"></i> Category</th>
                  <th><i class="fa fa-question-circle"></i> Date</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="posts">
                @if ($data->data != null)
                @for($i=0; $i < count($data->data); $i++)
                  <tr>
                    <td>
                      {{$data->from + $i}}
                    </td>
                    <td>
                    @if (strlen($data->data[$i]->title) < 40)
                    {{$data->data[$i]->title}}
                    @else
                    {{substr($data->data[$i]->title, 0, 40)}} ...
                    @endif 
                    </td>
                    <td>{{$data->data[$i]->category->name}}</td>
                    <td>{{date('M', strtotime($data->data[$i]->created_at))}} {{date('d', strtotime($data->data[$i]->created_at)) }}, {{ date('yy', strtotime($data->data[$i]->created_at)) }}</td>

                    <td>
                      <a href="{{ url('post/' . $data->data[$i]->id . '/details') }}" class="btn btn-success btn-xs"><i class="fa fa-check-square-o"></i></a>
                      <a href="{{ url('post/' . $data->data[$i]->id . '/edit') }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
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
var userId = "{{Auth::user() ? Auth::user()->id : null}}";
var appUrl = "{{ env('APP_URL') }}";
var search = ''; //topic to sort by
var page = 1;
    $('#paginator').on('click', '.pag', function() {
       page = $(this).data('page');
       getData();
    });

    function sortPosts(inp) {
        inp.addEventListener('input', function(e) {
            search = inp.value; //set search string to input value
            page = 1;
            getData(); //call method to get data
        })
    }

    function getData() {
        $.ajax({
            url: `${appUrl}/api/user/${userId}/post?page=${page}&title=${search}`,
            type: 'get',
            success: function(data) {
                $('#posts').html(null);
               for(let i=0;i< data.data.data.length; i++) {
                  $('#posts').append(`
                    <tr id="${data.data.data[i].id}">
                    <td>
                    ${data.data.from + i}
                    </td>
                    <td>
                    ${data.data.data[i].title.length < 40 ? data.data.data[i].title : data.data.data[i].title.substring(0, 40) + '....'}
                    </td>
                    <td>${data.data.data[i].category.name}</td>
                    <td>${transDate(data.data.data[i].created_at)}</td>
                    <td>
                      <a href="/post/${data.data.data[i].id}/details" class="btn btn-success btn-xs"><i class="fa fa-check-square-o"></i></a>
                      <a href="/post/${data.data.data[i].id}/edit" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                      <button data-id="${data.data.data[i].id}" class="del btn btn-danger btn-xs">
                        <i class="fa fa-trash-o "></i>
                      </button>
                    </td>
                  </tr>
                    `)
               }//posts list

                $('#paginator').html(null);
                if (data.data.last_page > 1) {
                    $('#paginator').html(`
                    <div class="dataTables_info">Showing ${data.data.from} to ${data.data.to} of ${data.data.total} entries</div>
              <div class="dataTables_paginate paging_bootstrap pagination">
                  <ul>
                      <li class="prev ${data.data.prev_page_url == null ? 'disabled' : ''}"><a class="pag" data-page="${data.data.current_page - 1}" href="prev:;">← Previous</a></li>
                      ${
                          paginate(data.data)
                      }
                      <li class="next ${data.data.next_page_url == null ? 'disabled' : ''}"><a class="pag" data-page="${data.data.current_page + 1}" href="next:;">Next → </a></li>
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


    $('#posts').on('click', '.del', function() {
        let postId = $(this).data('id'); //get id of request
        $.ajax({
            url: `${appUrl}/api/post/${postId}?api_token=${token}`,
            type: 'delete',
            success: function(data) {
                getData();
               //$('#'+postId).html(null);      //remove deleted post from view
            },
            error: function(error) {
                alert("Something went wrong")
            }

        })
    });

    sortPosts(document.getElementById('sort_name'));
    function transDate(timestamp) {
        let newd = new  Date(timestamp);

        let month = newd.toLocaleString('default', {month: 'short'});
        let day = newd.getDate();
        let year = newd.getFullYear()
      return month +"  " + day + ", " + year;
    }
</script>
@endsection