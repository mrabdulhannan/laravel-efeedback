@extends('layouts.app')

@push('stylesheet-page-level')
@endpush
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Preview</div>
            </div>
            <div class="card-body">
                <div class="container mt-4">
                    <h2>Received Data</h2>

                    @if (!empty($selectedData))
                        <div class="list-group">
                            <div id="receivedDataContainer" class="list-group list-group-item">
                                @foreach ($selectedData as $item)
                                    <!-- Data will be dynamically added here -->
                                    <h5 class="mt-2">{{ $item['title'] }}</h5>
                                    <p class="mb-2">{{ $item['description'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p>No data received.</p>
                    @endif

                </div>
                <div class="card-footer">
                    <button class="btn btn-success" onclick="javascript:alert('Content has been copied successfully.')">Copy
                        Content</button>
                </div>



            </div>
        </div>
        <!-- Row end -->
    @endsection

    @push('script-page-level')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const demoData = [{
                    'id': 1,
                    'title': 'Table of Contents provided',
                    'description': 'The table of contents for this business report has been laid out clearly. It is always very helpful for any business report or essay, as it gives the reader a good overview of what to expect and how the rest of the report has been structured and presented.',
                    'type': 'Table of Contents',
                },
                {
                    'id': 2,
                    'title': 'No Table of Contents',
                    'description': 'The table of contents for the report has not been presented. It is always very helpful for any report or essay, as it gives the reader a clear overview of what to expect and how the rest of the report has been structured and presented. In order to generate this, please use Microsoft Word’s built-in wizard instead of typing it manually.It will generate the table of contents for you very conveniently and can update it as well.Here is a link on YouTube that you can watch to learn this skill: <a href="https://www.youtube.com/watch?v=UIQdHzHh5c0">https://www.youtube.com/watch?v=UIQdHzHh5c0</a>.',
                    'type': 'Table of Contents',
                },
                {
                    'id': 3,
                    'title': 'Table of Contents without use of the MS Wizard',
                    'description': 'While the table of contents for this report has been laid out, please note that for future purposes, try using Microsoft Word’s built-in wizard instead of typing it manually. It will generate the table of contents for you very conveniently and can update it as well. Here is a link on YouTube that you can watch to learn this skill: <a href="https://www.youtube.com/watch?v=UIQdHzHh5c0">https://www.youtube.com/watch?v=UIQdHzHh5c0</a>',
                    'type': 'Table of Contents',
                }
                // Add more demo data as needed
            ];

            const receivedDataContainer = document.getElementById('receivedDataContainer');

            if (demoData.length > 0) {
                demoData.forEach(item => {
                    const listItem = document.createElement('div');
                    listItem.className = '';
                    listItem.innerHTML = `
                    <h5 class="mt-2">${item.title}</h5>
                    <p class="mb-2">${item.description}</p>
                `;
                    receivedDataContainer.appendChild(listItem);
                });
            } else {
                receivedDataContainer.innerHTML = '<p>No data received.</p>';
            }
        });
    </script>
    @endpush
