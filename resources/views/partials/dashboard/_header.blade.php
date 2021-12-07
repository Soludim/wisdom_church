<header class="header black-bg">
  <div class="sidebar-toggle-box">
    <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
  </div>
  <!--logo start-->
  <a href="/dashboard" class="logo"><b>{{config('app.church_name')}}<span> Church</span></b></a>
  <!--logo end-->
  <div class="top-menu">
    <ul class="nav pull-right top-menu">
      <li class="nav-link" style="margin-top:15px"><a href="/">Index</a></li>
      <li><a class="logout" href="#" onclick="event.preventDefault();
             document.getElementById('logout-form').submit();" style="color:black">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </li>
    </ul>
  </div>
</header>