<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Pageant Manager</title>

    {{ HTML::style('/css/bootstrap.min.css') }}
    {{ HTML::style('/sb-admin-2/css/metisMenu.min.css') }}
    {{ HTML::style('/sb-admin-2/css/sb-admin-2.css') }}
    {{ HTML::style('/font-awesome-4.3.0/css/font-awesome.min.css') }}

    <style type="text/css">
        body{
            padding-top: 50px;
        }
        input, textarea, select {
            max-width: 280px;
        }
    </style>

</head>

<body>

    <div id="wrapper">

        {{-- Navigation --}}
        @include('layouts.moderator.partial_navbar')

        {{-- Page Content --}}
        <div id="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
            {{-- /.container-fluid --}}
        </div>
        {{-- /#page-wrapper --}}

    </div>
    {{-- /#wrapper --}}

    @section('modals')
        {{-- modal markups --}}
    @show

    @section('forms')
        {{-- forms --}}
        {{Form::open(array('url' => '/logout', 'method' => 'POST', 'id' => 'logoutForm'))}}
            {{-- form to for logout --}}
        {{Form::close()}}
    @show

    @section('scripts')
        {{-- scritps --}}
        {{ HTML::script('/js/jquery-2.1.3.min.js') }}
        {{ HTML::script('/js/bootstrap.min.js') }}
        {{ HTML::script('/sb-admin-2/js/metisMenu.min.js') }}
        {{ HTML::script('/sb-admin-2/js/sb-admin-2.js') }}
        <script>
        $(function()
        {
            $('#logoutTrigger').click(function()
            {
                $('#logoutForm').submit();
            });
        });
        </script>
    @show

</body>

</html>
