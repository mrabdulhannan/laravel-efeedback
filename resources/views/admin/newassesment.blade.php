@extends('layouts.app')

@push('stylesheet-page-level')
@endpush
@section('content')
    <!-- Row start -->
    <div class="row ">
        <div class="col-xxl-12 ">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemList = document.getElementById('itemList');
            const selectedItemData = document.getElementById('selectedItemData');
            const selectedItems = new Set();

            const items = <?= Auth::user()->definecategories?>
            // Populate sidebar with item IDs
            items.forEach(item => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';
                listItem.textContent = `${item.title}`;
                listItem.addEventListener('click', () => toggleSelectedItem(item));
                itemList.appendChild(listItem);
            });

            function toggleSelectedItem(item) {
                // Toggle the selected state
                if (selectedItems.has(item.id)) {
                    selectedItems.delete(item.id);
                } else {
                    selectedItems.add(item.id);
                }

                // Render selected items' data in the main content area
                // updateSidebarStyling();
                renderSelectedItemsData();


            }

            function updateSidebarStyling() {
                // Remove the 'active' class from all list items
                const listItems = document.querySelectorAll('.list-group-item');
                listItems.forEach(listItem => {
                    listItem.classList.remove('active');
                });

                // Add the 'active' class to selected items
                selectedItems.forEach(itemId => {
                    const listItem = document.querySelector(`.list-group-item[data-item-id="${itemId}"]`);
                    if (listItem) {
                        listItem.classList.add('active');
                    }
                });
            }

            function renderSelectedItemsData() {
                // Clear previous content
                selectedItemData.innerHTML = '';

                // Append data for selected items to the main content area
                selectedItems.forEach(itemId => {
                    const selectedItem = items.find(item => item.id === itemId);
                    if (selectedItem) {
                        selectedItemData.innerHTML += `
                                                                                                    <div class="container">
                                                                                                    <div class="row ">
                                                                                                        <div class="col-md-12">
                                                                                                            <div class="mb-3">
                                                                                                                <input type="text" class="form-control mb-2" id="title" name="title" value="${selectedItem.title}">
                                                                                                                <textarea class="form-control" id="description" name="description" rows="6">${selectedItem.description}</textarea>
                        <hr />                                                                                    </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                `;
                    }
                });
            }

            // Button click event handler
            document.getElementById('sendDataButton').addEventListener('click', function() {
                // Get data of selected items
                const selectedData = getSelectedData();

                // Redirect to another page with selected data
                window.location.href = '/previewpage?selectedData=' + encodeURIComponent(JSON.stringify(selectedData));
                // window.location.href = '{{route('previewpage')}}';
            });

            function getSelectedData() {
                const selectedData = [];

                // Collect data for selected items
                selectedItems.forEach(itemId => {
                    const selectedItem = items.find(item => item.id === itemId);
                    if (selectedItem) {
                        selectedData.push({
                            id: selectedItem.id,
                            title: selectedItem.title,
                            description: selectedItem.description,
                            type: selectedItem.type,
                        });
                    }
                });

                return selectedData;
            }

            // Handle changes in the contenteditable elements
            selectedItemData.addEventListener('input', function(event) {
                const target = event.target;
                if (target.hasAttribute('data-item-id')) {
                    const itemId = parseInt(target.getAttribute('data-item-id'));
                    const selectedItem = items.find(item => item.id === itemId);

                    if (selectedItem) {
                        if (target.tagName === 'H3') {
                            selectedItem.title = target.textContent;
                        } else if (target.tagName === 'P') {
                            selectedItem.description = target.textContent;
                        }

                        // Update the sidebar if necessary
                        renderSelectedItemsData();
                    }
                }
            });
        });
    </script>
@endpush
