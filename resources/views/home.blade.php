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
                                        @if (Auth::user()->definetopic !== null && count(Auth::user()->definetopic) > 0)
                                            <ul class="nav nav-tabs" id="customTabs" role="tablist">
                                                @foreach (Auth::user()->definetopic as $key => $topic)
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link {{ $key === 0 ? 'active tab-active' : '' }}"
                                                            data-bs-toggle="tab" href="#tab-{{ $topic->id }}"
                                                            role="tab" aria-controls="tab-{{ $topic->id }}"
                                                            aria-selected="{{ $key === 0 ? 'true' : 'false' }}">{{ $topic->title }}
                                                            @php
                                                                // Count the categories for the current topic
                                                                $categoryCount = Auth::user()
                                                                    ->definecategories->where('topic_id', $topic->id)
                                                                    ->count();
                                                            @endphp
                                                            @if ($categoryCount > 0)
                                                                <span class="badge bg-info">{{ $categoryCount }}</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <div class="tab-content" id="customTabContent">
                                                @foreach (Auth::user()->definetopic as $key => $topic)
                                                    @php
                                                        // Count the categories for the current topic
                                                        $categoryCount = Auth::user()
                                                            ->definecategories->where('topic_id', $topic->id)
                                                            ->count();
                                                    @endphp
                                                    <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                                        id="tab-{{ $topic->id }}" role="tabpanel"
                                                        aria-labelledby="tab-{{ $topic->id }}">
                                                        <!-- Your existing tab content... -->
                                                        <form
                                                            action="{{ route('updatetopicpost', ['topicId' => $topic->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('patch')

                                                            <table class="table">
                                                                <tr>
                                                                    <th width="250" valign="middle">Total assessments
                                                                    </th>
                                                                    <td><input type="text" class="form-control"
                                                                            name="total_assessments"
                                                                            value="{{ $topic->total_assessments }}" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <th width="250" valign="middle">Today’s Date</th>
                                                                    <td><input type="date" class="form-control"
                                                                            name="start_date"
                                                                            value="{{ now()->format('Y-m-d') }}">
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
                                                                            name="days_remaining" id="days_remaining"
                                                                            value="6"  readonly/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th width="250" valign="middle">Provided feedback
                                                                    </th>
                                                                    <td><input type="text" class="form-control"
                                                                            name="provided_feedback"
                                                                            value="{{$topic->provided_feedback}}" />
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th width="250" valign="middle">Remaining feedback
                                                                    </th>
                                                                    <td><input type="text" class="form-control"
                                                                            name="remaining_feedback"
                                                                            value="{{  $topic->total_assessments - $topic->provided_feedback  }}" readonly />
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </form>
                                                        <!-- Your existing form code... -->

                                                        <p>
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>No topics available.</p>
                                        @endif
                                    </div>

                                    <!-- Your existing code... -->
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
<!-- Your existing script tag... -->
@push('script-page-level')
    <script>
        $
        document.addEventListener('DOMContentLoaded', function() {
            var startDateInput = document.getElementsByName('start_date')[0];
            var endDateInput = document.getElementsByName('end_date')[0];
            var daysRemainingInput = document.getElementById('days_remaining');

            // Add event listeners to recalculate the days remaining when the dates change
            startDateInput.addEventListener('input', updateDaysRemaining);
            endDateInput.addEventListener('input', updateDaysRemaining);

            // Initial calculation on page load
            updateDaysRemaining();

            function updateDaysRemaining() {
                var startDateValue = startDateInput.value;
                var endDateValue = endDateInput.value;

                if (startDateValue && endDateValue) {
                    var startDate = new Date(startDateValue);
                    var endDate = new Date(endDateValue);

                    // Calculate the difference in days between the two dates
                    var timeDifference = endDate.getTime() - startDate.getTime();
                    var daysRemaining = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

                    // Display the calculated days remaining
                    daysRemainingInput.value = daysRemaining;
                } else {
                    daysRemainingInput.value = ''; // Reset to empty if either date is not provided
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add 'active' class to the first tab on page load
            $('#customTabs li:first-child a').addClass('active tab-active');

            // ... Your existing JavaScript code ...
        });
    </script>
@endpush
