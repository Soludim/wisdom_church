<div aria-hidden="true" aria-labelledby="inviteChatModal" role="dialog" tabindex="-1" id="inviteChat" class="modal fade">
    <div class="modal-dialog modal-dialog-centered" style="width: 60%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add People</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times;</span>
                </button>
                <div class="pull-right position">
                    <input type="text" id="sort_name" autocomplete="off" placeholder="Search" class="form-control search-btn ">
                </div>
            </div>
            <div class="modal-body" style="overflow-y:auto; height:300px">
                <ul class="chat-available-user" id="modal_ul">
                    @foreach($users->data as $user)
                    <li>
                        <div>
                            <img class="img-circle" src="{{$user->provider ?  $user->profile_pic : asset('storage/' . $user->profile_pic)}}" width="45">
                            {{$user->name}}
                            <div class="pull-right" id="toggle{{$user->id}}">
                                @for($i=0; $i < count($data->chat_users); $i++)
                                    @if($data->chat_users[$i]->user_id === $user->id)
                                    <button data-status="1" data-id="{{$user->id}}" type="button" class="toggle btn btn-default btn-sm {{$data->chat_users[$i]->user_id === $data->user_id ? 'disabled' : ''}}">
                                        <!--Keep admin button disabled-->
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    @break
                                    @elseif($i >= count($data->chat_users)-1)
                                    <button data-status="2" data-id="{{$user->id}}" type="button" class="toggle btn btn-primary btn-sm">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    @endif
                                    @endfor
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @if($users->last_page > 1)
                <div class="row-fluid" id="paginator">
                    <div class="dataTables_info">Showing {{$users->from}} to {{$users->to}} of {{$users->total}} entries</div>
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <li class="prev {{$users->prev_page_url == null ? 'disabled' : ''}}"><a class="pag" data-page="{{$users->current_page - 1}}" href="javascript:;">← Previous</a></li>
                            @for($i=1; $i <= $users->last_page; $i++)
                                <li class="{{ $users->current_page == $i ? 'active' : '' }}"><a class="pag" data-page="{{$i}}" href="javascript:;">{{$i}}</a></li>
                                @endfor
                                <li class="next {{$users->next_page_url == null ? 'disabled' : ''}}"><a class="pag" data-page="{{$users->current_page + 1}}" href="javascript:;">Next → </a></li>
                        </ul>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" id="done_btn" class="btn btn-theme" type="button">Done</button>
            </div>
        </div>
    </div>
</div>