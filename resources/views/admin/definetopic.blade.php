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
                            <h2 class="card-title">Define Topic</h2>

                            <form action="{{ route('storetopic') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <!-- Title Input -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>

                                <!-- Description Textarea -->
                                <div class="mb-3">
                                    <label for="groups" class="form-label">Goups (Must be "," separated)</label>
                                    <input type="text" class="form-control" id="groups" name="groups" rows="4"
                                        required />
                                </div>

                                <!-- Save Button -->
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->

        </div>
        <!-- Content wrapper end -->


    </div>
    <!-- Content wrapper scroll end -->
@endsection
@push('script-page-level')
@endpush