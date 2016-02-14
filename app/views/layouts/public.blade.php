<html>
<head>
	<title>Miss Ilocos Norte 2015</title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">

	<style type="text/css">
		body {
			padding-top: 70px;
		}
		input, textarea, select {
			max-width: 280px;
		}
	</style>
</head>
<body>
	
	<nav class="navbar navbar-default navbar-fixed-top">
		
	  <div class="container-fluid">
	    {{-- Brand and toggle get grouped for better mobile display --}}
	    <div class="container">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="/">Miss Ilocos Norte 2015</a>
	    </div>
	      <ul class="nav navbar-nav navbar-right">
	      	@if(!Auth::check())
		        <li><a href="/login">Login</a></li>
		        <li><a href="/register">Register</a></li>
	        @else
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Welcome, {{ Auth::user()->username }} <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	          	<li><a href="/profile">Account</a></li>
	          	<li><a href="/profile/edit">Edit Account</a></li>
	          	<li><a href="/profile/change-password">Change Password</a></li>
	          	@if(Auth::user()->role->id == 1)
	            	<li><a href="/admin/users"><i class="fa fa-institution fa-fw"></i> Admin Page</a></li>
	            @endif
	            <li class="divider"></li>
	            <li><a href="#" id="logoutTrigger">Log out</a></li>
	          </ul>
	        </li>
	        @endif
	      </ul>
	      </div>
	    </div>{{-- /.navbar-collapse --}}
	    
	</nav>

	<div class="container">
		@yield('content')
	</div>

	@section('forms')
        {{-- forms --}}
        {{Form::open(array('url' => '/logout', 'method' => 'POST', 'id' => 'logoutForm'))}}
            {{-- form to for logout --}}
        {{Form::close()}}
    @show

	<script type="text/javascript" src="/js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>

	<script>
    $(function()
    {
        $('#logoutTrigger').click(function()
        {
            $('#logoutForm').submit();
        });
    });
    </script>

</body>
</html>