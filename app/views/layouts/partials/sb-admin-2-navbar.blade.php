<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Pageant Manager Administration</a>
    </div>
    {{-- /.navbar-header --}}

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> {{ Auth::user()->username }} <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> Profile</a></li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                <li class="divider"></li>
                <li>
                    <a href="#" id="logoutTrigger"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            {{-- /.dropdown-user --}}
        </li>
        {{-- /.dropdown --}}
    </ul>
    {{-- /.navbar-top-links --}}

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </li>
                <li>
                    <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ action('UsersController@getIndex') }}"><i class="fa fa-users fa-fw"></i> Users</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-trophy fa-fw"></i> Events<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ action('EventsController@getIndex') }}"><i class="fa fa-list fa-fw"></i> Manage</a>
                        </li>
                        <li>
                            <a href="{{ action('ContestantsController@getIndex') }}"><i class="fa fa-star fa-fw"></i> Contestants</a>
                        </li>
                        <li>
                            <a href="/admin/judges"><i class="fa fa-gavel fa-fw"></i> Judges</a>
                        </li>
                        <li>
                            <a href="/admin/moderators"><i class="fa fa-circle-o fa-fw"></i> Moderators</a>
                        </li>
                    </ul>
                    {{-- /.nav-second-level --}}
                </li>
                <li>
                    <a href="#"><i class="fa fa-cogs fa-fw"></i> Settings</a>
                </li>
            </ul>
        </div>
        {{-- /.sidebar-collapse --}}
    </div>
    {{-- /.navbar-static-side --}}
</nav>