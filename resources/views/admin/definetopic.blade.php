@extends('layouts.app')

@push('stylesheet-page-level')
@endpush

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Row start -->
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Create New Assessment</h2>

                            <form action="{{ route('storetopic') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <!-- Title Input -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Topic</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>

                                <!-- Save Button -->
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>

                            <!-- Topic Dropdown -->
                            <div class="mb-3">
                                <label for="topic" class="form-label">Topic</label>
                                <div class="input-group">
                                    <select class="form-select" id="topic" name="topic" required>
                                        @foreach (Auth::user()->definetopic as $topic)
                                            <option value="{{ $topic->id }}">{{ $topic->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- HTML for a single form -->
                            <div class="form-container">
                                <form action="{{ route('storecategories') }}" enctype="multipart/form-data" method="POST"
                                    class="category-form" id="categoryForm">
                                    @csrf

                                    <input type="hidden" name="topic" value="" id="topic_id">

                                    <div>
                                        <div class="row">
                                            <!-- Group Input -->
                                            <div class="col-md-6 mb-3">
                                                <label for="group" class="form-label">Group</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="group" required>
                                                </div>
                                            </div>

                                            <!-- Title Input -->
                                            <div class="col-md-6 mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" name="title" required>
                                            </div>
                                        </div>

                                        <!-- Description Textarea -->
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" name="description" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div id="appendedCategories"></div>

                                    <!-- Save Button -->
                                    <button type="button" class="btn btn-primary add-form-btn" id="saveCategoryBtn">Save
                                        Category</button>
                                    <button id="appendDataBtn" class="btn btn-secondary">Append Data to Form</button>

                                </form>
                            </div>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize the variable with the default selected topic ID
            var selectedTopicId = $("#topic").val();
            // console.log(selectedTopicId)

            // Handle the change event of the topic dropdown
            $("#topic").change(function() {
                // Update the variable with the newly selected topic ID
                selectedTopicId = $(this).val();
            });

            // Handle the form submission
            $("#categoryForm").submit(function(e) {
                // Assign the latest selected topic ID to a hidden input field
                console.log(selectedTopicId);
                $("<input>").attr({
                    type: "hidden",
                    name: "latestTopicId",
                    value: selectedTopicId
                }).appendTo(this);

                // Set the value of the '#topic_id' input field
                $('#topic_id').val(selectedTopicId);

                // Continue with the form submission
                return true;
            });

            // $("#appendDataBtn").click(function(e) {
            //     e.preventDefault();

            //     var groupValue = $("input[name='group']").val();
            //     var titleValue = $("input[name='title']").val();
            //     var descriptionValue = $("textarea[name='description']").val();

            //     // Create a new div with the appended structure
            //     var newDiv = '<div class="appended-div">';
            //     newDiv += '<div class="row">';
            //     newDiv +=
            //         '<div class="col-md-6 mb-3"><label for="appendedGroup" class="form-label">Group</label><div class="input-group"><input type="text" class="form-control" id="appendedGroup" name="appendedGroup" value="' +
            //         groupValue + '" required></div></div>';
            //     newDiv +=
            //         '<div class="col-md-6 mb-3"><label for="appendedTitle" class="form-label">Title</label><input type="text" class="form-control" id="appendedTitle" name="appendedTitle" value="' +
            //         titleValue + '" required></div>';
            //     newDiv += '</div>';
            //     newDiv +=
            //         '<div class="mb-3"><label for="appendedDescription" class="form-label">Description</label><textarea class="form-control" id="appendedDescription" name="appendedDescription" rows="4" required>' +
            //         descriptionValue + '</textarea></div>';
            //     newDiv += '</div>';

            //     // Append the new div to the form
            //     $("#appendedCategories").append(newDiv);

            //     // You can remove the values from the original inputs if needed
            //     $("input[name='group']").val('');
            //     $("input[name='title']").val('');
            //     $("textarea[name='description']").val('');
            // });
            $("#appendDataBtn").click(function(e) {
            e.preventDefault();

            // var groupValue = $("input[name='group']").val();
            // var titleValue = $("input[name='title']").val();
            // var descriptionValue = $("textarea[name='description']").val();

            var groupValue = "";
            var titleValue = "";
            var descriptionValue = "";

            // Create a new div with the appended structure
            var newDiv = '<div class="appended-div">';
            newDiv += '<div class="row">';
            newDiv +=
                '<div class="col-md-6 mb-3"><label for="appendedGroup" class="form-label">Group</label><div class="input-group"><input type="text" class="form-control" id="appendedGroup" name="appendedGroup" value="' +
                groupValue + '" required></div></div>';
            newDiv +=
                '<div class="col-md-6 mb-3"><label for="appendedTitle" class="form-label">Title</label><input type="text" class="form-control" id="appendedTitle" name="appendedTitle" value="' +
                titleValue + '" required></div>';
            newDiv += '</div>';
            newDiv +=
                '<div class="mb-3"><label for="appendedDescription" class="form-label">Description</label><textarea class="form-control" id="appendedDescription" name="appendedDescription" rows="4" required>' +
                descriptionValue + '</textarea></div>';
            newDiv += '</div>';

            // Append the new div to the container
            $("#appendedCategories").append(newDiv);

            // Scroll to the bottom after appending
            $("#appendedCategories").scrollTop($("#appendedCategories")[0].scrollHeight);

            // You can remove the values from the original inputs if needed
            // $("input[name='group']").val('');
            // $("input[name='title']").val(''); // Clear the title value
            // $("textarea[name='description']").val('');
        });

            // Handle the click event of the "Save Category" button
            $("#saveCategoryBtn").click(function(e) {
                e.preventDefault();

                // Create an array to store data of all appended divs
                var appendedData = [];

                // Iterate through each appended div
                $(".appended-div").each(function(index) {
                    var appendedGroup = $(this).find("input[name='appendedGroup']").val();
                    var appendedTitle = $(this).find("input[name='appendedTitle']").val();
                    var appendedDescription = $(this).find("textarea[name='appendedDescription']")
                        .val();

                    // Push the data to the array
                    appendedData.push({
                        group: appendedGroup,
                        title: appendedTitle,
                        description: appendedDescription
                    });
                });

                // Append the array as a hidden input to the form
                $("<input>").attr({
                    type: "hidden",
                    name: "appendedData",
                    value: JSON.stringify(appendedData)
                }).appendTo("#categoryForm");

                // Submit the form
                $("#categoryForm").submit();
            });
        });
    </script>
@endpush
