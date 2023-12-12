<!-- Sidebar wrapper start -->
<nav class="sidebar-wrapper">
    <!-- Sidebar brand starts -->
    <div class="sidebar-brand">
        <a href="{{route('home')}}" class="logo">
            <h4>eFeedback</h4>
        </a>
    </div>
    <!-- Sidebar brand starts -->
    <!-- Sidebar menu starts -->
    <div class="sidebar-menu">
        <div class="sidebarMenuScroll">
            <ul>
                <li class="active">
                    <a href="{{ route('home') }}">
                        <i class="bi bi-house"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-chat-right-text"></i>
                        <span class="menu-text">Feedback Mgmt</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="addfeedback.html">Define Categories</a>
                            </li>
                            <li>
                                <a href="listview.html">My Categories</a>
                            </li>
                            <li>
                                <a href="sidebarlistview.html">New Assessment</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{route('login')}}">
                        <i class="bi bi-arrow-bar-right"></i>
                        <span class="menu-text">Logout</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('login')}}">
                        <i class="bi bi-file-lock"></i>
                        <span class="menu-text">Login</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('register')}}">
                        <i class="bi bi-file-person"></i>
                        <span class="menu-text">Register</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Sidebar menu ends -->

</nav>
