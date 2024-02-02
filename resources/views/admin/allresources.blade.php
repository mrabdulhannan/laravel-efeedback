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
        a:hover {
  text-decoration: underline;
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
                                    @if (Auth::user()->resources->isEmpty())
                                        <div class="alert alert-warning">
                                            No files found.
                                        </div>
                                    @else
                                        <div class="card-body">

                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>Date Uploaded</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (Auth::user()->resources as $file)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ asset('storage/' . $file->file_path) }}"
                                                                    target="_blank" class="link-primary ">{{ $file->file_name }}</a>
                                                            </td>
                                                            
                                                            <td>{{ $file->created_at }}</td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <div>
                                                                        <form
                                                                    action="{{ route('file.destroy', ['id' => $file->id, 'filename' => basename($file->file_path)]) }}"
                                                                    method="post"
                                                                    onsubmit="return confirm('Are you sure you want to delete this file?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm"><span class="bi bi-trash"></span></button>
                                                                </form>
                                                                    </div>
                                                                    <div>
                                                                        <span><a href="{{ asset('storage/' . $file->file_path) }}" class="btn btn-success"> View</a></span>
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    @endif

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
