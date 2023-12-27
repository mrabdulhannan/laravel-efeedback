@extends('layouts.app')

@push('stylesheet-page-level')
@endpush
@section('content')
    <!-- Row start -->
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">My Categories</h2>
                </div>


                <div class="card-body">
                    <div class="">
                        <div class="custom-tabs-container">
                            @if (Auth::user()->definetopic !== null && count(Auth::user()->definetopic) > 0)
                                <ul class="nav nav-tabs" id="customTabs" role="tablist">
                                    @foreach (Auth::user()->definetopic as $key => $topic)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{ $key === 0 ? 'active' : '' }}"
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
                                        <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                            id="tab-{{ $topic->id }}" role="tabpanel"
                                            aria-labelledby="tab-{{ $topic->id }}">
                                            @php
                                                // Group categories by their 'group' attribute
                                                $groupedCategories = Auth::user()->definecategories
                                                    ->where('topic_id', $topic->id)
                                                    ->groupBy('group');
                                            @endphp
                                            @forelse ($groupedCategories as $group => $categories)
                                                <h5>{{ $group }}</h5>
                                                <ul class="list-group" id="itemsList">
                                                    @foreach ($categories as $category)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h5 class="mb-1">{{ $category->title }}</h5>
                                                                {{-- <p class="mb-1">{{ $category->description }}</p> --}}
                                                                {{-- <span class="badge bg-info">{{ $category->group }}</span> --}}
                                                            </div>
                                                            <div class="d-flex">
                                                                <div>
                                                                    <form action="{{ route('editCategory', ['id' => $category->id]) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-warning  btn-sm me-1">Edit</button>
                                                                    </form>
                                                                </div>
                                                                <div>
                                                                    <form action="{{ route('deleteCategory', ['id' => $category->id]) }}"
                                                                        method="post"
                                                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
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
    document.addEventListener('DOMContentLoaded', function () {
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
@endpush
