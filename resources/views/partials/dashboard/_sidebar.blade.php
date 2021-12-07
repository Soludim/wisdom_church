<aside>
    <div id="sidebar" class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">
            <p class="centered">
                <a href="/profile">
                    <img src="{{Auth::user()->provider ? Auth::user()->profile_pic : asset('storage/' . Auth::user()->profile_pic)}}" class="img-circle" width="80">
                </a>
            </p>

            <h5 class="centered">{{Auth::user()->name}}</h5>
            @if(in_array(Auth::user()->role_id, config('app.permissions')))
            <li class="mt">
                <a class="{{Request::path() == 'dashboard'  ? 'active':''}}" href="/dashboard">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @endif
            <li class="sub-menu">
                <a href="javascript:;" class="{{request()->is('post*') ||
                    Request::path() == 'allposts' ? 'active':''}}">
                    <i class="fa fa-tasks"></i>
                    <span>Posts</span>
                </a>
                <ul class="sub">
                    <li class="{{Request::path() == 'post/create' ? 'active':''}}"><a href="/post/create">Create</a></li>
                    <li class="{{Request::path() == 'posts' ? 'active':''}}"><a href="/posts">My Posts</a></li>
                    @if(in_array(Auth::user()->role_id, config('app.permissions')))
                    <li class="{{Request::path() == 'allposts' ? 'active':''}}"><a href="/allposts">All Posts</a></li>
                    @endif
                </ul>
            </li>
            @if(in_array(Auth::user()->role_id, config('app.permissions')))
            <li class="sub-menu">
                <a href="/devents" class="{{request()->is('event*') || request()->is('devent*')  ? 'active':''}}">
                    <i class="fa fa-leaf"></i>
                    <span>Events</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="/members" class="{{Request::path() == 'members' ? 'active':''}}">
                    <i class="fa fa-users"></i>
                    <span>Members</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="/testimonies" class="{{request()->is('testimonies*') ? 'active':''}}">
                    <i class="fa fa-tasks"></i>
                    <span>Testimonies</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="/prayerrequest" class="{{request()->is('prayerrequest*') ? 'active':''}}">
                    <i class="fa fa-shield"></i>
                    <span>Prayer Request</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="/dsermons" class="{{request()->is('dsermon*') || request()->is('sermon*')  ? 'active':''}}">
                    <i class="fa fa-book"></i>
                    <span>Sermons</span>
                </a>
            </li>
            @endif
            <li class="sub-menu">
                <a href="/chat" class="{{request()->is('chat*') ? 'active':''}}">
                    <i class="fa fa-comments-o"></i>
                    <span>Chat Room</span>
                </a>
            </li>
        </ul>
    </div>
</aside>