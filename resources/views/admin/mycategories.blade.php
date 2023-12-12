@extends('layouts.app')

@push('stylesheet-page-level')
@endpush
@section('content')
    <!-- Row start -->
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">My Categories</h2>
                </div>
                <div class="card-body">
                    <div class="">
                        <ul class="list-group" id="itemsList">
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->
@endsection

@push('script-page-level')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const items = [{
                    'title': 'Item 1',
                    'description': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'type': 'Table of Content',
                    'id': 0,
                },
                {
                    'title': 'Item 2',
                    'description': 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'type': 'Referencing',
                    'id': 1,
                },
                {
                    'title': 'Item 3',
                    'description': 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'type': 'Group 3',
                    'id': 2,
                }
                // Add more items as needed
            ];

            const itemsList = document.getElementById('itemsList');

            items.forEach(item => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';

                const contentDiv = document.createElement('div');
                contentDiv.innerHTML = `
                                                                                                                        <h5 class="mb-1">${item.title}</h5>
                                                                                                                        <p class="mb-1">${item.description}</p>
                                                                                                                        <span class="badge bg-info">${item.type}</span>
                                                                                                                    `;

                const buttonDiv = document.createElement('div');
                buttonDiv.innerHTML = `
                                                                                                                        <a href="" class="btn btn-warning btn-sm me-2">Edit</a>
                                                                                                                        <button class="btn btn-danger btn-sm" onclick="deleteItem(${item.id})">Delete</button>
                                                                                                                    `;

                listItem.appendChild(contentDiv);
                listItem.appendChild(buttonDiv);
                itemsList.appendChild(listItem);
            });

            // Add function to handle item deletion
            window.deleteItem = function(itemId) {
                const confirmDelete = confirm('Are you sure?');
                if (confirmDelete) {
                    // Implement your delete logic here
                    console.log(`Item ${itemId} deleted.`);
                }
            };
        });
    </script>
@endpush
