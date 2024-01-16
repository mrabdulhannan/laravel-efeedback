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
                                                            <input type="hidden" value="{{ $topic->id }}"
                                                                id="current_topic_id" name="current_topic_id" />
                                                            @if ($categoryCount > 0)
                                                                {{-- <span class="badge bg-info">{{ $categoryCount }}</span> --}}
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
                                                                            value="6" readonly />
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th width="250" valign="middle">Provided feedback
                                                                    </th>
                                                                    <td><input type="text" class="form-control"
                                                                            name="provided_feedback"
                                                                            value="{{ $topic->provided_feedback }}" />
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th width="250" valign="middle">Remaining feedback
                                                                    </th>
                                                                    <td><input type="text" class="form-control"
                                                                            name="remaining_feedback"
                                                                            value="{{ $topic->total_assessments - $topic->provided_feedback }}"
                                                                            readonly />
                                                                    </td>
                                                                </tr>
                                                                



                                                                <tr>
                                                                    <th width="250" valign="middle">Feedback/Day
                                                                    </th>
                                                                    <td><input type="text" class="form-control"
                                                                            name="feedback_day"
                                                                            value="{{ $topic->total_assessments - $topic->provided_feedback }}"
                                                                            readonly />
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="5">
                                                                        <div id="tab-{{ $topic->id }}-chart" class="chart-class"></div>
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


        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Your existing script...

            // Add event listener to recalculate remaining feedback when provided feedback changes
            var providedFeedbackInput = document.getElementsByName('provided_feedback')[0];
            var remainingFeedbackInput = document.getElementsByName('remaining_feedback')[0];

            providedFeedbackInput.addEventListener('input', updateRemainingFeedback);

            // Initial calculation on page load
            updateRemainingFeedback();

            function updateRemainingFeedback() {
                var totalAssessments = parseInt(document.getElementsByName('total_assessments')[0].value, 10);
                var providedFeedback = parseInt(providedFeedbackInput.value, 10);

                if (!isNaN(totalAssessments) && !isNaN(providedFeedback)) {
                    var remainingFeedback = totalAssessments - providedFeedback;

                    // Display the calculated remaining feedback
                    remainingFeedbackInput.value = remainingFeedback;
                } else {
                    remainingFeedbackInput.value = ''; // Reset to empty if values are not valid
                }
            }
        });
    </script> --}}
    <script>
        // alert(activeTabId);
        // $(document).ready(function() {
        //     var topicId = $('#current_topic_id').val();
        //     var totalAssessmentsInput = $(topicId).find('input[name="total_assessments"]');
        //     var providedFeedbackInput = $(topicId).find('input[name="provided_feedback"]');
        //     var totalAssessments = parseInt(totalAssessmentsInput.val(), 10);
        //     if(isNaN(totalAssessments)){
        //         totalAssessments = 0;
        //     }
        //     var providedFeedback = parseInt(providedFeedbackInput.val(), 10);
        //     if(isNaN(providedFeedback)){
        //         providedFeedback = 0;
        //     }
        //     var remaining_feedback = totalAssessments - providedFeedback;

        //     var currentTopicId = 'chart-' + $('#current_topic_id')
        //         .val(); // Assuming current_topic_id is an input field
        //     alert(JSON.stringify(currentTopicId));



        // });

        document.addEventListener('DOMContentLoaded', function() {

            // Your existing script...

            // Add event listener for changes in the active tab
            $('#customTabs a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {

                var activeTabId = $(e.target).attr('href');


                updateRemainingFeedbackForTab(activeTabId);
            });

            // Initial calculation on page load
            updateRemainingFeedbackForActiveTabs();

            function updateRemainingFeedbackForActiveTabs() {
                $('#customTabs a[data-bs-toggle="tab"]').each(function() {
                    var tabId = $(this).attr('href');
                    updateRemainingFeedbackForTab(tabId);
                    var totalAssessmentsInput = $(tabId).find('input[name="total_assessments"]');
                    var providedFeedbackInput = $(tabId).find('input[name="provided_feedback"]');
                    var totalAssessments = parseInt(totalAssessmentsInput.val(), 10);
                    var providedFeedback = parseInt(providedFeedbackInput.val(), 10);
                    

                    DrawChart(totalAssessments, providedFeedback, tabId);

                    function DrawChart(totalAssessments, providedFeedback, tabId) {
                        var currentTopicId = tabId+'-chart';
                        // alert(currentTopicId);

                        var remainingFeedback = totalAssessments - providedFeedback;
                        var options = {
                            series: [remainingFeedback, providedFeedback ],
                            labels: ['Reamining Feedback', 'Provided Feedback'],
                            chart: {
                                type: 'donut',
                            },
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        width: 200
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };

                        // Make sure the container with id `chart-${currentTopicId}` exists in your HTML
                        var chart = new ApexCharts(document.querySelector(currentTopicId), options);
                        chart.render();
                    }

                });


            }



            function updateRemainingFeedbackForTab(tabId) {

                var totalAssessmentsInput = $(tabId).find('input[name="total_assessments"]');
                var providedFeedbackInput = $(tabId).find('input[name="provided_feedback"]');
                var remainingFeedbackInput = $(tabId).find('input[name="remaining_feedback"]');
                var feedbackPerDayInput = $(tabId).find('input[name="feedback_day"]');
                var remainingDayInput = $(tabId).find('input[name="days_remaining"]');


                totalAssessmentsInput.on('input', function() {
                    updateRemainingFeedback(totalAssessmentsInput, providedFeedbackInput,
                        remainingFeedbackInput);
                    UpdateFeedbackPerDay(totalAssessmentsInput, providedFeedbackInput, feedbackPerDayInput,
                        remainingDayInput, feedbackPerDayInput);
                        DrawChart(totalAssessments, providedFeedback, tabId);
                });

                providedFeedbackInput.on('input', function() {
                    updateRemainingFeedback(totalAssessmentsInput, providedFeedbackInput,
                        remainingFeedbackInput);
                    UpdateFeedbackPerDay(totalAssessmentsInput, providedFeedbackInput, feedbackPerDayInput,
                        remainingDayInput, feedbackPerDayInput);
                        DrawChart(totalAssessments, providedFeedback, tabId);
                });

                // Initial calculation on page load
                updateRemainingFeedback(totalAssessmentsInput, providedFeedbackInput, remainingFeedbackInput);
                UpdateFeedbackPerDay(totalAssessmentsInput, providedFeedbackInput, feedbackPerDayInput,
                    remainingDayInput, feedbackPerDayInput);
                var totalAssessments = parseInt(totalAssessmentsInput.val(), 10);
                if (isNaN(totalAssessments)) {
                    totalAssessments = 100;
                }
                var providedFeedback = parseInt(providedFeedbackInput.val(), 10);
                if (isNaN(providedFeedback)) {
                    providedFeedback = 65;
                }



            }

            function updateRemainingFeedback(totalAssessmentsInput, providedFeedbackInput, remainingFeedbackInput) {
                var totalAssessments = parseInt(totalAssessmentsInput.val(), 10);
                var providedFeedback = parseInt(providedFeedbackInput.val(), 10);

                if (!isNaN(totalAssessments) && !isNaN(providedFeedback)) {
                    var remainingFeedback = totalAssessments - providedFeedback;

                    // Display the calculated remaining feedback
                    remainingFeedbackInput.val(remainingFeedback);
                } else {
                    remainingFeedbackInput.val(''); // Reset to empty if values are not valid
                }

            }

            function UpdateFeedbackPerDay(totalAssessmentsInput, providedFeedbackInput, feedbackPerDayInput,
                remainingDayInput, feedbackPerDayInput) {
                var totalAssessments = parseInt(totalAssessmentsInput.val(), 10);
                var providedFeedback = parseInt(providedFeedbackInput.val(), 10);
                var remainingDays = parseInt(remainingDayInput.val(), 10);
                feedbackPerDay = (totalAssessments - providedFeedback) / remainingDays;

                if (isNaN(feedbackPerDay)) {
                    feedbackPerDayInput.val(0);
                } else {
                    feedbackPerDayInput.val(Math.round(feedbackPerDay));
                }

            }


        });
    </script>
@endpush

<div>
    <style>
        .chart-class {
            max-width: 500px;
            margin: 35px auto;
            padding: 0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



</div>
