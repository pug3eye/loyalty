<header class="main-header">
    <!-- shopname -->
    <a class="logo"><b>{{ Auth::user()->name }}</b></a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li><a href={{ url('/logout') }}>Log Out</a></li>
            </ul>
        </div>
    </nav>
</header>
