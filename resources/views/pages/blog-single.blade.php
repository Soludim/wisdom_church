@extends('main')

@section('title', 'Blog Single')

@section('content')
<section id="home" class="video-hero js-fullheight" style="height: 700px; background-image: url({{asset('images/bg_1.jpg')}});  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
    <div class="overlay js-fullheight"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
            <div class="col-md-10 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                <p class="breadcrumbs mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="/">Home</a></span>  <span><a href="/blog">Blog</a></span></p>
                <h1 class="mb-3 mt-0 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Blog Single</h1>
            </div>
        </div>
    </div>
</section>

@include('partials._earliestEvent')

<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ftco-animate">
                <h2 class="mb-3"> {{$data->post->title}}</h2>

                <div>
                    {!!$data->post->content!!}
                </div>

                <div class="about-author d-flex p-1 bg-light">
                    <div class="bio align-self-md-center mr-3">
                        <img width="100px" height="100px" src="{{asset('storage/'.$data->post->user->profile_pic)}}" alt="" class="img-fluid">
                    </div>
                    <div class="desc align-self-md-center">
                        <h3>{{$data->post->user->name}}</h3>
                        <p>{{$data->post->user->email}}</p>
                    </div>
                </div>


                <div class="pt-5 mt-5">
                @if (count($data->post->comments) > 0)
                    <div id="comments{{$data->post->id}}" data-count="{{count($data->post->comments)}}">
                        <h3 class="mb-5">{{count($data->post->comments)}} Comments</h3>
                    </div>
                    @else
                    <div id="comments{{$data->post->id}}" data-count="{{count($data->post->comments)}}">
                        <h3 class="mb-5">No Comments</h3>
                    </div>
                    @endif
                    <ul class="comment-list" id="like">
                    @if ($data->post->comments != null)
                        @foreach($data->post->comments as $comment)
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
                                <p class="pull-right like" id="comment_like{{$comment->id}}">
                                    <span id="comment_likes_count{{$comment->id}}">{{$comment->likes_count}}</span> <i data-type="App\Comment" data-id="{{$comment->id}}" data-liked="{{$comment->liked_by_auth_user}}" style="cursor:pointer;margin-right:15px" class="like fa {{$comment->liked_by_auth_user ? 'fa-thumbs-up' : 'fa-thumbs-o-up'}}"></i>
                                    <i data-target="#reply_form{{$comment->id}}" style="cursor: pointer;" data-toggle="collapse" class="fa fa-reply"> Reply</i>
                                </p>

                                <!-- Replies start-->
                                @if($comment->replies != null)
                                <p id="replyCount{{$comment->id}}">
                                    <a data-toggle="collapse" href="#replies{{$comment->id}}" aria-expanded="false" aria-controls="reply{{$comment->id}}">view all {{count($comment->replies)}} replies <i class="fa fa-reply"></i></a>
                                </p>
                                <div class="collapse" id="replies{{$comment->id}}">
                                    <ul class="children" id="holder{{$comment->id}}" data-count="{{count($comment->replies)}}">
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
                                                <p class="pull-right like" id="reply_like{{$reply->id}}">
                                                    <span id="reply_likes_count{{$reply->id}}">
                                                        {{$reply->likes_count}}
                                                    </span>
                                                    <i data-type="App\Reply" data-id="{{$reply->id}}" data-liked="{{$reply->liked_by_auth_user}}" class="like fa {{$reply->liked_by_auth_user ? 'fa-thumbs-up' : 'fa-thumbs-o-up'}}" style="cursor:pointer;margin-right:15px"></i>
                                                </p>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
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
            </div> <!-- .col-md-8 -->

            <div class="col-md-4 sidebar ftco-animate order-first">
                <div class="sidebar-box">
                    <form action="#" class="search-form">
                        <div class="form-group">
                            <span class="icon fa fa-search"></span>
                            <input type="text" class="form-control" placeholder="Search Post By Title">
                        </div>
                    </form>
                </div>
                <div class="sidebar-box ftco-animate">
                    <div class="categories">
                        <h3>Categories</h3>
                        @foreach($data->category_posts as $cat_post)
                        <li><a href="#">{{$cat_post->name}} <span>{{$cat_post->posts_count}}</span></a></li>
                        @endforeach
                    </div>
                </div>

                <div class="sidebar-box ftco-animate">
                    @if($data->latest_posts != null)
                    <h3>Recent Blog</h3>
                    @foreach($data->latest_posts as $post)
                    <div class="block-21 mb-4 d-flex">
                        <a class="blog-img mr-4" href="{{url('/post/' . Crypt::encrypt($post->id))}}" style="background-image: url({{asset('storage/'.$post->coverImage)}});"></a>
                        <div class="text">
                            <h3 class="heading">
                                <a href="{{url('/post/' . Crypt::encrypt($post->id))}}">
                                @if (strlen($post->title) < 30)
                                    {{$post->title}}
                                    @else
                                      {{substr($post->title, 0, 30)}} ...
                                    @endif
                                </a>
                            </h3>
                            <div class="meta">
                                <div><span class="icon-calendar"></span> {{date('F', strtotime($post->created_at))}} {{date('d', strtotime($post->created_at)) }}, {{ date('yy', strtotime($post->created_at)) }}</div>
                                <div><span class="icon-person"></span>
                                    {{$post->user->initials}}</div>
                                <div><span class="icon-chat"></span> {{$post->comments_count}}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script>
    var token = "{{ Auth::user() ? Auth::user()->api_token : null }}";
    var appUrl = "{{ env('APP_URL') }}";
    var post_id = "{{$data->post->id}}";
    
    $('#like').on('click', '.like', function() {
        if (!token)
            return window.location.href = '/login';
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
        var commentCount = $('#comments' + post_id).data('count'); //Comment count for a post

        if (comment_confirmation) {
            $.ajax({
                url: appUrl+'/api/comment/' + comment_id + '?api_token=' + token,
                type: 'delete',
                success: function(data) {
                    $(`#${comment_id}`).html(null) //remove deleted comment from view

                    $('#comments' + post_id).data('count', commentCount - 1) //reduce comment count by 1 and store 
                    //checking to see whether we have more or no comments
                    if (commentCount <= 1) {
                        //no comments
                        $(`#comments${post_id}`).html(`<h3 class="mb-5">No Comments</h3>`)
                    } else {
                        $(`#comments${post_id}`).html(`
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
        var commentCount = $('#comments' + post_id).data('count'); //Comment count for a post

        $.ajax({
            url: appUrl+'/api/comment?api_token=' + token,
            type: 'post',
            data: {
                'commentable_id': post_id,
                'commentable_type': 'App\\Post',
                'body': $('#message').val()
            },
            success: function(data) {
                $('#message').val('') //reset message to null
                var comment = data.data;

                $('#comments' + post_id).data('count', commentCount + 1) //increase comment count by 1 and store 

                //update comment count on view
                $(`#comments${post_id}`).html(`
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
        var replyCount = $('#holder' + commentId).data('count') ? $('#holder' + commentId).data('count') : 0;//Reply count for a comment

        $.ajax({
            url: appUrl+'/api/reply?api_token=' + token,
            type: 'post',
            data: {
                'comment_id': commentId,
                'body': $('#replyMsg'+id).val()
            },
            success: function(data) {
                $('#replyMsg'+id).val('') //reset reply msg to null
                
                var reply = data.data;
                $('#holder' + commentId).data('count', replyCount + 1) //increase replyCount by 1 and store 
 
                 $(`#replyCount${commentId}`).html(`
                    <a data-toggle="collapse" href="#replies${commentId}" aria-expanded="false" aria-controls="reply${commentId}">view all ${replyCount+1} replies <i class="fa fa-reply"></i></a>
                     `)
                
                $('.replies'+commentId).append(`
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
        let newd = new  Date(timestamp);

        let year = newd.getFullYear()
        let month = newd.toLocaleString('default', {month: 'short'});
        let day = newd.getDate();
        let time = newd.toLocaleTimeString('en-US')
      return month +"  " + day + ", " + year + " at " + time;
    }
</script>
@endsection