@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body" style="display: flex;
                    justify-content: center;">
                        <div class="photo-holder">
                            <img src="{{ isset(Auth::user()->profile_image) ? asset('storage/' . Auth::user()->profile_image) : asset('assets/images/avatars/avatar-login.png') }}"
                                alt="Profile Picture" class="rounded-circle" width="210">
                            <div id="profile-picture">
                                <i class="fadeIn animated bx bx-camera"></i> <br>
                                CHANGE<br> PROFILE PHOTO
                            </div>
                        </div>
                    </div>
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        
                        <form method="POST" action="{{ route('updatepassword') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">

                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ Auth::user()->email ?? old('email') }}" required autocomplete="email"
                                        autofocus readonly>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Current Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="new_password" class="col-md-4 col-form-label text-md-end">New Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="new_password" required>
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div>
                    <style type="text/css">
                        .photo-holder {
                            background: #1c2a2d;
                            position: relative;
                            border-radius: 50%;
                            border: 1px solid #1c2a2d;
                            width: 200px;
                        }

                        .photo-holder div {
                            position: absolute;
                            left: 50%;
                            top: 50%;
                            transform: translate(-50%, -50%);
                            opacity: 0;
                            max-width: 200px;
                        }

                        .photo-holder:hover img {
                            opacity: 60%;
                        }

                        .photo-holder:hover div {
                            opacity: 1;
                            cursor: pointer;
                            color: white;
                        }

                        .photo-holder:hover i {
                            font-size: 30px;
                        }
                    </style>
                    

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('profile-picture').addEventListener('click', function() {
                                document.getElementById('profile-picture-input').click();
                            });

                            document.getElementById('profile-picture-input').addEventListener('change', function() {
                                document.getElementById('profile-picture-form').submit();
                            });
                        });
                    </script>

                    <form method="POST" action="{{ route('updateImage') }}" enctype="multipart/form-data"
                        id="profile-picture-form">
                        @csrf
                        <input type="file" name="profile_picture" id="profile-picture-input" style="display: none;">
                        <input type="hidden" name="profile_picture_del"
                            value="{{ isset(Auth::user()->profile_image) ? asset('storage/' . Auth::user()->profile_image) : '' }}"
                            id="profile_picture_del">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
