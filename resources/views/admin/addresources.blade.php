@extends('layouts.app')

@push('stylesheet-page-level')
    <style>
        table {

            width: 100%;

            /* Use a percentage or a fixed value based on your design */

            table-layout: fixed;

            border-collapse: collapse;

        }



        th,

        td {

            border: 1px solid #dddddd;

            text-align: left;

            padding: 8px;

            word-wrap: break-word;

            /* Enable text wrapping */

        }
    </style>
@endpush

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Row start -->
            <div class="row">
                <div class="col-xxl-12">
                    {{-- <h4 class="card-title mb-3"></h4> --}}
                    <div class="">
                        <div class="">
                            <div class="form-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="card-title">Add Resources</h2>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('file.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label for="file">File Name</label>
                                            <input type="text" name="file_name" class="form-control" required>
                                            <label for="file">File Upload</label>
                                            <input type="file" name="file" class="form-control"
                                                accept=".pdf, .docx, .xlsx, .ppt, .jpg, .png, .gif, .jpeg" required>
                                            <button type="submit" class="btn btn-success mt-3">Upload</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
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
