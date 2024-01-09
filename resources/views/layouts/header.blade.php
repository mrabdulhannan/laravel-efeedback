<style>
    .webnav-bar {
        background: #038199 !important;
    }

    .webnav-bar .navbar-nav .nav-link {
        color: #fff;
        padding: 0 10px;
    }

    .webnav-bar .navbar-nav>a {
        color: #fff;
    }

    .navbar-light .navbar-nav .nav-link.active,
    .navbar-light .navbar-nav .show>.nav-link {
        color: #a3e0ee;
    }

    .webnav-bar a svg {
        width: 2em;
        height: 2em;
    }

    .webnav-bar .navbar-nav .nav-link {
        padding: 10px;
        border-radius: 5px;
        line-height: 1.3;
    }

    .webnav-bar .navbar-nav .nav-link:hover {
        background: #fff;
        color: #038199 !important;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light webnav-bar mb-3">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
                {{-- <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('home') }}" id="homeLink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-house-fill" viewBox="0 0 16 16">
                            <!-- SVG path for the house icon -->
                        </svg>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('home') }}" id="homeLink">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('definetopic') }}" id="feedbackLink"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Feedback
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="feedbackLink">
                        <li><a class="dropdown-item" href="{{ route('definetopic') }}">Create New Assessment</a></li>
                        <li><a class="dropdown-item" href="{{ route('alltopics') }}">Show All Feedbacks</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('mycategories') }}" id="assessmentsLink"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        My Assessments
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="assessmentsLink">
                        <li><a class="dropdown-item" href="{{ route('mycategories') }}">My Categories</a></li>
                        <li><a class="dropdown-item" href="{{ route('newassesment') }}">Write New Feedback</a></li>
                    </ul>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('rubrics') }}" id="rubricsLink">Rubrics</a>
                </li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('rubrics') }}" id="rubricsLink"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Rubrics
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="assessmentsLink">
                        <li><a class="dropdown-item" href="{{ route('rubrics') }}">Define Rubrics</a></li>
                        <li><a class="dropdown-item" href="{{ route('tutorialpresentation') }}">Tutorial Presentation</a></li>
                    </ul>
                </li>
            </ul>
            <div class="header-actions-container">
                <!-- Header actions start -->
                <ul class="header-actions">
                    <!-- Your existing header actions -->
                </ul>
                <!-- Header actions end -->
            </div>
            <div class="header-actions-container">
                <!-- Header actions start -->
                <ul class="header-actions">
                    <li class="dropdown">
                        <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown"
                            aria-haspopup="true">
                            <span class="user-name d-none d-md-block text-white">@auth
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
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current URL path
        var path = window.location.pathname;

        // Define the route names associated with each navigation item
        var routeNames = {
            'home': 'homeLink',
            'mycategories': 'assessmentsLink',
            'definetopic': 'feedbackLink',
            'alltopics': 'feedbackLink',
            'newassesment': 'assessmentsLink',
            'rubrics': 'rubricsLink'
        };

        // Find the corresponding route name and add the 'active' class
        var activeLinkId = routeNames[path.replace('/', '')];
        if (activeLinkId) {
            // Remove 'active' class from all nav links
            document.querySelectorAll('.nav-link').forEach(function(link) {
                link.classList.remove('active');
            });

            // Add 'active' class to the current nav link
            document.getElementById(activeLinkId).classList.add('active');
        }
    });
</script>
