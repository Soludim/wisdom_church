<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="flaticon-cross"></i> <span>{{config('app.church_name')}}</span> <span>Church</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{Request::is('/') ? 'active':''}}"><a href="/" class="nav-link">Home</a></li>
                <li class="nav-item {{Request::is('about') ? 'active':''}}"><a href="/about" class="nav-link">About</a></li>
                <li class="nav-item {{Request::is('event*') ? 'active':''}}"><a href="/events" class="nav-link">Events</a></li>
                <li class="nav-item {{Request::is('sermon*') ? 'active':''}}"><a href="/sermons" class="nav-link">Sermons</a></li>
                <li class="nav-item {{Request::is('blog*') || request()->is('post*') ? 'active':''}}"><a href="/blog" class="nav-link">Blog</a></li>
                <li class="nav-item {{Request::is('contact') ? 'active':''}}"><a href="/contact" class="nav-link">Contact</a></li>
                @if (!Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="/login">
                            Login
                        </a>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                            Hi {{Auth::user()->name}}
                        </a>
                        <div class="dropdown-menu">
                            <a class="nav-link dropdown-item" href="/dashboard" style="color:black">
                                <i class="fa fa-dashboard"></i> Dashboard</a>
                            <a class="nav-link dropdown-item" href="#" onclick="event.preventDefault();
             document.getElementById('logout-form').submit();" style="color:black">
                                <i class="fa fa-power-off"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                    @endif
            </ul>
        </div>
    </div>
</nav>