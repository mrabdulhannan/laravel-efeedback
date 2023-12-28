@extends('layouts.app')

@push('stylesheet-page-level')
    <style>
        .list-group-item.selected2 {
            background-color: #007bff;
            color: white;
        }
    </style>
@endpush

@section('content')
    <!-- Row start -->
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New Assessment</h3>
                </div>
                <div class="card-body">
                    <div class="row">
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
                            <div class="col-3">
                                <div class="tab-content" id="customTabContent">
                                    @foreach (Auth::user()->definetopic as $key => $topic)
                                        <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                            id="tab-{{ $topic->id }}" role="tabpanel"
                                            aria-labelledby="tab-{{ $topic->id }}">

                                            <ul id="itemList" class="list-group">
                                                <!-- Item IDs will be dynamically added here -->
                                                @php
                                                    // Group categories by their 'group' attribute
                                                    $groupedCategories = Auth::user()
                                                        ->definecategories->where('topic_id', $topic->id)
                                                        ->groupBy('group');
                                                @endphp
                                                @forelse ($groupedCategories as $group => $categories)
                                                    <h5>{{ $group }}</h5>
                                                    @foreach ($categories as $category)
                                                        <li class="list-group-item">
                                                            <span class="category-title"
                                                                data-category-id="{{ $category->id }}">{{ $category->title }}</span>
                                                        </li>
                                                    @endforeach
                                                @empty
                                                    <p>No categories available for this topic.</p>
                                                @endforelse
                                            </ul>


                                            <p>
                                                @if ($categoryCount > 0)
                                                    Number of categories for this topic: {{ $categoryCount }}
                                                @else
                                                    No categories available for this topic.
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
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
                </div>
                <div class="card-footer">
                    <button id="sendDataButton" class="btn btn-success">Preview</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->
@endsection

@push('script-page-level')
    <script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const itemList = $('#itemList');
            const categoryTitles = $('.category-title');
            const selectedItemData = $('#selectedItemData');
            const selectedItems = new Set();
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

                // Concatenate HTML content for all selected items
                selectedItems.forEach(itemId => {
                    const selectedItem = items.find(item => item.id === itemId);
                    if (selectedItem) {
                        const elementId = `description_${selectedItem.id}`;
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
                    </div>
                `);

                        // Initialize TinyMCE for the current element
                        initializeTinyMCE(elementId);
                    }
                });

                // Highlight the selected items in the sidebar
                highlightSelectedItems();
            }

            function highlightSelectedItems() {
                // Remove 'selected' class from all items
                itemList.find('li').removeClass('selected');

                // Add 'selected' class to the selected items
                selectedItems.forEach(itemId => {
                    const listItem = itemElements[itemId];
                    if (listItem) {
                        $(listItem).addClass('selected');
                    }
                });
            }

            // Attach click event to category titles
            categoryTitles.click(function() {
                const categoryId = $(this).data('category-id');

                // Toggle the 'selected' class for the clicked category
                $(this).parent('li').toggleClass('selected2');
                $(this).toggleClass('selected');

                // Update the selected items list based on the 'selected' class
                if ($(this).hasClass('selected')) {
                    selectedItems.add(categoryId);
                } else {
                    selectedItems.delete(categoryId);
                }

                // Render selected items' data in the main content area
                renderSelectedItemsData();
            });






            categoryTitles.css('cursor', 'pointer');
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

                // Collect data for selected items
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

                return selectedData;
            }

        });
    </script>
@endpush
