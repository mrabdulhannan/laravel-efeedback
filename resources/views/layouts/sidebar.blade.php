<!-- Sidebar wrapper start -->
<nav class="sidebar-wrapper" style="display: none">
    <!-- Sidebar brand starts -->
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" class="logo">
            <h4>eFeedback</h4>
        </a>
    </div>
    <!-- Sidebar brand starts -->
    <!-- Sidebar menu starts -->
    <div class="sidebar-menu" >
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
                                <a href="{{route('definecategories')}}">Define Categories</a>
                            </li>
                            <li>
                                <a href="{{route('mycategories')}}">My Categories</a>
                            </li>
                            <li>
                                <a href="{{route('newassesment')}}">New Assessment</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-chat-right-text"></i>
                        <span class="menu-text">Topics Mgmt</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{route('definetopic')}}">Add Topic</a>
                            </li>
                            <li>
                                <a href="{{route('alltopics')}}">All Topics</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li>
                    <a href="{{route('log-in')}}">
                        <i class="bi bi-file-lock"></i>
                        <span class="menu-text">Login</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('updatepassword')}}">
                        <i class="bi bi-file-person"></i>
                        <span class="menu-text">Update Password</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="bi bi-arrow-bar-right"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                </li>
            </ul>
        </div>
    </div>
    <!-- Sidebar menu ends -->

</nav>
