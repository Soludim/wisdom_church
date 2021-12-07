@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
    <section class="wrapper site-min-height">
        <h3 style="margin-top: 40px"><i class="fa fa-angle-right"></i> Members</h3>
        <div class="row pull-right" style="margin-right: 3px">
            <label>Search: <input type="text" id="sort_name" placeholder="by username..."></label>
        </div>
        <div class="row" style="padding:10px" id="category">
            <input style="padding-right:10px" name="request_status" type="radio" value="0" checked /> All
            <input name="request_status" type="radio" value="1" /> Leaders
            <input name="request_status" type="radio" value="2" /> Members
        </div>

        <div class="row" id="members">
            @if ($data['members'] != null)
            @foreach($data['members']->data as $user)
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6" style="margin-bottom: 8px">
                <div data-toggle="collapse" data-target="#role{{$user->id}}" aria-expanded="false" aria-controls="role{{$user->id}}">
                    <div class="item text-center">
                        <div class="testimony-wrap p-4 pb-3" style="padding: 10px">
                            <div class="user-img mb-4 img-fluid" style="background-image: url({{ $user->provider ?  $user->profile_pic : asset('storage/' . $user->profile_pic)}})">
                            </div>
                            <div style="height:60px" class="text">
                                <p class="name">{{$user->name}}</p>
                                <span class="position">{{$user->role->name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->role_id === 1 )
                <!--Change User Role Form start-->
                <div class="collapse" id="role{{$user->id}}">
                    <form method="post" action="/user/role" autocomplete="off">
                        @csrf
                        <input hidden name="userId" type="text" value="{{$user->id}}" />
                        Change Role:
                        <select class="form-control" name="role">
                            @foreach($data['roles'] as $role)
                            <option {{$role->id == $user->role_id ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        <input type="submit" class="btn-xm pull-right" value="Update" />
                    </form>
                </div>
                <!--Change User Role Form end-->
                @endif
            </div>
            @endforeach
            @endif
        </div>
        @if($data['members']->last_page > 1)
        <div class="row-fluid" id="paginator">
            <div class="dataTables_info">Showing {{$data['members']->from}} to {{$data['members']->to}} of {{$data['members']->total}} entries</div>
                <div class="dataTables_paginate paging_bootstrap pagination">
                    <ul>
                        <li class="prev {{$data['members']->prev_page_url == null ? 'disabled' : ''}}"><a class="pag" data-page="{{$data['members']->current_page - 1}}" href="javascript:;">← Previous</a></li>
                        @for($i=1; $i <= $data['members']->last_page; $i++)
                        <li class="{{ $data['members']->current_page == $i ? 'active' : '' }}"><a class="pag" data-page="{{$i}}" href="javascript:;">{{$i}}</a></li>
                        @endfor
                        <li class="next {{$data['members']->next_page_url == null ? 'disabled' : ''}}"><a class="pag" data-page="{{$data['members']->current_page + 1}}" href="javascript:;">Next → </a></li>
                    </ul>
                </div>
        </div>
        @endif
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
    var allRoles = @json($data['roles']);
    var appUrl = "{{ env('APP_URL') }}";

    var role = 0; //get value of selected radio
    var page = 1; //current pagination page
    var search = ''; //username to sort by
    $(document).ready(function() {
        $('#category').change(function() {
            role = $("input[name=request_status]:checked").val(); //reset role type
            page = 1; // reset current page for new category
            getData(); //call method to get data
        });
    });

    function sortMembers(inp) {
        inp.addEventListener('input', function(e) {
            search = inp.value; //set search string to input value
            getData(); //call method to get data
        })
    }

    //populate roles and keep user role selected in the 'change role form'
    function getUserRole(user) {
        let options = allRoles.map(function(role) {
            return `<option ${role.id == user.role_id ? 'selected' : ''} value="${role.id}">${role.name}</option>`
        })
        return options;
    }

    $('#paginator').on('click', '.pag', function() {
       page = $(this).data('page');
       console.log(page);
       getData();
    });

    function getData() {
        $.ajax({
            url: `${appUrl}/api/user?page=${page}&username=${search}&role=${role}`,
            type: 'get',
            success: function(data) {
                $('#members').html(null);
                data.data.data.map(function(user) {
                    $('#members').append(`
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6" style="margin-bottom: 8px">
                <div data-toggle="collapse" data-target="#role${user.id}" aria-expanded="false" aria-controls="role${user.id}">
                    <div class="item text-center">
                        <div class="testimony-wrap p-4 pb-3" style="padding: 10px">
                            <div class="user-img mb-4 img-fluid" style="background-image: url({{asset('storage/${user.profile_pic}')}})">
</div>
<div style="height:60px" class="text">
    <p class="name">${user.name}</p>
    <span class="position">${user.role.name}</span>
</div>
</div>
</div>
</div>
<!--Change User Role Form start-->
<div class="collapse" id="role${user.id}">
    <form method="post" action="/user/role" autocomplete="off">
        @csrf
        <input hidden name="userId" type="text" value="${user.id}" />
        Change Role:
        <select class="form-control" name="role">
            ${
               getUserRole(user)
            }
        </select>
        <input type="submit" class="btn-xm pull-right" value="Update" />
    </form>
</div>
<!--Change User Role Form end-->`)
                }) //members list

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

    function paginate(data) {
        let list='';
        for(let i=1; i<= data.last_page; i++) {
            list += `<li class="${data.current_page == i ? 'active' : '' }"><a class="pag" data-page="${i}" href="javascript:;">${i}</a></li>`
        }
        return list;
    }

    sortMembers(document.getElementById('sort_name'));
</script>
@endsection