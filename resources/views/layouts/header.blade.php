<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>eMasa</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>eMasa</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('images/nobody_m_160x160.jpg') }}" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{(Auth::user()->xtraAnggota) ? Auth::user()->xtraAnggota->nama : Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                    <img src="{{ asset('images/nobody_m_160x160.jpg') }}" class="img-circle" alt="User Image">

                    <p>
                        @if (Auth::user()->email === env('PCRS_DEFAULT_USER_ADMIN', 'admin@internal'))
                            <small>Sistem Administrator</small>
                        @else
                            <small>{{ ucfirst(Auth::user()->xtraAnggota->jawatan) }}</small>
                        @endif
                        <small>Member since {{ Auth::user()->created_at->shortLocaleMonth }} {{ Auth::user()->created_at->year }}</small>
                    </p>
                    </li>
                    <li class="user-body">
                        <div class="row">
                            <div class="col-xs-12">
                                Peranan Semasa : <b>{{ strtoupper(Auth::user()->perananSemasa()->name) }}</b>
                            </div>
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                    <div class="pull-left">
                        <a href="#" class="btn btn-default btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Sign out</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    </li>
                </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
