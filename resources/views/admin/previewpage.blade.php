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
    @endpush
