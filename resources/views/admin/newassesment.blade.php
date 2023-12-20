@extends('layouts.app')

@push('stylesheet-page-level')
    <style>
        li.list-group-item.selected {
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
                        <!-- Sidebar -->
                        <div class="col-3">
                            <ul id="itemList" class="list-group">
                                <!-- Item IDs will be dynamically added here -->
                            </ul>
                        </div>

                        <!-- Main Content -->
                        <div class="col-9">
                            <div id="selectedItemData" contenteditable="true">
                                <!-- Selected item's data will be dynamically added here -->
                            </div>
                            <!-- Button to Send Selected Data -->
                        </div>
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
            const selectedItemData = $('#selectedItemData');
            const selectedItems = new Set();
            const itemElements = {}; // to keep track of list items

            const items = <?= Auth::user()->definecategories ?>;

            function renderSidebar() {
                // Clear previous content
                itemList.empty();

                // Append data for selected items to the main content area
                items.forEach(item => {
                    const listItem = $('<li>').addClass('list-group-item').text(`${item.title}`);
                    listItem.click(() => toggleSelectedItem(item));
                    itemList.append(listItem);

                    // Keep track of list items
                    itemElements[item.id] = listItem[0];
                });
            }

            function toggleSelectedItem(item) {
                // Toggle the selected state
                if (selectedItems.has(item.id)) {
                    selectedItems.delete(item.id);
                } else {
                    selectedItems.add(item.id);
                }

                // Render selected items' data in the main content area
                renderSelectedItemsData();
            }
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
                Object.values(itemElements).forEach(item => $(item).removeClass('selected'));

                // Add 'selected' class to the selected items
                selectedItems.forEach(itemId => {
                    if (itemElements[itemId]) {
                        $(itemElements[itemId]).addClass('selected');
                    }
                });
            }


            // Initial rendering of the sidebar
            renderSidebar();

            // Button click event handler
            $('#sendDataButton').click(function() {
                // Get data of selected items
                const selectedData = getSelectedData();

                // Redirect to another page with selected data
                window.location.href = '/previewpage?selectedData=' + encodeURIComponent(JSON.stringify(
                    selectedData));
            });

            //     function getSelectedData() {
            //         const selectedData = [];

            //         // Collect data for selected items
            //         selectedItems.forEach(itemId => {
            //             const selectedItem = items.find(item => item.id === itemId);
            //             if (selectedItem) {
            //                 // Get the modified values from the input fields
            //                 const modifiedTitle = $(`#title_${selectedItem.id}`).val();
            //                 const modifiedDescription = $(`#description_${selectedItem.id}`).val();

            //                 // Add modified data to the selectedData array
            //                 selectedData.push({
            //                     id: selectedItem.id,
            //                     title: modifiedTitle,
            //                     description: modifiedDescription,
            //                     type: selectedItem.type,
            //                 });
            //             }
            //         });

            //         return selectedData;
            //     }
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
