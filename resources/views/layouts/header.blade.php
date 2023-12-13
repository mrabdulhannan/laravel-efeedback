            <!-- Page header starts -->
            <div class="page-header">

                <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>

                <!-- Breadcrumb start -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="bi bi-house"></i>
                        <a href="{{route('home')}}">Home</a>
                    </li>
                    <li class="breadcrumb-item breadcrumb-active" aria-current="page">Dashboard</li>
                </ol>
                <!-- Breadcrumb end -->
                <!-- Header actions ccontainer start -->
                <div class="header-actions-container">

                    <!-- Header actions start -->
                    <ul class="header-actions">
                        <li class="dropdown">
                            <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                <span class="user-name d-none d-md-block">@auth
                                    {{ Auth::user()->name }}
                                @endauth</span>
                                <span class="avatar">
                                    <img src="{{asset('assets/img')}}/user.png" alt="User Avatar">
                                    <span class="status online"></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <!-- Header actions end -->

                </div>
                <!-- Header actions ccontainer end -->

            </div>
            <!-- Page header ends -->