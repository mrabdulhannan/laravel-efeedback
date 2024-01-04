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
                                                    name="topic_title" required>
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
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
    <script>
        $(document).ready(function() {

            var groupIdCounter = 0;

            $("#appendgroupBtn").click(function(e) {
                e.preventDefault();
                var newGroupId = "group" + groupIdCounter;
                
               

                var newGroupDiv = '<div class="card">';
                newGroupDiv += '<div class="card-body">';
                newGroupDiv += '<div class="appended-div">';
                newGroupDiv += '<div class="row">';
                newGroupDiv +=
                    `<div class="col-md-6 mb-3"><label for="appendedGroup" class="form-label">Group</label><div class="input-group"><input type="text" class="form-control" id="appendedGroup" name=appendedGroup[${groupIdCounter}][]" required></div></div>`;
                newGroupDiv +=
                    `<div class="col-md-6 mb-3"><label for="appendedTitle" class="form-label">Title</label><input type="text" class="form-control" id="appendedTitle" name="appendedGroup[${groupIdCounter}][title][]" required></div>`;
                newGroupDiv += '</div>';
                newGroupDiv +=
                    `<div class="mb-3"><label for="appendedDescription" class="form-label">Description</label><textarea class="form-control" id="appendedDescription" name="appendedGroup[${groupIdCounter}][description][]" rows="4" required></textarea></div>`;
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
                groupIdCounter++;
            });

            $("#appendgroupBtn").click();

            $(document).on("click", "[id^='appendDataBtn-']", function(e) {
                e.preventDefault();
                var groupCounter = $(this).attr("id").replace("appendDataBtn-group", "");
                console.log(groupCounter);
                var groupId = $(this).attr("id").replace("appendDataBtn-", "");

                // Obtain values from the new category fields within the group
                var groupTitle = $(`#${groupId}`).val();
                var newCategoryDiv = '<hr>';
                newCategoryDiv += '<div class="appended-div">';
                newCategoryDiv += '<div class="row">';
                newCategoryDiv +=
                    `<div class="mb-3"><label for="appendedTitle" class="form-label">Title</label><input type="text" class="form-control" name="appendedGroup[${groupCounter}][title][]" value="" required></div>`;
                newCategoryDiv +=
                    `<div class="mb-3"><label for="appendedDescription" class="form-label">Description</label><textarea class="form-control" name="appendedGroup[${groupCounter}][description][]" rows="4" required></textarea></div>`;
                newCategoryDiv += '</div>';
                

                // Append the new div to the container within the corresponding group
                $("#appendedCategories-" + groupId).append(newCategoryDiv);

                // Scroll to the bottom after appending
                // $("#appendedCategories-" + groupId).scrollTop($("#appendedCategories-" + groupId)[0]
                //     .scrollHeight);

                // Add the group to the appendedGroup array
                // $("input[name='appendedGroup[]']").each(function() {
                //     if ($(this).val() !== "") {
                //         $("#appendedGroup").append($(this).val());
                //     }
                // });
                // }
            });




            // Handle the click event of the "Save Category" button
            $("#saveCategoryBtn").click(function(e) {

                // Submit the form
                $("#categoryForm").submit();
            });


        });
    </script>
@endpush
