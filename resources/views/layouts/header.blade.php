            <!-- Page header starts -->
            <div class="page-header">

                <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>
                <style>
                    .header-menu {
                        padding: 10px;
                    }

                    .breadcrumb {
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }

                    .breadcrumb-item {
                        display: inline-block;
                        margin-right: 10px;
                        position: relative;
                    }

                    .breadcrumb-item a {
                        text-decoration: none;
                        color: black;
                        display: block;
                        position: relative;
                    }

                    .breadcrumb-item i {
                        margin-right: 5px;
                        display: inline-block;
                    }

                    .breadcrumb-item.breadcrumb-active {
                        font-weight: bold;
                        color: #007bff;
                        /* Change the color to your preference */
                    }

                    .submenu {
                        display: none;
                        position: absolute;
                        top: 100%;
                        left: 0;
                        background-color: white;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        z-index: 1;
                        list-style-type: none;
                        padding: 0;
                    }

                    .breadcrumb-item:hover .submenu {
                        display: block;
                    }

                    .breadcrumb-item.has-submenu::after {
                        content: "▼";
                        font-size: 0.8em;
                        margin-left: 5px;
                    }

                    .submenu-item {
                        padding: 10px;
                        border-bottom: 1px solid #ddd;
                    }

                    .submenu-item a {
                        text-decoration: none;
                        color: black;
                        display: block;
                    }
                </style>

                <script>
                    $(document).ready(function() {
                        // Set active state based on the current URL
                        var currentURL = window.location.href;

                        // Function to set active state for menu items
                        function setActiveState(url) {
                            $(".breadcrumb-item").removeClass("breadcrumb-active");
                            $(".submenu-item").removeClass("breadcrumb-active");

                            $(".breadcrumb-item a[href='" + url + "']").parent().addClass("breadcrumb-active");
                            $(".submenu-item a[href='" + url + "']").parent().addClass("breadcrumb-active");
                        }

                        // Set active state on page load
                        setActiveState(currentURL);

                        // Add click event handler for breadcrumb items
                        $(".breadcrumb-item a").on("click", function() {
                            var menuItemURL = $(this).attr("href");
                            setActiveState(menuItemURL);
                        });

                        // Add click event handler for submenu items
                        $(".submenu-item a").on("click", function() {
                            var submenuItemURL = $(this).attr("href");
                            var mainMenuItemURL = $(this).closest(".breadcrumb-item").find("a").attr("href");
                            setActiveState(mainMenuItemURL);
                        });
                    });
                </script>




                <div class="header-menu ps-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item btn btn-success">
                            {{-- <i class="bi bi-house"></i> --}}
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        
                        <li class="breadcrumb-item has-submenu btn btn-success">
                            {{-- <i class="bi bi-chat-right-text"></i> --}}
                            <a href="{{ route('definetopic') }}">My Assessments</a>
                            <div class="submenu">
                                <!-- Include submenu items from the sidebar -->
                                <div class="submenu-item"><a href="{{ route('definetopic') }}">Create New Assessment</a></div>
                                <div class="submenu-item"><a href="{{ route('alltopics') }}">Show All</a></div>
                            </div>
                        </li>

                        <li class="breadcrumb-item has-submenu btn btn-success">
                            {{-- <i class="bi bi-chat-right-text"></i> --}}
                            <a href="{{ route('definecategories') }}">Feedback</a>
                            <div class="submenu">
                                <!-- Include submenu items from the sidebar -->
                                <div class="submenu-item"><a href="{{ route('definecategories') }}">Define
                                        Categories</a></div>
                                <div class="submenu-item"><a href="{{ route('mycategories') }}">My Categories</a></div>
                                <div class="submenu-item"><a href="{{ route('newassesment') }}">Write New Feedback</a></div>
                            </div>
                        </li>

                        <li class="breadcrumb-item btn btn-success">
                            {{-- <i class="bi bi-chat-right-text"></i> --}}
                            <a href="{{ route('rubrics') }}">Rubrics</a>
                            
                        </li>
                    </ol>
                </div>

                <div class="header-actions-container">
                    <!-- Header actions start -->
                    <ul class="header-actions">
                        <li class="dropdown">
                            <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown"
                                aria-haspopup="true">
                                <span class="user-name d-none d-md-block">@auth
                                        {{ Auth::user()->name }}
                                    @endauth
                                </span>
                                <span class="avatar">
                                    <img src="{{ asset('assets/img') }}/user.png" alt="User Avatar">
                                    <span class="status online"></span>
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                                <div class="header-profile-actions">
                                    <a href="{{ route('updatepassword') }}">Update Password</a>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>

                                </div>
                            </div>

                        </li>
                        <li>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                                <div class="header-profile-actions">
                                    <a href="login.html">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- Header actions end -->

                </div>
                <!-- Header actions ccontainer end -->

            </div>
            <!-- Page header ends -->
