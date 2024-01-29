@extends('layouts.app')


@push('stylesheet-page-level')
    <style>
        .list-group-item.selected2 {
            background-color: #007bff;
            color: white;
        }

        .insert-button-class {
            float: right;
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

        .subcat-items label {
            word-break: break-all;
        }

        div#selectedItemData {
            position: sticky;
            top: 5px;
        }

        .insert-button-class {
            cursor: pointer;
            padding: 5px;
            /* Add padding for better visibility */
        }

        .alert-class {
            background-color: red;
            /* Set the background color for the active state */
        }
    </style>
@endpush


@section('content')
    <!-- Row start -->
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Insert Comments</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="custom-tabs-container">
                            @php
                                $firstTopicId = Auth::user()
                                    ->definetopic()
                                    ->orderBy('topic_order', 'ASC')
                                    ->first()->id;
                            @endphp
                            @if (Auth::user()->definetopic !== null && count(Auth::user()->definetopic) > 0)
                                <ul class="nav nav-tabs" id="customTabs" role="tablist">
                                    @foreach (Auth::user()->definetopic as $key => $topic)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{ $key === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                                                href="#tab-{{ $topic->id }}" role="tab"
                                                aria-controls="tab-{{ $topic->id }}"
                                                aria-selected="{{ $key === 0 ? 'true' : 'false' }}"
                                                onclick="resetSelectedItems()">
                                                {{ $topic->title }}
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
                        </div>
                        <div class="col-3">
                            <div class="tab-content" id="customTabContent">

                                @foreach (Auth::user()->definetopic as $key => $topic)
                                    <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                        id="tab-{{ $topic->id }}" role="tabpanel"
                                        aria-labelledby="tab-{{ $topic->id }}">
                                        <ul id="itemList_{{ $topic->id }}" class="list-group">
                                            <!-- Item IDs will be dynamically added here -->
                                            @php
                                                // Group categories by their 'group' attribute
                                                $groupedCategories = Auth::user()
                                                    ->definecategories->where('topic_id', $topic->id)
                                                    ->groupBy('group');
                                                $totalGroups = $groupedCategories->count();
                                            @endphp
                                            @forelse ($groupedCategories as $group => $categories)
                                                @php
                                                    $cleanGroup = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $group));

                                                @endphp

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
                                                                @foreach ($categories as $category)
                                                                    <li class="list-group-item subcat-items p-2"
                                                                        data-category-id="{{ $category->id }}">
                                                                        <button
                                                                            class="btn btn-primary- btn-sm mt-2 subcat-btn-plus-minus accordion-button collapsed">

                                                                            <span
                                                                                class="category-title">{{ $category->title }}</span>
                                                                        </button>

                                                                        <div class="description d-none ">
                                                                            <div class="d-flex flex-column">
                                                                                <div>{{ $category->description }}</div>
                                                                                <label class="p-3 ">
                                                                                    <input type="checkbox"
                                                                                        class="me-2 ms-3 chk sub-checkbox d-none"
                                                                                        data-category-id="{{ $category->id }}" /><a
                                                                                        onclick="toggleTextWithIcon(this)"
                                                                                        class="px-3 py-1 text-white bg-success insert-button-class rounded"
                                                                                        style="cursor: pointer;">insert <i
                                                                                            class="bi bi-arrow-right"></i></a>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                                <div id="appendedSubCat_{{ $cleanGroup }}"></div>
                                                                <a id="addSubCatBtn"
                                                                    class="addSubCatBtn btn btn-success">Add
                                                                    Sub-Category</a>
                                                                <div id="SubCatForm" class="SubCatForm"
                                                                    style="display: none;">
                                                                    <form action="{{ route('addcategory') }}"
                                                                        enctype="multipart/form-data" method="POST"
                                                                        class="sub-category-form"
                                                                        id="subCategoryForm_{{ $cleanGroup }}">
                                                                        @csrf
                                                                        <input type="text" id="current_topic_id_sub"
                                                                            class="current_topic_id_sub"
                                                                            name="current_topic_id_sub" hidden
                                                                            value="{{ $firstTopicId }}" />

                                                                        <label for="cat_title" class="form-label">Sub
                                                                            Category <i>(like No TOC Provided, TOC not as
                                                                                per standards etc...)</i></label>

                                                                        <input hidden type="text" class="form-control"
                                                                            id="cat_title" name="cat_title" required
                                                                            value="{{ $group }}">

                                                                        <input type="text" class="form-control"
                                                                            id="sub_cat_title" name="sub_cat_title" required
                                                                            value="">

                                                                        <label for="sub_cat_description"
                                                                            class="form-label">Description</label>

                                                                        <textarea class="form-control" id="sub_cat_description" name="sub_cat_description" required value=""></textarea>
                                                                        <button type="button"
                                                                            class="btn btn-primary ajax-submit-btn"
                                                                            data-form-id="{{ $cleanGroup }}">
                                                                            {{ __('Save Category') }}
                                                                        </button>

                                                                    </form>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            @empty
                                                <p>No categories available for this topic.</p>
                                            @endforelse
                                        </ul>
                                    </div>
                                @endforeach
                                <!-- Include jQuery library -->
                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                <div id="appendedCat"></div>

                                <!-- Add an ID to your button for easier selection -->
                                <a id="addFeedbackBtn" class="btn btn-success">Add Category</a>

                                <!-- Add an ID to your form container for easier selection -->
                                <div id="CatFormContainer" class="" style="display: none;">
                                    <form action="{{ route('addcategory') }}" enctype="multipart/form-data"
                                        method="POST" class="category-form" id="categoryForm">
                                        @csrf
                                        <input type="text" id="current_topic_id" value="{{ $firstTopicId }}"
                                            name="current_topic_id" hidden />
                                        <label for="cat_title" class="form-label">Feedback Category <i>(like
                                                Table of Content, Referencing & Citation etc...)</i></label>

                                        <input type="text" class="form-control" id="cat_title" name="cat_title"
                                            required value="">

                                        <label for="sub_cat_title" class="form-label">Sub-category <i>(like No
                                                TOC Provided, TOC not as per standards etc...)</i></label>

                                        <input type="text" class="form-control" id="sub_cat_title"
                                            name="sub_cat_title" required value="">

                                        <label for="sub_cat_description" class="form-label">Description</label>

                                        <textarea class="form-control" id="sub_cat_description" name="sub_cat_description" required value=""></textarea>
                                        <button type="button" class="btn btn-primary ajax-submit-btn-cat">
                                            {{ __('Save Category') }}
                                        </button>

                                    </form>

                                </div>
                                <script>
                                    const elementId = `description_112233`;
                                    const items = <?= Auth::user()->definecategories ?>;
                                    const selectedItems = new Set();

                                    function destroyTinyMCE() {
                                        tinymce.remove();
                                    }

                                    function initializeTinyMCE(elementId) {
                                        tinymce.init({
                                            selector: `#${elementId}`,
                                            plugins: ['link', 'autoresize'],
                                            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | link',
                                            branding: false,
                                            menubar: false,
                                            autoresize_bottom_margin: 16, // Optional: Specify the bottom margin
                                            autoresize_max_height: 500, // Optional: Specify the maximum height
                                            autoresize_min_height: 100,
                                        });
                                    }
                                    $(document).ready(function() {
                                        let currentTopicId;
                                        // $('#addFeedbackBtn').click(function() {
                                        $(document).on('click', '#addFeedbackBtn', function() {
                                            // alert(currentTopicId);
                                            $('#CatFormContainer').toggle();
                                        });
                                        $(document).on('click', '.addSubCatBtn', function() {
                                            $(this).next('.SubCatForm').toggle();
                                        });

                                        // $('.ajax-submit-btn').click(function() {
                                        $(document).on('click', '.ajax-submit-btn', function() {
                                            var formId = $(this).data('form-id');

                                            // Serialize the form data
                                            var formData = $('#subCategoryForm_' + formId).serialize();
                                            destroyTinyMCE();
                                            alert($('#subCategoryForm_' + formId).attr('action'));
                                            // Make an AJAX request to the form's action
                                            $.ajax({
                                                type: 'POST',
                                                url: $('#subCategoryForm_' + formId).attr('action'),
                                                data: formData,
                                                success: function(response) {
                                                    // Handle the response here
                                                    console.log(response);

                                                    var categoryId = response.category_id;
                                                    var title = response.title;
                                                    var description = response.description;
                                                    var user_id = response.user_id;
                                                    var group = response.group;

                                                    var newData = {
                                                        "id": categoryId,
                                                        "user_id": user_id,
                                                        "title": title,
                                                        "description": description,
                                                        "group": group,
                                                        "topic_id": response.topic_id,
                                                    };

                                                    items.push(newData);
                                                    selectedItems.add(categoryId);
                                                    var descriptionHTML = "";

                                                    // Concatenate HTML content for all selected items
                                                    selectedItems.forEach(itemId => {
                                                        const selectedItem = items.find(item => item.id === itemId);
                                                        if (selectedItem) {

                                                            descriptionHTML += '<p><strong>' + selectedItem.title +
                                                                '</strong></p>';
                                                            descriptionHTML += '<p>' + selectedItem.description +
                                                                '</p>';
                                                        }
                                                    });


                                                    jQuery("#description_112233").val(descriptionHTML);
                                                    console.log(descriptionHTML)

                                                    initializeTinyMCE(elementId);
                                                    var newAccordionHTML = generateInnerAccordion(response);



                                                    jQuery('#appendedSubCat_' + formId).append(newAccordionHTML);
                                                },
                                                error: function(error) {
                                                    console.error(error);
                                                }
                                            });
                                        });

                                        // $('.ajax-submit-btn-cat').click(function() {
                                        $(document).on('click', '.ajax-submit-btn-cat', function() {
                                            var formId = $(this).data('form-id');

                                            // Serialize the form data
                                            var formData = $('#categoryForm').serialize();
                                            destroyTinyMCE();
                                            // Make an AJAX request to the form's action
                                            $.ajax({
                                                type: 'POST',
                                                url: $('#categoryForm').attr('action'),
                                                data: formData,
                                                success: function(response) {
                                                    var categoryId = response.category_id;
                                                    var title = response.title;
                                                    var description = response.description;
                                                    var user_id = response.user_id;
                                                    var group = response.group;

                                                    var newData = {
                                                        "id": categoryId,
                                                        "user_id": user_id,
                                                        "title": title,
                                                        "description": description,
                                                        "group": group,
                                                        "topic_id": response.topic_id,
                                                    };

                                                    items.push(newData);
                                                    selectedItems.add(categoryId);
                                                    var descriptionHTML = "";

                                                    // Concatenate HTML content for all selected items
                                                    selectedItems.forEach(itemId => {
                                                        const selectedItem = items.find(item => item.id === itemId);
                                                        if (selectedItem) {

                                                            descriptionHTML += '<p><strong>' + selectedItem.title +
                                                                '</strong></p>';
                                                            descriptionHTML += '<p>' + selectedItem.description +
                                                                '</p>';
                                                        }
                                                    });

                                                    jQuery("#description_112233").val(descriptionHTML);
                                                    console.log(descriptionHTML)

                                                    initializeTinyMCE(elementId);

                                                    var newAccordionHTML = generateAccordion(response);
                                                    $('#appendedCat').append(newAccordionHTML);
                                                },
                                                error: function(error) {
                                                    console.error(error);
                                                }
                                            });
                                        });

                                        function generateAccordion(category) {
                                            // Escape HTML entities in the title and description to prevent XSS attacks
                                            var escapedTitle = $('<div>').text(category.title).html();
                                            var escapedDescription = $('<div>').text(category.description).html();
                                            var cleangroup = category.group; // Replace this with your actual string

                                            // Remove special characters and spaces
                                            cleangroup = cleangroup.replace(/[^a-zA-Z0-9-]/g, '');

                                            // Build the accordion HTML based on the provided data
                                            var accordionHTML = `
                                            <div class="accordion mt-1 list-group" id="accordion_${category.topic_id}_${cleangroup}">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading_${category.topic_id}_${cleangroup}">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_${category.topic_id}_${cleangroup}"
                                                            aria-expanded="true"
                                                            aria-controls="collapse_${category.topic_id}_${cleangroup}">
                                                            ${category.group}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse_${category.topic_id}_${cleangroup}" class="accordion-collapse collapse"
                                                        aria-labelledby="heading_${category.topic_id}_${cleangroup}"
                                                        data-bs-parent="#accordion_${category.topic_id}_${cleangroup}">
                                                        <div class="accordion-body">
                                                            <li class="list-group-item subcat-items p-2"
                                                                        data-category-id="${category.category_id}">
                                                                        <button
                                                                            class="btn btn-primary- btn-sm mt-2 subcat-btn-plus-minus accordion-button collapsed">

                                                                            <span
                                                                                class="category-title">${category.title }</span>
                                                                        </button>

                                                                        <div class="description d-none ">
                                                                            <div class="d-flex flex-column">
                                                                                <div>${category.description}</div>
                                                                                <label class="p-3 ">
                                                                                    <input type="checkbox"
                                                                                        class="me-2 ms-3 chk sub-checkbox d-none selected2"
                                                                                        data-category-id="${category.category_id}"checked /><a
                                                                                        onclick="toggleTextWithIcon(this)"
                                                                                        class="px-3 py-1 text-white bg-success insert-button-class rounded active bg-danger"
                                                                                        style="cursor: pointer;"><i class="bi bi-arrow-left"></i> Remove</a>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <div id="appendedSubCat_${cleangroup}"></div>
                                                                <a id="addSubCatBtn"
                                                                    class="addSubCatBtn btn btn-success">Add
                                                                    Sub-Category</a>
                                                                <div id="SubCatForm" class="SubCatForm"
                                                                    style="display: none;">
                                                                    <form action="{{ route('addcategory') }}"
                                                                        enctype="multipart/form-data" method="POST"
                                                                        class="sub-category-form"
                                                                        id="subCategoryForm_${cleangroup}">
                                                                        @csrf
                                                                        <input type="text" id="current_topic_id_sub"
                                                                            class="current_topic_id_sub"
                                                                            name="current_topic_id_sub" hidden
                                                                            value="${category.topic_id}" />

                                                                        <label for="cat_title" class="form-label">Sub
                                                                            Category <i>(like No TOC Provided, TOC not as
                                                                                per standards etc...)</i></label>

                                                                        <input hidden type="text" class="form-control"
                                                                            id="cat_title" name="cat_title" required
                                                                            value="${category.group}">

                                                                        <input type="text" class="form-control"
                                                                            id="sub_cat_title" name="sub_cat_title" required
                                                                            value="">

                                                                        <label for="sub_cat_description"
                                                                            class="form-label">Description</label>

                                                                        <textarea class="form-control" id="sub_cat_description" name="sub_cat_description" required value=""></textarea>
                                                                        <button type="button"
                                                                            class="btn btn-primary ajax-submit-btn"
                                                                            data-form-id="${cleangroup}">
                                                                            {{ __('Save Category') }}
                                                                        </button>

                                                                    </form>

                                                                </div>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            `;

                                            return accordionHTML;
                                        }

                                        function generateInnerAccordion(category) {
                                            // Escape HTML entities in the title and description to prevent XSS attacks
                                            var escapedTitle = $('<div>').text(category.title).html();
                                            var escapedDescription = $('<div>').text(category.description).html();

                                            // Build the accordion HTML based on the provided data
                                            var accordionHTML = `
                                            <li class="list-group-item subcat-items p-2"
                                                                        data-category-id="${category.category_id}">
                                                                        <button
                                                                            class="btn btn-primary- btn-sm mt-2 subcat-btn-plus-minus accordion-button collapsed">

                                                                            <span
                                                                                class="category-title">${category.title }</span>
                                                                        </button>

                                                                        <div class="description d-none ">
                                                                            <div class="d-flex flex-column">
                                                                                <div>${category.description}</div>
                                                                                <label class="p-3 ">
                                                                                    <input type="checkbox"
                                                                                        class="me-2 ms-3 chk sub-checkbox d-none selected2"
                                                                                        data-category-id="${category.category_id}"checked /><a
                                                                                        onclick="toggleTextWithIcon(this)"
                                                                                        class="px-3 py-1 text-white bg-success insert-button-class rounded active bg-danger"
                                                                                        style="cursor: pointer;"><i class="bi bi-arrow-left"></i> Remove</a>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                            `;

                                            return accordionHTML;
                                        }


                                    });
                                </script>

                            </div>
                        </div>
                        <div class="col-9 mt-2">
                            <div id="selectedItemData" contenteditable="true">
                                <!-- Selected item's data will be dynamically added here -->
                            </div>
                            <!-- Button to Send Selected Data -->
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="#" class="btn btn-danger" onclick="refreshPage()">Reset</a>
                        <button id="btnCopyText" class="btn btn-success">Copy Text</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
    @endsection

    @push('script-page-level')
        <script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>
        <script>
            $(window).on('load', function() {
                $("#customTabs .tab-active").trigger('click');
            })
            var spanElement = document.querySelector('.insert-button-class');



            function toggleTextWithIcon(spanElement) {
                console.log("Text Button Clicked");
                console.log(spanElement);
                // Check the current state
                if (spanElement.classList.contains('active')) {
                    // Toggle to the first state
                    spanElement.innerHTML = 'insert <i class="bi bi-arrow-right"></i>';
                    spanElement.classList.remove('active');
                    spanElement.classList.remove('bg-danger');


                } else {
                    // Toggle to the second state
                    spanElement.innerHTML = '<i class="bi bi-arrow-left"></i> Remove';
                    spanElement.classList.add('active');
                    spanElement.classList.add('bg-danger');

                    // spanElement.classList.remove('bg-success');

                }
            }
            $(document).ready(function() {

                const selectedItemData = $('#selectedItemData');

                const newlyAddedItems = new Set(); // Track newly added items
                const itemElements = {}; // to keep track of list items



                // Function to initialize TinyMCE for a specific element
                function initializeTinyMCE(elementId) {
                    tinymce.init({
                        selector: `#${elementId}`,
                        plugins: ['link', 'autoresize'],
                        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | link',
                        branding: false,
                        menubar: false,
                        autoresize_bottom_margin: 16, // Optional: Specify the bottom margin
                        autoresize_max_height: 500, // Optional: Specify the maximum height
                        autoresize_min_height: 100,
                    });
                }

                // Function to destroy existing TinyMCE instances
                function destroyTinyMCE() {
                    tinymce.remove();
                }

                // Function to render selected items
                function renderSelectedItemsData() {
                    // Destroy existing TinyMCE instances
                    destroyTinyMCE();

                    // Clear previous content
                    selectedItemData.empty();

                    const elementId = `description_112233`;
                    selectedItemData.append(`
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea class="form-control tinymce" id="${elementId}" name="description" rows="6"></textarea>
                                    <hr />
                                </div>
                            </div>
                        </div>
                    </div>`);

                    var descriptionHTML = "";

                    // Concatenate HTML content for all selected items
                    selectedItems.forEach(itemId => {
                        const selectedItem = items.find(item => item.id === itemId);
                        if (selectedItem) {

                            descriptionHTML += '<p><strong>' + selectedItem.title + '</strong></p>';
                            descriptionHTML += '<p>' + selectedItem.description + '</p>';
                        }
                    });




                    jQuery("#description_112233").val(descriptionHTML);

                    // Initialize TinyMCE for the current element
                    initializeTinyMCE(elementId);


                    // Concatenate HTML content for newly added items
                    newlyAddedItems.forEach(itemId => {
                        const elementId = `description_${itemId}`;
                        selectedItemData.append(`
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control mb-2" id="title_${itemId}" name="title" value="">
                                                    <textarea class="form-control tinymce" id="${elementId}" name="description" rows="6"></textarea>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);

                        // Initialize TinyMCE for the current element
                        initializeTinyMCE(elementId);
                    });

                    // Highlight the selected items in the sidebar
                    highlightSelectedItems();
                }

                function highlightSelectedItems() {
                    // Remove 'selected' class from all items
                    $('[id^=itemList_]').find('li .sub-checkbox').removeClass('selected');

                    // Add 'selected' class to the selected items
                    selectedItems.forEach(itemId => {
                        const listItem = itemElements[itemId];
                        if (listItem) {
                            $(listItem).addClass('selected');
                        }
                    });
                }

                function getSelectedItemsData() {
                    var descriptionHTML = "";
                    selectedItems.forEach(itemId => {
                        const selectedItem = items.find(item => item.id === itemId);
                        if (selectedItem) {
                            descriptionHTML += selectedItem.title + '\n';
                            descriptionHTML += selectedItem.description + '\n';
                        }
                    });

                    return descriptionHTML;
                }





                // Attach click event to entire list items
                function setupClickEvent(topicId) {
                    // const itemList = $(`#itemList_${topicId}`);

                    // itemList.on('click', 'li .sub-checkbox', function() {

                    $(document).on('click', 'li .sub-checkbox', function() {

                        const categoryId = $(this).data('category-id');
                        console.log("Li Clicked");



                        $(this).toggleClass('selected2');

                        if ($(this).is(':checked')) {
                            console.log("Within First Condition");
                            selectedItems.add(categoryId);
                            newlyAddedItems.delete(categoryId); // Remove from newly added items
                        } else {
                            console.log("Within Else Condition");
                            selectedItems.delete(categoryId);
                        }


                        // Render selected items' data in the main content area
                        renderSelectedItemsData();
                    });
                }

                // Iterate over each topic and set up click event
                @foreach (Auth::user()->definetopic as $topic)
                    setupClickEvent({{ $topic->id }});
                @endforeach

                // Button click event handler
                $('#sendDataButton').click(function() {
                    // Get data of selected items
                    const selectedData = getSelectedData();

                    // Redirect to another page with selected data
                    window.location.href = '/previewpage?selectedData=' + encodeURIComponent(JSON.stringify(
                        selectedData));
                });

                function getSelectedData() {
                    const selectedData = [];

                    // Collect data for selected items and newly created content areas
                    selectedItems.forEach(itemId => {
                        const selectedItem = items.find(item => item.id === itemId);
                        if (selectedItem) {
                            // Get the modified values from the input fields
                            const modifiedTitle = $(`#title_${selectedItem.id}`).val();

                            // Get the formatted content from the TinyMCE editor
                            const modifiedDescription = tinymce.get(`description_${selectedItem.id}`)
                                .getContent();

                            // Add modified data to the selectedData array
                            selectedData.push({
                                id: selectedItem.id,
                                title: modifiedTitle,
                                description: modifiedDescription,
                                type: selectedItem.type,
                            });
                        }
                    });

                    // Collect data for newly created content areas
                    newlyAddedItems.forEach(itemId => {
                        const newTitle = $(`#title_${itemId}`).val();
                        const newDescription = tinymce.get(`description_${itemId}`).getContent();

                        // Add data for the newly created content area to selectedData array
                        selectedData.push({
                            id: itemId,
                            title: newTitle,
                            description: newDescription,
                            type: 'new', // Add the appropriate type for the new item
                        });
                    });

                    return selectedData;
                }

                // Button click event handler to add new content area
                $('#addNewContentButton').click(function() {
                    // Create a unique ID for the new content area
                    const newItemId = 'newItem_' + Date.now();
                    const currentTab = $('#customTabs .nav-link.active');

                    // Append HTML content for the new content area
                    $(`#itemList_${currentTab.attr('data-topic-id')}`).append(`
            <li class="list-group-item" id="${newItemId}" data-category-id="${newItemId}">
                <span class="category-title">New Item</span>
            </li>
        `);

                    // Add the new item ID to the selected items set
                    newlyAddedItems.add(newItemId);

                    // Append specific HTML data for the new content area
                    selectedItemData.append(`
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <input type="text" class="form-control mb-2" id="title_${newItemId}" name="title" value="">
                            <textarea class="form-control tinymce" id="description_${newItemId}" name="description" rows="6"></textarea>
                            <hr />
                        </div>
                    </div>
                </div>
            </div>
        `);

                    // Initialize TinyMCE for the current element
                    initializeTinyMCE(`description_${newItemId}`);
                });
                window.resetSelectedItems = function() {
                    selectedItems.clear();
                    newlyAddedItems.clear();
                    renderSelectedItemsData();

                    // Remove 'selected' class from all list items
                    $('[id^=itemList_]').find('li').removeClass('selected2');
                    $('[id^=itemList_]').find('.category-title').removeClass('selected');
                };

                jQuery(document).on('click', '.subcat-btn-plus-minus', function() {
                    jQuery(this).toggleClass('collapsed');
                    jQuery(this).parent('li').find('.description').toggleClass('d-none');
                });

                jQuery(document).on('click', '#btnCopyText', function() {
                    var descriptionHTML = getSelectedItemsData();
                    navigator.clipboard.writeText(descriptionHTML).then(function() {

                    }).catch(function(err) {
                        console.error('Unable to copy text: ', err);
                    });
                });

            });
        </script>
        <script>
            function getActiveTabId(clickedTab) {
                // Remove 'active' class from all tabs
                document.querySelectorAll('#customTabs .nav-link').forEach(tabLink => {
                    tabLink.classList.remove('active');
                });

                // Add 'active' class to the clicked tab
                clickedTab.classList.add('active');

                // Extract the tab ID from the clicked tab's href attribute
                const tabId = clickedTab.getAttribute('href').split('-')[1];

                // Store the active tab ID in sessionStorage
                sessionStorage.setItem('activeTabId', tabId);

                // Set the active tab ID to the hidden input field
                document.getElementById('current_topic_id').value = tabId;
                var elements = document.getElementsByClassName('current_topic_id_sub');

                // Set the new value for each element
                for (var i = 0; i < elements.length; i++) {
                    elements[i].value = tabId;
                }
                // document.getElementById('current_topic_id_sub').value = tabId;

                return tabId;
            }

            // Example usage
            document.querySelectorAll('#customTabs .nav-link').forEach(tabLink => {
                tabLink.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default tab switching behavior

                    // Get the new active tab ID when a tab is clicked
                    const newActiveTabId = getActiveTabId(tabLink);
                    currentTopicId = newActiveTabId;



                    // Add your logic here to handle the new active tab ID
                });
            });

            // Check if there is a stored active tab ID in sessionStorage
            const storedActiveTabId = sessionStorage.getItem('activeTabId');

            // If there is a stored active tab ID, set the corresponding tab as active
            if (storedActiveTabId) {
                const activeTabLink = document.querySelector(`#customTabs .nav-link[href="#tab-${storedActiveTabId}"]`);
                if (activeTabLink) {
                    // Remove 'active' class from all tabs
                    document.querySelectorAll('#customTabs .nav-link').forEach(tabLink => {
                        tabLink.classList.remove('active');
                    });

                    // Add 'active' class to the stored active tab
                    activeTabLink.classList.add('active');

                    // Set the stored active tab ID to the hidden input field
                    document.getElementById('current_topic_id').value = storedActiveTabId;
                    var elements = document.getElementsByClassName('current_topic_id_sub');

                    // Set the new value for each element
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].value = storedActiveTabId;
                    }
                    // document.getElementById('current_topic_id_sub').value = storedActiveTabId;
                }
            }

            // Function to refresh the page and maintain the active tab
            function refreshPage() {
                // Retrieve the stored active tab ID
                const storedActiveTabId = sessionStorage.getItem('activeTabId');

                // Get the current URL
                const currentUrl = new URL(window.location.href);

                // Check if there are existing parameters
                if (currentUrl.search) {
                    // Parse existing parameters
                    const urlSearchParams = new URLSearchParams(currentUrl.search);

                    // Remove existing 'active_tab' parameter, if present
                    urlSearchParams.delete('active_tab');

                    // If there is a stored active tab ID, add it as a query parameter
                    if (storedActiveTabId) {
                        urlSearchParams.append('active_tab', storedActiveTabId);
                    }

                    // Update the URL with the modified parameters
                    currentUrl.search = urlSearchParams.toString();
                } else {
                    // If there are no existing parameters, add 'active_tab' if stored
                    if (storedActiveTabId) {
                        currentUrl.search = `?active_tab=${storedActiveTabId}`;
                    }
                }

                // Refresh the page with the updated URL
                window.location.href = currentUrl.href;
            }
            $(document).ready(function() {
                // Add 'active' class to the first tab on page load
                $('#customTabs li:first-child a').addClass('active tab-active');


                const urlParams = new URLSearchParams(window.location.search);

                const activeTab = urlParams.get('active_tab');

                // console.log(urlParams.get('active_tab'));



                // Activate the tab if the activeTab is not null

                if (activeTab) {

                    const tabLink = document.querySelector(`[href="#tab-${activeTab}"]`);

                    if (tabLink) {

                        tabLink.click();

                    }

                }


            });
        </script>
    @endpush
