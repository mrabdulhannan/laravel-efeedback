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
                            @foreach (Auth::user()->definecategories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $category->title }}</h5>
                                        <p class="mb-1">{{ $category->description }}</p>
                                        <span class="badge bg-info">{{ $category->group }}</span>
                                    </div>
                                    <div class="d-flex">
                                        <div>
                                            <form action="{{ route('editCategory', ['id' => $category->id]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-warning  btn-sm">Edit</button>
                                            </form>
                                            {{-- <a href="" class="btn btn-warning btn-sm me-2">Edit</a> --}}
                                            <!-- Edit Button -->
                                        </div>
                                        <div>
                                            <!-- Delete Form -->
                                            <form action="{{ route('deleteCategory', ['id' => $category->id]) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
{{-- <script>
    function editCategory(categoryId) {
        // Assuming you have a route for editing
        window.location.href = "{{ route('editCategory') }}/" + categoryId;
    }
</script> --}}
@endpush
