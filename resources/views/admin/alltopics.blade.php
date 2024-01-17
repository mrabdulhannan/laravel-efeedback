@extends('layouts.app')

@push('stylesheet-page-level')
    <style>
        .dragdrop {
            position: relative;
            padding: 0 0 0 14px;
        }

        .dragdrop::after {
            position: absolute;
            left: 4px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: gray;
            content: '';
        }

        .dragdrop::before {
            position: absolute;
            left: 0;
            top: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #000;
            content: '';
        }
    </style>
@endpush
@section('content')
    <!-- Row start -->
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-header">
                    <h2 class="card-title">All Feedbacks</h2>
                </div>
                <div class="card-body">
                    <div class="">
                        <ul class="list-group" id="itemsList">
                            @foreach (Auth::user()->definetopic as $topic)
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    data-topic-id="{{ $topic->id }}">
                                    <div class=" dragdrop">
                                        <h5 class="mb-1">{{ $topic->title }}</h5>
                                        <p class="mb-1">{{ $topic->groups }}</p>
                                    </div>
                                    <div class="d-flex">
                                        <div>
                                            <form action="{{ route('edittopic.post', ['id' => $topic->id]) }}"
                                                method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-warning  btn-sm me-1">Edit</button>
                                            </form>
                                            {{-- <a href="" class="btn btn-warning btn-sm me-2">Edit</a> --}}
                                            <!-- Edit Button -->
                                        </div>
                                        <div>
                                            <!-- Delete Form -->
                                            <form action="{{ route('deletetopic', ['id' => $topic->id]) }}" method="post"
                                                onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                            <!-- End Delete Form -->
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page-level')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            // Make the list items sortable
            $("#itemsList").sortable({
                update: function(event, ui) {
                    updateOrder();
                }
            });
        });

        // Function to update the order
        function updateOrder() {
            var order = [];
            // Get the order of list items
            $("#itemsList li").each(function() {
                order.push($(this).data("topic-id"));
            });

            // Make an AJAX request to update the order in the backend
            $.ajax({
                type: "POST",
                url: "{{ route('updateOrder') }}",
                data: {
                    order: order,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
@endpush
