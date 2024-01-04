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
            
                                <div class="">
                                    <div class="">
                                        <div class="form-container">
                                            <form action="{{ route('storecategories') }}" enctype="multipart/form-data" method="POST"
                                                class="category-form" id="categoryForm">
                                                @csrf
            
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h2 class="card-title">Create New Assessment</h2>
                                                        <div class="mb-3">
                                                            <label for="topic_title" class="form-label">Assessment</label>
                                                            <input type="text" class="form-control" id="topic_title"
                                                                name="topic_title" required readonly value="{{$topic->title}}">
                                                        </div>
                                                    </div>
                                                </div>
            
                                                <div id="appendedGroups"></div>
            
                                            </form>
                                        </div>
                                    </div>
            
                                    <!-- Save Button -->
                                    <button type="button" class="btn btn-primary add-form-btn" id="saveCategoryBtn">Save
                                        Category</button>
                                    <button id="appendgroupBtn" class="btn btn-danger">Add New Group</button>
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
        <script>
            $(document).ready(function() {
                
                var groupIdCounter = 1;
    
                $("#appendgroupBtn").click(function(e) {
                    e.preventDefault();
    
                    var newGroupId = "group" + groupIdCounter;
                    groupIdCounter++;
    
                    var newGroupDiv = '<div class="card">';
                    newGroupDiv += '<div class="card-body">';
                    newGroupDiv += '<div class="appended-div">';
                    newGroupDiv += '<div class="row">';
                    newGroupDiv +=
                        '<div class="col-md-6 mb-3"><label for="' + newGroupId +
                        '" class="form-label">Group</label><div class="input-group"><input type="text" class="form-control" id="' +
                        newGroupId + '" name="' + newGroupId + '" required></div></div>';
                    newGroupDiv +=
                        '<div class="col-md-6 mb-3"><label for="appendedTitle" class="form-label">Title</label><input type="text" class="form-control" id="appendedTitle" name="appendedTitle[]" required></div>';
                    newGroupDiv += '</div>';
                    newGroupDiv +=
                        '<div class="mb-3"><label for="appendedDescription" class="form-label">Description</label><textarea class="form-control" id="appendedDescription" name="appendedDescription[]" rows="4" required></textarea></div>';
                    newGroupDiv += '<div id="appendedCategories-' + newGroupId + '"></div>';
                    newGroupDiv +=
                        '<button type="button" class="btn btn-secondary" id="appendDataBtn-' + newGroupId +
                        '">Add New Category</button>';
                    newGroupDiv += '</div>';
                    newGroupDiv += '</div>';
                    newGroupDiv += '</div>';
    
                    $("#appendedGroups").append(newGroupDiv);
    
                    // Scroll to the bottom after appending
                    $("#appendedGroups").scrollTop($("#appendedGroups")[0].scrollHeight);
                });
    
                $("#appendgroupBtn").click();
                $(document).on("click", "[id^='appendDataBtn-']", function(e) {
                    e.preventDefault();
    
                    var groupId = $(this).attr("id").replace("appendDataBtn-", "");
    
                    // Obtain values from the new category fields within the group
                    var groupTitle = $(`#${groupId}`).val();
                    if (groupTitle === "") {
                        alert("Please Enter the Group First");
                    } else {
                        // Create a new div with the appended structure
                        var newCategoryDiv = '<div class="appended-div">';
                        newCategoryDiv += '<div class="row">';
                        newCategoryDiv +=
                            '<div class="col-md-6 mb-3"><input type="text" class="form-control" id="appendedGroup" name="appendedGroup[]" value="' +
                            groupTitle + '" required hidden></div></div>';
                        newCategoryDiv +=
                            '<div class="mb-3"><label for="appendedTitle" class="form-label">Title</label><input type="text" class="form-control" name="appendedTitle[]" value="" required></div>';
                        newCategoryDiv +=
                            '<div class="mb-3"><label for="appendedDescription" class="form-label">Description</label><textarea class="form-control" name="appendedDescription[]" rows="4" required></textarea></div>';
                        newCategoryDiv += '</div>';
    
                        // Append the new div to the container within the corresponding group
                        $("#appendedCategories-" + groupId).append(newCategoryDiv);
    
                        // Scroll to the bottom after appending
                        $("#appendedCategories-" + groupId).scrollTop($("#appendedCategories-" + groupId)[0]
                            .scrollHeight);
    
                        // Add the group to the appendedGroup array
                        $("input[name='appendedGroup[]']").each(function() {
                            if ($(this).val() !== "") {
                                $("#appendedGroup").append($(this).val());
                            }
                        });
                    }
                });
    
    
    
               
                // Handle the click event of the "Save Category" button
                $("#saveCategoryBtn").click(function(e) {
                    e.preventDefault();
    
                    // Create an array to store data of all appended divs
                    var appendedData = [];
    
                    // Iterate through each appended div
                    $(".appended-div").each(function(index) {
                        var appendedGroup = $(this).find("input[name='appendedGroup[]']").val();
                        var appendedTitle = $(this).find("input[name='appendedTitle[]']").val();
                        var appendedDescriptions = $(this).find(
                            "textarea[name='appendedDescription[]']").val();
    
                        // Push the data to the array
                        appendedData.push({
                            group: appendedGroup,
                            title: appendedTitle,
                            description: appendedDescriptions
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

