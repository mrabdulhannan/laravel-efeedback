@extends('layouts.app')

@push('stylesheet-page-level')
@endpush
@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Content wrapper start -->
        <div class="content-wrapper">

            <!-- Row start -->
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Update Category</h2>
                            <form action="{{ route('updateCategory', ['id' => $category->id]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Title Input -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ $category->title }}" required>
                                </div>

                                <!-- Description Textarea -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ $category->description }}</textarea>
                                </div>

                                <!-- Type Dropdown -->
                                <div class="mb-3">
                                    <label for="group" class="form-label">Group</label>
                                    <div class="input-group">
                                        <select class="form-select" id="group" name="group" required>
                                            <option value="Table and Content"
                                                {{ $category->group === 'Table and Content' ? 'selected' : '' }}>Table and
                                                Content</option>
                                            <option value="Referencing and Citation"
                                                {{ $category->group === 'Referencing and Citation' ? 'selected' : '' }}>
                                                Referencing and Citation</option>
                                            <option value="option3" {{ $category->group === 'option3' ? 'selected' : '' }}>
                                                Option 3</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
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
