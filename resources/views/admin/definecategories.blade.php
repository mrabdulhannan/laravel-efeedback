@extends('layouts.app')

@push('stylesheet-page-level')
@endpush
@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Content wrapper start -->
        <div class="content-wrapper">

            <!-- Row start -->
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Define Categories</h2>

                            <form action="{{ route('storecategories') }}" enctype="multipart/form-data" method="POST">
                                @csrf

                                {{-- <!-- Topic Dropdown -->
                                <div class="mb-3">
                                    <label for="topic" class="form-label">Topic</label>
                                    <div class="input-group">
                                        <select class="form-select" id="topic" name="topic" required>
                                            @foreach ($topics as $topic)
                                                <option value="{{ $topic->id }}">{{ $topic->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <!-- Add a data- attribute to store the groups for each topic -->
                                <select class="form-select" id="topic" name="topic" required>
                                    @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}"
                                            data-groups="{{ implode(',', explode(',', $topicGroups[$topic->id])) }}">
                                            {{ $topic->title }}</option>
                                    @endforeach
                                </select>

                                <!-- Add an empty group dropdown that will be populated dynamically -->
                                <div class="mb-3">
                                    <label for="group" class="form-label">Group</label>
                                    <div class="input-group">
                                        <select class="form-select" id="group" name="group" required>
                                            <!-- The groups for the selected topic will be dynamically populated here -->
                                        </select>
                                    </div>
                                </div>

                                <!-- Title Input -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>

                                <!-- Description Textarea -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                </div>

                                {{-- <!-- Group Dropdown -->
                                <div class="mb-3">
                                    <label for="group" class="form-label">Group</label>
                                    <div class="input-group">
                                        <select class="form-select" id="group" name="group" required>
                                            <option value="Table and Content">Table and Content</option>
                                            <option value="Referencing and Citation">Referencing and Citation</option>
                                            <option value="option3">Option 3</option>
                                        </select>
                                    </div>
                                </div> --}}

                                <!-- Save Button -->
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->

        </div>
        <!-- Content wrapper end -->

    </div>
    <!-- Content wrapper scroll end -->
@endsection

@push('script-page-level')
    <script>
        // JavaScript to handle dynamic group dropdown
        document.addEventListener('DOMContentLoaded', function() {
            // Get the topic and group dropdowns
            var topicDropdown = document.getElementById('topic');
            var groupDropdown = document.getElementById('group');

            // Function to update group dropdown based on the selected topic
            function updateGroupDropdown() {
                // Get the selected topic
                var selectedTopic = topicDropdown.options[topicDropdown.selectedIndex];

                // Get the groups associated with the selected topic
                var groupsString = selectedTopic.getAttribute('data-groups');

                // Check if the groupsString is not empty
                if (groupsString) {
                    // Convert the comma-separated string to an array
                    var groupsArray = groupsString.split(',');

                    // Clear existing options in the group dropdown
                    groupDropdown.innerHTML = '';

                    // Populate the group dropdown with the new options
                    groupsArray.forEach(function(group) {
                        var option = document.createElement('option');
                        option.value = group.trim(); // trim to remove any leading/trailing spaces
                        option.text = group.trim();
                        groupDropdown.add(option);
                    });
                } else {
                    // If no groups are associated, clear the group dropdown
                    groupDropdown.innerHTML = '';
                }
            }

            // Initial update of group dropdown on page load
            updateGroupDropdown();

            // Event listener for when the topic dropdown changes
            topicDropdown.addEventListener('change', function() {
                // Update the group dropdown based on the selected topic
                updateGroupDropdown();
            });
        });
    </script>
@endpush

