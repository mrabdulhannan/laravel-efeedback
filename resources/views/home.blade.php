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
                                            @foreach (Auth::user()->definetopic as $key => $topic)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link {{ $key === 0 ? 'active' : '' }}"
                                                        data-bs-toggle="tab" href="#tab-{{ $topic->id }}" role="tab"
                                                        aria-controls="tab-{{ $topic->id }}"
                                                        aria-selected="{{ $key === 0 ? 'true' : 'false' }}">{{ $topic->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{-- <ul class="nav nav-tabs" id="customTab" role="tablist">
                                            @foreach (Auth::user()->definetopic as $topic)
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="tab-one" data-bs-toggle="tab"
                                                    href="{{$topic->id}}" role="tab" aria-controls="one"
                                                    aria-selected="true">{{$topic->title}}</a>
                                            </li>
                                            @endforeach
                                        </ul> --}}

                                        <div class="tab-content" id="customTabContent">
                                            @foreach (Auth::user()->definetopic as $key => $topic)
                                                <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                                    id="tab-{{ $topic->id }}" role="tabpanel"
                                                    aria-labelledby="tab-{{ $topic->id }}">
                                                    <!-- Your table content for each tab goes here -->
                                                    <form action="{{ route('updatetopic', ['topicId' => $topic->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('patch')

                                                        <table class="table">
                                                            <tr>
                                                                <th width="250" valign="middle">Total assessments</th>
                                                                <td><input type="text" class="form-control"
                                                                        name="total_assessments"
                                                                        value="{{ $topic->total_assessments }}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th width="250" valign="middle">Today’s Date</th>
                                                                <td><input type="date" class="form-control"
                                                                        name="start_date"
                                                                        value="{{ optional($topic->start_date)->format('Y-m-d') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="250" valign="middle">Targeted date of
                                                                    completion</th>
                                                                <td><input type="date" class="form-control"
                                                                        name="end_date"
                                                                        value="{{ optional($topic->end_date)->format('Y-m-d') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="250" valign="middle">Days remaining</th>
                                                                <td><input type="text" class="form-control"
                                                                        name="days_remaining" value="6" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th width="250" valign="middle">Provided feedback</th>
                                                                <td><input type="text" class="form-control"
                                                                        name="provided_feedback"
                                                                        value="{{ count(Auth::user()->definecategories) }}" />
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- <div class="tab-content" id="customTabContent">
                                            <div class="tab-pane fade active show" id="{{$topic->id}}" role="tabpanel"
                                            aria-labelledby="tab-one">
                                            
                                            </div>
                                        </div> --}}
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
