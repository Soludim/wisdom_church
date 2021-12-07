@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="chat-room mt">
            <aside class="mid-side">
                <div class="chat-room-head">
                    <h3>Chat Room: {{$data->name}}</h3>
                </div>
                <div id="message-wrapper" style="overflow-y: auto; height: 390px; margin-bottom:70px">
                    @foreach($data->chat_msgs as $msg)
                    <!-- authenticated user\'s messages -->
                    @if($msg->user_id === Auth::id())
                        <div class="row" style="margin:auto">
                        <div class="sentmsgbox">
                            <div style="padding: 10px 20px;">
                                <div class="row">
                                    {{$msg->msg}}
                                </div>
                                <div class="row chat-time pull-right">
                                    {{ date('d M y, h:i a', strtotime($msg->created_at)) }}
                                </div>
                            </div>
                        </div>
                        </div>
                    @else
                    <!-- Other\'s msgs -->
                    <div class="row" style="margin:auto">
                    <div class="recmsgbox">
                        <div style="padding: 10px 20px;">
                            <div class="row" style="font-weight: bold; margin-bottom: 5px">{{$msg->user->name}}</div>
                            <div class="row">
                                {{$msg->msg}}
                            </div>
                            <div class="row chat-time pull-right">
                                {{ date('d M y, h:i a', strtotime($msg->created_at)) }}
                            </div>
                        </div>
                    </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <footer>
                    <div class="chat-txt">
                        <input type="text" class="form-control">
                    </div>
                    <div class="btn-group hidden-sm hidden-xs">
                        <button type="button" class="btn btn-white"><i class="fa fa-meh-o"></i></button>
                        <button type="button" class="btn btn-white"><i class=" fa fa-paperclip"></i></button>
                    </div>
                    <button id="sendBtn" class="btn btn-theme">Send</button>
                </footer>
            </aside>
            <aside class="right-side">
                <div class="user-head">
                    @include('partials.dashboard._turnOffChatModal')
                    @if($data->user_id === Auth::id()) <!--Shut down group button only visible for group admin-->
                    <button type="button" data-toggle="modal" data-target="#deleteChat" class="chat-tools btn-theme"><i class="fa fa-power-off"></i> </button>
                    @endif
                </div>
                <div class="invite-row">
                    <h4 class="pull-left">Team Members</h4>
                    @if($data->user_id === Auth::id()) <!--Invite button only visible for group admin-->
                    <button data-toggle="modal" data-target="#inviteChat" class="btn btn-theme04 pull-right">+ Invite</button>
                    @endif
                    @include('partials.dashboard._inviteChatModal')
                </div>
                <ul class="chat-available-user" id="sidebar_chatusers">
                    @foreach($data->chat_users as $chat_user)
                    <li>
                        <div class="row">
                            <div class="col-lg-3 col-xs-3" style="margin-right: -10px">
                                <img class="img-circle" src="{{$chat_user->user->provider ?  $chat_user->user->profile_pic : asset('storage/'. $chat_user->user->profile_pic)}}" width="32">
                            </div>
                            <div  class="col-lg-9 col-xs-9">
                                <div class="row">
                                    @if (Auth::id() === $chat_user->user_id)
                                    <span style="font-weight:bold">You</span>
                                    @else
                                    <span style="font-weight:bold">{{$chat_user->user->name}}</span>
                                    @endif
                                </div>
                                <div class="row">
                                  @if ($chat_user->user_id === $data->user_id)
                                  <span class="text-muted">Admin</span>
                                  @endif
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </aside>
        </div>
    </section>
</section>
</section>

<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script class="include" type="text/javascript" src="{{asset('lib/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
<script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('lib/common-scripts.js')}}"></script>

<script src="https://js.pusher.com/6.0/pusher.min.js"></script>

<script>
    var group_id = "{{$data->id}}";
    var my_id = "{{ Auth::id() }}";
    var token = "{{Auth::user() ? Auth::user()->api_token : null}}";
    var appUrl = "{{ env('APP_URL') }}";
    var search = ''; //topic to sort by
    var page = 1;
    var chatUsers = @json($data->chat_users);

    $(document).ready(function() {
        // ajax setup form csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('2dc331b02ea368725332', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            getMsgs();
        });

        function sendMsg(payload) {
            $.ajax({
                    type: "post",
                    url: `${appUrl}/chat_room`, // route to save message
                    data: payload,
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
        }

        $(document).on('click', '#sendBtn', function(e) {
            let message = $('.chat-txt input').val();
            if(message != '' && group_id != '') {
               var datastr = "group_id=" + group_id + "&message=" + message;
               $('.chat-txt input').val('')

               sendMsg(datastr)
            }
        })

        function getMsgs() {
            $.ajax({
                type: "get",
                url: `${appUrl}/api/chat/${group_id}?api_token=${token}`,
                data: "",
                cache: false,
                success: function(data) {
                    $('#message-wrapper').html(null);
                    data.data.chat_msgs.map(function(msg) {
                        //if message is for current user
                        if (msg.user_id == my_id) {
                            $('#message-wrapper').append(
                                `<div class="row" style="margin:auto">
                                <div class="sentmsgbox">
                        <div style="padding: 10px 20px;">
                            <div class="row">
                                ${msg.msg}
                            </div>
                            <div class="row chat-time pull-right">
                                ${msg.created_at}
                            </div>
                        </div>
                 </div>
                 </div>
               `)
                        } else {
                            $('#message-wrapper').append(
                                `
                                <div class="row" style="margin:auto">
                           <div class="recmsgbox">
                        <div style="padding: 10px 20px;">
                            <div class="row" style="font-weight: bold; margin-bottom: 5px">${msg.user.name}</div>
                            <div class="row">
                            ${msg.msg}
                            </div>
                            <div class="row chat-time pull-right">
                                ${msg.created_at}
                            </div>
                        </div>
                    </div>
                    </div>
                           `
                            )
                        }
                    });

                    scrollToBottomFunc();
                }
            });
        }


        $(document).on('keyup', '.chat-txt input', function(e) {
            var message = $(this).val();

            // check if enter key is pressed and message is not null also receiver is selected
            if (e.keyCode == 13 && message != '' && group_id != '') {
                $(this).val(''); // while pressed enter text box will be empty

                var datastr = "group_id=" + group_id + "&message=" + message;
                sendMsg(datastr)
            }
        });
    });

    // make a function to scroll down auto
    function scrollToBottomFunc() {
        $("#message-wrapper").animate({
            scrollTop: $('#message-wrapper').prop("scrollHeight")
        }, 50);
    }
    

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

    function getImageURl(user) {
      if (user.provider) {
          return user.profile_pic;
      }
      return `{{asset('storage/${user.profile_pic}')}}`;
    }

    function getData() {
        $.ajax({
            url: `${appUrl}/api/user?page=${page}&username=${search}`,
            type: 'get',
            success: function(data) {
                $('#modal_ul').html(null);
                data.data.data.map(function(user) {
                  $('#modal_ul').append(`
                  <li>
                        <div>
                            <img class="img-circle" src="${getImageURl(user)}" width="45">
                            ${user.name}
                            <div id="toggle${user.id}" class="pull-right">
                              ${addedOrNot(user.id)}
                            </div>
                        </div>
                    </li>
                    `)

                })//users list

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

     //function to check whether user is already part of the group or not
    function addedOrNot(id) {
      let yes = chatUsers.some(user => user.user_id === id);
      if (yes){
        return `<button data-id="${id}" data-status="1" type="button" class="toggle btn btn-default btn-sm">
                    <i class="fa fa-minus"></i>
                </button>`;
           
      } else {
        return `<button data-id="${id}" data-status="2" type="button" class="toggle btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i>
                </button>`;
      }
    }

    function paginate(data) {
        let list='';
        for(let i=1; i<= data.last_page; i++) {
            list += `<li class="${data.current_page == i ? 'active' : '' }"><a class="pag" data-page="${i}" href="page${i}:;">${i}</a></li>`
        }
        return list;
    }


    $('#modal_ul').on('click', '.toggle', function() {
        let userId = $(this).data('id'); //get id of request
        let status = parseInt($(this).data('status')); //whether user is a member of not

        $.ajax({
            url: `${appUrl}/api/chat_user?api_token=${token}`,
            type: 'post',
            data: {
                'chat_id': group_id,
                'user_id': userId,
                'status' : status
            },
            success: function(data) {
               if (status === 1) {
                  //user is already part of group
                 $('#toggle'+userId).html(
                     `<button data-id="${userId}" data-status="2" type="button" class="toggle btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                      </button>`
                 );      //remove deleted post from view
                }else {
                  //user is not part of group
                  $('#toggle'+userId).html(
                     `<button data-id="${userId}" type="button" data-status="1" class="toggle btn btn-default btn-sm">
                        <i class="fa fa-minus"></i>
                      </button>`
                     
                 );  
                }
            },
            error: function(error) {
                alert("Something went wrong");
            }

        })
    });

    $('.modal-footer').on('click', '#done_btn', function() {
        console.log('clicked')
        //reflecting changes in the sidebar chat users
        $.ajax({
            url: `${appUrl}/api/chat/${group_id}/user?api_token=${token}`,
            type: 'get',
            success: function(data) {
                $('#sidebar_chatusers').html(null)
                data.data.map(function(chat_user) {
                $('#sidebar_chatusers').append(`
                <li>
                        <div class="row">
                            <div class="col-lg-3 col-xs-3" style="margin-right: -10px">
                                <img class="img-circle" src="${getImageURl(chat_user)}" width="32">
                            </div>
                            <div  class="col-lg-9 col-xs-9">
                                <div class="row">
                                ${my_id == chat_user.user_id ? '<span style="font-weight:bold">You</span>' : '<span style="font-weight:bold">'+chat_user.user.name+'</span>'}
                                </div>
                                <div class="row">
                                ${my_id == chat_user.user_id ? '<span class="text-muted">Admin</span>' : ''}
                                </div>
                            </div>
                        </div>
                    </li>`) 
                })
            },
            error: function(error) {}
        })
    })

    sortPosts(document.getElementById('sort_name'));
</script>
@endsection