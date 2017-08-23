<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>What to Watch Portal</title>

    <link href="/public/css/bootstrap.css" rel="stylesheet">
    <link href="/public/css/sb-admin.css" rel="stylesheet">
    <link href="/public/css/plugins/morris.css" rel="stylesheet">
    <link href="/public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/public/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="/public/css/portal.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/bootstrap.js"></script>
    <script src="/public/js/jquery.dataTables.min.js"></script>
    
    

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">What to Watch Admin</a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                         @if (Auth::guest())
                            <li><a href="/user">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user"></i>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if (Auth::user()->role === 'Admin')
                                        <li {{ (request_is('users') ? 'class=active' : '') }}>
                                            <a href="/users">Users</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="/logout">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        @endif                       
                    </ul>
                </div>
            <?php 
                function request_is($value)
                {
                    return (strtolower(explode("/", Request::path() )[0]) == $value) ;
                }

            ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li {{ (request_is('country') ? 'class=active' : '') }}>
                        <a href="/country">Country</a>
                    </li>
                    <li {{ (request_is('city') ? 'class=active' : '') }}>
                        <a href="/city">City</a>
                    </li>
                    <li {{ (request_is('genre') ? 'class=active' : '') }}>
                        <a href="/genre">Genre</a>
                    </li>
                    <li {{ (request_is('language') ? 'class=active' : '') }}>
                        <a href="/language">Language</a>
                    </li>
                    <li {{ (request_is('creator') ? 'class=active' : '') }}>
                        <a href="/creator">Creator</a>
                    </li>
                    <li {{ (request_is('person') ? 'class=active' : '') }}>
                        <a href="/person">Person</a>
                    </li>
                    <li {{ (request_is('character') ? 'class=active' : '') }}>
                        <a href="/character">Character</a>
                    </li>
                    <li {{ (request_is('series') ? 'class=active' : '') }}>
                        <a href="/series">Series</a>
                    </li>
                    <li {{ (request_is('season') ? 'class=active' : '') }}>
                        <a href="/season">Season</a>
                    </li>
                    <li {{ (request_is('episode') ? 'class=active' : '') }}>
                        <a href="/episode">Episode</a>
                    </li>
                    <li {{ (request_is('soundtracks') ? 'class=active' : '') }}>
                        <a href="/soundtracks">Soundtracks</a>
                    </li>
                     <li {{ (request_is('DidYouKnow') ? 'class=active' : '') }}>
                        <a href="/DidYouKnow">DidYouKnow</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
            @yield('content')
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


<script type="text/javascript">
    $(document).ready(function() {
        $('table').DataTable();
    } );
</script>

</body>
</html>
