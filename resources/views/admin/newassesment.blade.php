@extends('layouts.app')

@push('stylesheet-page-level')
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
        .subcat-items label{word-break: break-all;}
        div#selectedItemData {
            position: sticky;
            top: 5px;
        }
        .insert-button-class {
            cursor: pointer;
            padding: 5px; /* Add padding for better visibility */
        }

        .alert-class {
            background-color: red; /* Set the background color for the active state */
        }
    </style>
@endpush

@section('content')
    <!-- Row start -->
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Write New Feedback</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="custom-tabs-container">
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
                                                                                <label class="d-flex0 p-3 ">
                                                                                {{ $category->description }} <input
                                                                                    type="checkbox"
                                                                                    class="me-2 ms-3 chk sub-checkbox d-none"
                                                                                    data-category-id="{{ $category->id }}" /><span onclick="toggleTextWithIcon(this)" class="px-3 py-1 text-white bg-success insert-button-class rounded" style="cursor: pointer;">insert <i class="bi bi-arrow-right"></i></span>
                                                                                </label>    
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
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
                                    {{-- @foreach (Auth::user()->definetopic as $key => $topic)
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
                                                

                                            </ul>
                                        </div>
                                    @endforeach --}}

                                    <!--<button id="addNewContentButton" class="btn btn-primary btn-sm mt-2">+</button>-->
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
                        <a href="{{route('newassesment')}}" class="btn btn-danger">Reset</a>
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
                var spanElement = document.querySelector('.insert-button-class');
                function toggleTextWithIcon(spanElement) {
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
                const selectedItems = new Set();
                const newlyAddedItems = new Set(); // Track newly added items
                const itemElements = {}; // to keep track of list items

                const items = <?= Auth::user()->definecategories ?>;

                // Function to initialize TinyMCE for a specific element
                function initializeTinyMCE(elementId) {
                    tinymce.init({
                        selector: `#${elementId}`,
                        plugins: ['link'],
                        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | link',
                        branding: false,
                        menubar: false,
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
                            /*const elementId = `description_${selectedItem.id}`;
                                        selectedItemData.append(`
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" class="form-control mb-2" id="title_${selectedItem.id}" name="title" value="${selectedItem.title}">
                                    <textarea class="form-control tinymce" id="${elementId}" name="description" rows="6">${selectedItem.description}</textarea>
                                    <hr />
                                </div>
                            </div>
                        </div>
                    </div>`);*/

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
                    const itemList = $(`#itemList_${topicId}`);

                    itemList.on('click', 'li .sub-checkbox', function() {

                        const categoryId = $(this).data('category-id');
                        
                        

                        $(this).toggleClass('selected2');

                        if ($(this).is(':checked')) {
                            
                            selectedItems.add(categoryId);
                            newlyAddedItems.delete(categoryId); // Remove from newly added items
                        } else {
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

                // Function to reset selected items when switching tabs
                // window.resetSelectedItems = function() {
                //     selectedItems.clear();
                //     newlyAddedItems.clear();
                //     renderSelectedItemsData();
                // };
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
                        console.log('Text copied to clipboard: ' + descriptionHTML);
                    }).catch(function(err) {
                        console.error('Unable to copy text: ', err);
                    });
                });

            });
        </script>
        <script>
        $(document).ready(function() {
            // Add 'active' class to the first tab on page load
            $('#customTabs li:first-child a').addClass('active tab-active');


        });
    </script>
    @endpush
