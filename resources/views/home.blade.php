@extends('layouts.app')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <!-- Row start -->
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Dashboard</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xxl-12">
                                    <div class="custom-tabs-container">
                                        <ul class="nav nav-tabs" id="customTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab-one" data-bs-toggle="tab"
                                                    href="#one" role="tab" aria-controls="one"
                                                    aria-selected="true">Leadership</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="tab-two" data-bs-toggle="tab" href="#two"
                                                    role="tab" aria-controls="two" aria-selected="false"
                                                    tabindex="-1">Marketing</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="tab-three" data-bs-toggle="tab" href="#three"
                                                    role="tab" aria-controls="three" aria-selected="false"
                                                    tabindex="-1">Organizational Behaviour</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="customTabContent">
                                            <div class="tab-pane fade active show" id="one" role="tabpanel"
                                                aria-labelledby="tab-one">
                                                <table class="table">
                                                    <tr>
                                                        <th width="250" valign="middle">Total assessments</th>
                                                        <td><input type="text" class="form-control" value="100" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="250" valign="middle">Today’s Date</th>
                                                        <td><input type="text" class="form-control"
                                                                value="12th December, 2023" /></td>
                                                    </tr>
                                                    <tr>
                                                        <th width="250" valign="middle">Targeted date of completion</th>
                                                        <td><input type="text" class="form-control"
                                                                value="16th December, 2023" /></td>
                                                    </tr>
                                                    <tr>
                                                        <th width="250" valign="middle">Days remaining</th>
                                                        <td><input type="text" class="form-control" value="6" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="250" valign="middle">Provided feedback</th>
                                                        <td><input type="text" class="form-control" value="20" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="two" role="tabpanel"
                                                aria-labelledby="tab-two">
                                                <p>Dashboard here...</p>
                                            </div>
                                            <div class="tab-pane fade" id="three" role="tabpanel"
                                                aria-labelledby="tab-three">
                                                <p>Dashboard here...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->
        </div>
        <!-- Content wrapper end -->
    </div>
    
@endsection
