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
                    <button class="btn btn-success" id="copyContentBtn">Copy Content</button>
                </div>
            </div>
        </div>
    </div>

    @push('script-page-level')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get the button element
                var copyContentBtn = document.getElementById('copyContentBtn');

                // Add click event listener to the button
                copyContentBtn.addEventListener('click', function() {
                    // Get the container element that holds the received data
                    var receivedDataContainer = document.getElementById('receivedDataContainer');

                    // Create a range object to select the content
                    var range = document.createRange();
                    range.selectNode(receivedDataContainer);

                    // Select the content
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);

                    // Copy the selected content to the clipboard
                    document.execCommand('copy');

                    // Clear the selection
                    window.getSelection().removeAllRanges();

                    // Alert the user
                    alert('Content has been copied successfully.');
                });
            });
        </script>
    @endpush
@endsection
