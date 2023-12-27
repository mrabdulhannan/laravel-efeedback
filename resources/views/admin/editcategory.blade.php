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
                            <h2 class="card-title">Update Category</h2>
                            <form action="{{ route('updateCategory', ['id' => $category->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <!-- Add a data- attribute to store the groups for each topic -->
                                <select class="form-select" id="topic" name="topic" required>
                                    @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}"
                                            data-groups="{{ implode(',', explode(',', $topicGroups[$topic->id] ?? '')) }}"
                                            {{ $selectedTopic && $topic->id == $selectedTopic->id ? 'selected' : '' }}>
                                            {{ $topic->title }}
                                        </option>
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
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ $category->title }}" required>
                                </div>

                                <!-- Description Textarea -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ $category->description }}</textarea>
                                </div>

                                <!-- Save Button -->
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content wrapper scroll end -->
@endsection

@push('script-page-level')
    <script>
        // JavaScript to handle dynamic group dropdown
        document.addEventListener('DOMContentLoaded', function() {
            var topicDropdown = document.getElementById('topic');
            var groupDropdown = document.getElementById('group');
            var selectedGroup = @json($category->group);

            function updateGroupDropdown() {
                var selectedTopic = topicDropdown.options[topicDropdown.selectedIndex];
                var groupsString = selectedTopic.getAttribute('data-groups');

                groupDropdown.innerHTML = ''; // Clear existing options

                if (groupsString) {
                    var groupsArray = groupsString.split(',').map(function(group) {
                        return group.trim();
                    });

                    groupsArray.forEach(function(group) {
                        var option = document.createElement('option');
                        option.value = group;
                        option.text = group;
                        groupDropdown.add(option);

                        if (group === selectedGroup) {
                            option.selected = true;
                        }
                    });
                }
            }

            updateGroupDropdown();

            topicDropdown.addEventListener('change', updateGroupDropdown);
        });
    </script>
@endpush
