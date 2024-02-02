@extends('layouts.app')



@push('stylesheet-page-level')
<style>
    .custom-tabs-container .nav-tabs li:nth-child(1) .nav-link.active {
        border-color: transparent #dc3545;
        box-shadow: 0 -6px 0 0 #dc3545;
        color: #dc3545;
    }

    .custom-tabs-container .nav-tabs li:nth-child(2) .nav-link.active {
        border-color: transparent #28a745;
        box-shadow: 0 -6px 0 0 #28a745;
        color: #28a745;
    }

    .custom-tabs-container .nav-tabs li:nth-child(3) .nav-link.active {
        border-color: transparent #ff851b;
        box-shadow: 0 -6px 0 0 #ff851b;
        color: #ff851b;
    }

    .custom-tabs-container .nav-tabs li:nth-child(4) .nav-link.active {
        border-color: transparent #007bff;
        box-shadow: 0 -6px 0 0 #007bff;
        color: #007bff;
    }

    .custom-tabs-container .nav-tabs li:nth-child(5) .nav-link.active {
        border-color: transparent #6610f2;
        box-shadow: 0 -6px 0 0 #6610f2;
        color: #6610f2;
    }

    .custom-tabs-container .nav-tabs li:nth-child(6) .nav-link.active {
        border-color: transparent #3d9970;
        box-shadow: 0 -6px 0 0 #3d9970;
        color: #3d9970;
    }

    .custom-tabs-container .nav-tabs li:nth-child(7) .nav-link.active {
        border-color: transparent #3c8dbc;
        box-shadow: 0 -6px 0 0 #3c8dbc;
        color: #3c8dbc;
    }

    .custom-tabs-container .nav-tabs li:nth-child(8) .nav-link.active {
        border-color: transparent #001f3f;
        box-shadow: 0 -6px 0 0 #001f3f;
        color: #001f3f;
    }

    .custom-tabs-container .nav-tabs li:nth-child(9) .nav-link.active {
        border-color: transparent #17a2b8;
        box-shadow: 0 -6px 0 0 #17a2b8;
        color: #17a2b8;
    }

    .custom-tabs-container .nav-tabs li:nth-child(10) .nav-link.active {
        border-color: transparent #f012be;
        box-shadow: 0 -6px 0 0 #f012be;
        color: #f012be;
    }

    .navbar-nav {
        gap: 5px;
    }
</style>
    <style>

        .list-group-item.selected2 {

            background-color: #007bff;

            color: white;

        }



        .accordion-button {

            padding-left: 50px !important;

        }



        .accordion-button:after {

            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus' viewBox='0 0 16 16'%3E%3Cpath d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/%3E%3C/svg%3E") !important;

            transition: all 0.5s !important;

            position: absolute !important;

            background-size: 2.00rem !important;

            background-position: -9px -7px !important;

            left: 18px !important;

            top: 50% !important;

            transform: translateY(-50%) !important;

            content: '' !important;

        }



        .accordion-button:not(.collapsed):after {

            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='rgba(255,255,255)' class='bi bi-dash' viewBox='0 0 16 16'%3E%3Cpath d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/%3E%3C/svg%3E") !important;

            position: absolute !important;

            left: 18px !important;

            top: 50% !important;

            transform: translateY(-50%) !important;

            content: '' !important;

        }

    </style>

@endpush

@section('content')

    <!-- Row start -->

    <div class="row">

        <div class="col-xxl-12">

            <div class="card">

                <div class="card-header">

                    <h2 class="card-title">Edit Comments</h2>

                </div>





                <div class="card-body">

                    <div class="">

                        <div class="custom-tabs-container">

                            @if (Auth::user()->definetopic !== null && count(Auth::user()->definetopic) > 0)

                                <ul class="nav nav-tabs" id="customTabs" role="tablist">

                                    @foreach (Auth::user()->definetopic as $key => $topic)

                                        <li class="nav-item" role="presentation">

                                            <a class="nav-link {{ $key === 0 ? 'active' : '' }}" data-bs-toggle="tab"

                                                href="#tab-{{ $topic->id }}" role="tab"

                                                aria-controls="tab-{{ $topic->id }}"

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

                                        <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"

                                            id="tab-{{ $topic->id }}" role="tabpanel"

                                            aria-labelledby="tab-{{ $topic->id }}">





                                            @php

                                                // Group categories by their 'group' attribute

                                                $groupedCategories = Auth::user()

                                                    ->definecategories->where('topic_id', $topic->id)

                                                    ->groupBy('group');

                                            @endphp

                                            <div style="text-align:right">

                                                <form action="{{ route('definecategories', ['id' => $topic->id]) }}"

                                                    method="get" class="">

                                                    @csrf

                                                    <div>

                                                        <button type="submit" class="btn btn-secondary  btn-sm">Add Feedback Category</button>

                                                    </div>

                                                </form>

                                            </div>

                                            @forelse ($groupedCategories as $group => $categories)

                                                @php

                                                    $cleanGroup = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $group));

                                                @endphp

                                                <div>

                                                    <div class="accordion mt-1"

                                                        id="accordion_{{ $topic->id }}_{{ $cleanGroup }}">

                                                        <div class="accordion-item">

                                                            <h2 class="accordion-header"

                                                                id="heading_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}">

                                                                <button class="accordion-button collapsed" type="button"

                                                                    data-bs-toggle="collapse"

                                                                    data-bs-target="#collapse_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}"

                                                                    aria-expanded="true"

                                                                    aria-controls="collapse_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}">

                                                                    {{ $group }}

                                                                </button>

                                                            </h2>

                                                            <div id="collapse_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}"

                                                                class="accordion-collapse collapse"

                                                                aria-labelledby="heading_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}"

                                                                data-bs-parent="#accordion_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}">

                                                                <div class="accordion-body">

                                                                    <ul class="list-group" id="itemsList">

                                                                        @foreach ($categories as $category)

                                                                            <li

                                                                                class="list-group-item d-flex justify-content-between align-items-center">

                                                                                <div>

                                                                                    <h5 class="mb-1">

                                                                                        {{ $category->title }}

                                                                                    </h5>

                                                                                    <p class="mb-1">

                                                                                        {{ $category->description }}</p>

                                                                                    {{-- <span class="badge bg-info">{{ $category->group }}</span> --}}

                                                                                </div>

                                                                                <div class="d-flex">

                                                                                    <div>

                                                                                        <form

                                                                                            action="{{ route('editCategory', ['id' => $category->id]) }}"

                                                                                            method="post">

                                                                                            @csrf

                                                                                            <button type="submit"

                                                                                                class="btn btn-warning  btn-sm me-1">Edit</button>

                                                                                        </form>

                                                                                    </div>

                                                                                    <div>

                                                                                        <form

                                                                                            action="{{ route('deleteCategory', ['id' => $category->id]) }}"

                                                                                            method="post"

                                                                                            onsubmit="return confirm('Are you sure you want to delete this category?')">

                                                                                            @csrf

                                                                                            @method('DELETE')

                                                                                            <button type="submit"

                                                                                                class="btn btn-danger btn-sm">Delete</button>

                                                                                        </form>

                                                                                    </div>

                                                                                </div>

                                                                            </li>

                                                                        @endforeach

                                                                    </ul>

                                                                </div>

                                                            </div>

                                                        </div>



                                                    </div>

                                                </div>



                                            @empty

                                                <p>No categories available for this topic.</p>

                                            @endforelse

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <p>No topics available.</p>

                            @endif

                        </div>





                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection



@push('script-page-level')

    {{-- <script>

    function editCategory(categoryId) {

        // Assuming you have a route for editing

        window.location.href = "{{ route('editCategory') }}/" + categoryId;

    }

</script> --}}

    <script>

        $(document).ready(function() {

            $('#customTabs a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {

                // Handle tab shown event if needed

            });

        });

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

