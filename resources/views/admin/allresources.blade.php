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
                                                        <th>File Path</th>
                                                        <th>Small Preview</th>
                                                        <th>Date Created</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (Auth::user()->resources as $file)
                                                        <tr>
                                                            <td>{{ $file->file_name }}</td>
                                                            <td>
                                                                <a href="{{ asset('storage/' . $file->file_path) }}"
                                                                    target="_blank">Click Here to Open File</a>
                                                            </td>
                                                            <td>
                                                                @if (Str::contains($file->file_path, ['.png', '.jpg', '.jpeg', '.gif', '.bmp', '.svg']))
                                                                    {{-- <img src="{{ asset($file->file_path) }}" > --}}
                                                                    <img src="{{ asset('storage/' . $file->file_path) }}"
                                                                        alt="Preview" style="max-width: 50px;">
                                                                @else
                                                                    <!-- Handle non-image files (e.g., show a generic icon) -->
                                                                    <i class="fa fa-file"></i>
                                                                @endif
                                                            </td>
                                                            <td>{{ $file->created_at }}</td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('file.destroy', ['id' => $file->id, 'filename' => basename($file->file_path)]) }}"
                                                                    method="post"
                                                                    onsubmit="return confirm('Are you sure you want to delete this file?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm">Delete</button>
                                                                </form>
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
