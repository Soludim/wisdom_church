@extends('main')

@section('title', 'Sermon Single')

@section('content')
<section id="home" class="video-hero js-fullheight" style="height: 700px; background-image: url({{asset('images/bg_1.jpg')}});  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
    <div class="overlay js-fullheight"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="/">Home</a> <span><a href="/sermons">Sermon</a></span></p>
                <h1 class="mb-3 mt-0 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Sermon Single</h1>
            </div>
        </div>
    </div>
</section>

@include('partials._earliestEvent')

<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-11 ftco-animate">
                <h2 class="mb-3">{{$data->sermon->topic}}</h2>
                <div>
                    {!!$data->sermon->content!!}
                </div>
                <br />
                @if($data->sermon->video_url != null)
                <a href="{{$sermon->video_url}}" class="img popup-vimeo mb-3 d-flex justify-content-center align-items-center" style="background-image: url({{asset('storage/'. $sermon->coverImage)}});">
                    <div class="icon d-flex justify-content-center align-items-center">
                        <span class="icon-play"></span>
                    </div>
                </a>
                @endif
                <br />
                <div class="about-author d-flex p-1 bg-light">
                    <div class="bio align-self-md-center mr-3">
                        <img width="100px" height="100px" src="{{asset('storage/'. $data->sermon->speaker_image)}}" alt="Image placeholder" class="img-fluid">
                    </div>
                    <div class="desc align-self-md-center">
                        <h3>{{$data->sermon->speaker_name}}</h3>
                        <p>{{$data->sermon->speaker_position}}</p>
                    </div>
                </div>


                <div class="pt-5 mt-5">
                    @if (count($data->sermon->comments) > 0)
                    <div id="comments{{$data->sermon->id}}" data-count="{{count($data->sermon->comments)}}">
                        <h3 class="mb-5">{{count($data->sermon->comments)}} Comments</h3>
                    </div>
                    @else
                    <div id="comments{{$data->sermon->id}}" data-count="{{count($data->sermon->comments)}}">
                        <h3 class="mb-5">No Comments</h3>
                    </div>
                    @endif
                    <ul class="comment-list" id="like">
                        @if ($data->sermon->comments != null)
                        @foreach($data->sermon->comments as $comment)
                        <li class="comment" id="{{$comment->id}}">
                            <div class="vcard bio">
                                <img src="{{asset('storage/'. $comment->user->profile_pic)}}" alt="">
                            </div>
                            <div class="comment-body">
                                <h3>{{$comment->user->name}}</h3>
                                <div class="meta">{{date('M', strtotime($comment->created_at))}} {{date('d', strtotime($comment->created_at)) }}, {{ date('yy', strtotime($comment->created_at)) }} at {{ date('h:i a', strtotime($comment->created_at)) }}</div>
                                <p>{{$comment->body}}
                                    @if ($comment->user_id === Auth::id())
                                    <span data-id="{{$comment->id}}" style="margin-left:30px; color: #4400aa;cursor:pointer" class="del_comment fa fa-trash-o"></span>
                                    @endif
                                </p>
                                <p class="pull-right" id="comment_like{{$comment->id}}">
                                    <span id="comment_likes_count{{$comment->id}}">{{$comment->likes_count}}</span> <i data-type="App\Comment" data-id="{{$comment->id}}" data-liked="{{$comment->liked_by_auth_user}}" style="cursor:pointer; margin-right:15px" class="like fa {{$comment->liked_by_auth_user ? 'fa-thumbs-up' : 'fa-thumbs-o-up'}}"></i>
                                    <i data-target="#reply_form{{$comment->id}}" style="cursor: pointer;" data-toggle="collapse" class="fa fa-reply"> Reply</i>
                                </p>

                                <!-- Replies start-->

                                <p id="replyCount{{$comment->id}}">
                                    @if(count($comment->replies) > 0)
                                    <a data-toggle="collapse" href="#replies{{$comment->id}}" aria-expanded="false" aria-controls="reply{{$comment->id}}">view all {{count($comment->replies)}} replies <i class="fa fa-reply"></i></a>
                                    @endif
                                </p>
                                <div class="collapse" id="replies{{$comment->id}}">
                                    <ul class="children replies{{$comment->id}}" id="holder{{$comment->id}}" data-count="{{count($comment->replies)}}">
                                        @foreach($comment->replies as $reply)
                                        <li class="comment" id="{{$reply->id}}">
                                            <div class="vcard bio">
                                                <img src="{{asset('storage/'. $reply->user->profile_pic)}}" alt="" />
                                            </div>
                                            <div class="comment-body">
                                                <h3>{{$reply->user->name}}</h3>
                                                <div class="meta">{{date('M', strtotime($reply->created_at))}} {{date('d', strtotime($reply->created_at)) }}, {{ date('yy', strtotime($reply->created_at)) }} at {{ date('h:i a', strtotime($reply->created_at)) }}</div>
                                                <p>{{$reply->body}}
                                                    @if ($reply->user_id === Auth::id())
                                                    <span data-id="{{$reply->id}}" data-cid="{{$comment->id}}" style="margin-left:30px; color: #4400aa;cursor:pointer" class="del_reply fa fa-trash-o"></span>
                                                    @endif
                                                </p>
                                                <p style="margin-top:-30px" class="pull-right" id="reply_like{{$reply->id}}">
                                                    <span id="reply_likes_count{{$reply->id}}">
                                                        {{$reply->likes_count}}
                                                    </span>
                                                    <i data-type="App\Reply" data-id="{{$reply->id}}" data-liked="{{$reply->liked_by_auth_user}}" class="like fa {{$reply->liked_by_auth_user ? 'fa-thumbs-up' : 'fa-thumbs-o-up'}}" style=" margin-right:15px;cursor:pointer"></i>
                                                </p>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Replies ends-->
                                <!-- Reply form start-->
                                <div class="collapse" id="reply_form{{$comment->id}}">
                                    <textarea id="replyMsg{{$comment->id}}" style="font-size:1em" class="form-control" rows="2"></textarea>
                                    <button type="button" class="btn-sm pull-right reply" onclick="addReply({{$comment->id}})">Reply</button>
                                </div>
                                <!-- Reply form end-->
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <!-- END comment-list -->

                    <div class="comment-form-wrap pt-5">
                        <h3 class="mb-5">Leave a comment</h3>
                        <form method="post" id="comment_form" class="p-5 bg-light" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea name="body" id="message" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Post Comment" class="btn  btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- .col-md-11 -->
        </div>
    </div>
</section>
<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script>
    var token = "{{ Auth::user() ? Auth::user()->api_token : null }}";
    var sermon_id = "{{$data->sermon->id}}";
    var appUrl = "{{ env('APP_URL') }}";

    $('#like').on('click', '.like', function() {
        if (!token)
            return window.location.pathname = 'login';
        let type = $(this).data('type');
        let id = $(this).data('id');
        let liked = $(this).data('liked')
        var count;
        if (type == 'App\\Comment')
            count = parseInt($('#comment_likes_count' + id).text())
        else
            count = parseInt($('#reply_likes_count' + id).text())


        $.ajax({
            url: appUrl+'/api/like?api_token=' + token,
            type: 'post',
            data: {
                'liketable_id': id,
                'liketable_type': type,
                'liked': liked
            },
            success: function(data) {
                if (!liked && type == "App\\Comment") {
                    $('#comment_like' + id).html(`
                    <span id="comment_likes_count${id}">${count+1}</span> <i data-type="App\\Comment" data-id="${id}" data-liked="${data.id}" style="cursor:pointer;margin-right:15px" class="like fa fa-thumbs-up"></i>
                                    <i data-target="#reply_form${id}" style="cursor: pointer;" data-toggle="collapse" class="fa fa-reply"> Reply</i>
                                
                    `)
                } else if (liked && type == "App\\Comment") {
                    $('#comment_like' + id).html(`
                    <span id="comment_likes_count${id}">${count-1}</span> <i data-type="App\\Comment" data-id="${id}" data-liked="" style="cursor:pointer;margin-right:15px" class="like fa fa-thumbs-o-up"></i>
                                    <i data-target="#reply_form${id}" style="cursor: pointer;" data-toggle="collapse" class="fa fa-reply"> Reply</i>
                                
                    `)
                } else if (!liked && type == "App\\Reply") {
                    $('#reply_like' + id).html(`
                        <span id="reply_likes_count${id}">${count+1}</span> <i data-type="App\\Reply" data-id="${id}" data-liked="${data.id}" class="like fa fa-thumbs-up" style="cursor:pointer;margin-right:15px"></i>`)
                } else if (liked && type == "App\\Reply") {
                    $('#reply_like' + id).html(`
                        <span id="reply_likes_count${id}">${count-1}</span> <i data-type="App\\Reply" data-id="${id}" data-liked="" class="like fa fa-thumbs-o-up" style="cursor:pointer;margin-right:15px"></i>`)
                }
            },
            error: function(error) {
                alert('something went wrong')
            }
        })
    });

    $('#like').on('click', '.del_comment', function() {
        if (!token)
            return window.location.href = '/login';

        let comment_id = $(this).data('id');
        let comment_confirmation = confirm('Confirm deleting comment');
        var commentCount = $('#comments' + sermon_id).data('count'); //Comment count for a sermon

        if (comment_confirmation) {
            $.ajax({
                url: appUrl+'/api/comment/' + comment_id + '?api_token=' + token,
                type: 'delete',
                success: function(data) {
                    $(`#${comment_id}`).html(null) //remove deleted comment from view

                    $('#comments' + sermon_id).data('count', commentCount - 1) //reduce comment count by 1 and store 
                    //checking to see whether we have more or no comments
                    if (commentCount <= 1) {
                        //no comments
                        $(`#comments${sermon_id}`).html(`<h3 class="mb-5">No Comments</h3>`)
                    } else {
                        $(`#comments${sermon_id}`).html(`
                        <h3 class="mb-5">${commentCount-1} Comments</h3>
                        `)
                    }
                },
                error: function(error) {
                    alert('Deleting comment was unsuccessful')
                }

            })
        }
    })

    $('#like').on('click', '.del_reply', function() {
        if (!token)
            return window.location.href = '/login';

        let reply_id = $(this).data('id');
        var commentId = $(this).data('cid');
        var replyCount = $('#holder' + commentId).data('count'); //Reply count for a comment
        let reply_confirmation = confirm('Confirm deleting reply');

        if (reply_confirmation) {
            $.ajax({
                url: appUrl+'/api/reply/' + reply_id + '?api_token=' + token,
                type: 'delete',
                success: function(data) {
                    $(`#${reply_id}`).html(null) //remove deleted reply message from view

                    $('#holder' + commentId).data('count', replyCount - 1) //reduce replyCount by 1 and store 
                    //checking to see whether we have more or no replies
                    if (replyCount <= 1) {
                        //no replies
                        $(`#replyCount${commentId}`).html(null)
                    } else {
                        $(`#replyCount${commentId}`).html(`
                    <a data-toggle="collapse" href="#replies${commentId}" aria-expanded="false" aria-controls="reply${commentId}">view all ${replyCount-1} replies <i class="fa fa-reply"></i></a>
                     `)

                    }

                },
                error: function(error) {
                    alert('Deleting reply was unsuccessful')
                }
            })
        }
    })

    $('#comment_form').submit(function(e) {
        e.preventDefault();
        if (!token)
            return window.location.href = '/login';
        var commentCount = $('#comments' + sermon_id).data('count'); //Comment count for a sermon

        $.ajax({
            url: appUrl+'/api/comment?api_token=' + token,
            type: 'post',
            data: {
                'commentable_id': sermon_id,
                'commentable_type': 'App\\Sermon',
                'body': $('#message').val()
            },
            success: function(data) {
                $('#message').val('') //reset message to null
                var comment = data.data;

                $('#comments' + sermon_id).data('count', commentCount + 1) //increase comment count by 1 and store 

                //update comment count on view
                $(`#comments${sermon_id}`).html(`
                    <h3 class="mb-5">${commentCount+1} Comments</h3>
                `)

                $('.comment-list').append(`
                <li class="comment" id="${comment.id}">
                            <div class="vcard bio">
                                <img src="{{asset('storage/${comment.user.profile_pic}')}}" alt="">
                            </div>
                            <div class="comment-body">
                                <h3>${comment.user.name}</h3>
                                <div class="meta">${transDate(comment.created_at)}</div>
                                <p>${comment.body}
                                    <span data-id="${comment.id}" style="margin-left:30px; color: #4400aa;cursor:pointer" class="del_comment fa fa-trash-o"></span>
                                </p>
                                <p class="pull-right like" id="comment_like${comment.id}">
                                    <span id="comment_likes_count${comment.id}">${comment.likes_count}</span> <i data-type="App\\Comment" data-id="${comment.id}" data-liked="${comment.liked_by_auth_user}" style="cursor:pointer;margin-right:15px" class="like fa fa-thumbs-o-up"></i>
                                    <i data-target="#reply_form${comment.id}" style="cursor: pointer;" data-toggle="collapse" class="fa fa-reply"> Reply</i>
                                </p>
                                
                                <p id="replyCount${comment.id}">
                                </p>

                                <div class="collapse" id="replies${comment.id}">
                                    <ul class="children replies${comment.id}" id="holder${comment.id}" data-count="0">
                                    </ul>
                                </div>

                                <!-- Reply form start-->
                                <div class="collapse" id="reply_form${comment.id}">
                                    <textarea id="replyMsg${comment.id}" style="font-size:1em" class="form-control" rows="2"></textarea>
                                    <button type="button" class="btn-sm pull-right reply" onclick="addReply(${comment.id})">Reply</button>
                                </div>
                                <!-- Reply form end-->
                            </div>
                        </li>
                `)

            },
            error: function(error) {
                alert('Something went wrong')
            }
        })
    })

    function addReply(id) {
        if (!token)
            return window.location.href = '/login';


        var commentId = id;
        var replyCount = $('#holder' + commentId).data('count') ? $('#holder' + commentId).data('count') : 0; //Reply count for a comment

        $.ajax({
            url: appUrl+'/api/reply?api_token=' + token,
            type: 'post',
            data: {
                'comment_id': commentId,
                'body': $('#replyMsg' + id).val()
            },
            success: function(data) {
                $('#replyMsg' + id).val('') //reset reply msg to null

                var reply = data.data;
                $('#holder' + commentId).data('count', replyCount + 1) //increase replyCount by 1 and store 

                $(`#replyCount${commentId}`).html(`
                    <a data-toggle="collapse" href="#replies${commentId}" aria-expanded="false" aria-controls="reply${commentId}">view all ${replyCount+1} replies <i class="fa fa-reply"></i></a>
                     `)

                $('.replies' + commentId).append(`
                <li class="comment" id="${reply.id}">
                                            <div class="vcard bio">
                                                <img src="{{asset('storage/${reply.user.profile_pic}')}}" alt="" />
                                            </div>
                                            <div class="comment-body">
                                                <h3>${reply.user.name}</h3>
                                                <div class="meta">${transDate(reply.created_at)}</div>
                                                <p>${reply.body}
                                                    <span data-id="${reply.id}" data-cid="${id}" style="margin-left:30px; color: #4400aa;cursor:pointer" class="del_reply fa fa-trash-o"></span>
                                                </p>
                                                <p style="margin-top:-30px" class="pull-right" id="reply_like${reply.id}">
                                                    <span id="reply_likes_count${reply.id}">
                                                        ${reply.likes_count}
                                                    </span>
                                                    <i data-type="App\\Reply" data-id="${reply.id}" data-liked="${reply.liked_by_auth_user}" class="like fa fa-thumbs-o-up" style="cursor:pointer;margin-right:15px"></i>
                                                </p>
                                            </div>
                                        </li>
                `)
            },
            error: function(error) {
                alert(error)
            }
        })
    }

    function transDate(timestamp) {
        let newd = new Date(timestamp);

        let month = newd.toLocaleString('default', {
            month: 'short'
        });
        let day = newd.getDate()
        let year = newd.getFullYear()
        let time = newd.toLocaleTimeString('en-US')
        return month + "  " + day + ", " + year + " at " + time;
    }
</script>
@endsection