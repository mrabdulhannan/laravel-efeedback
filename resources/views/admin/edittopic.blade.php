@extends('layouts.app')

@push('stylesheet-page-level')
@endpush
@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Content wrapper start -->
        <div class="content-wrapper">

            <!-- Row start -->
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Update Topic</h2>
                            <form action="{{ route('updatetopicpost', ['topicId' => $topic->id]) }}" method="post">
                                @csrf
                                @php
                                    // Count the categories for the current topic
                                    $categoryCount = Auth::user()
                                        ->definecategories->where('topic_id', $topic->id)
                                        ->count();
                                @endphp
                                @method('patch')
                                <!-- Title Input -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ $topic->title }}" required>
                                </div>

                                <!-- Description Textarea -->
                                {{-- <div class="mb-3">
                                    <label for="groups" class="form-label">Goups (Must be "," separated)</label>
                                    <input type="text" class="form-control" id="groups" name="groups" rows="4"
                                        value="{{ $topic->groups }}" />
                                </div> --}}

                                <table class="table">
                                    <tr>
                                        <th width="250" valign="middle">Total assessments</th>
                                        <td><input type="text" class="form-control" name="total_assessments"
                                                value="{{ $topic->total_assessments }}" /></td>
                                    </tr>
                                    <tr>
                                        <th width="250" valign="middle">Today’s Date</th>
                                        <td><input type="date" class="form-control" name="start_date"
                                                value="{{ optional($topic->start_date)->format('Y-m-d') }}"></td>
                                    </tr>
                                    <tr>
                                        <th width="250" valign="middle">Targeted date of completion</th>
                                        <td><input type="date" class="form-control" name="end_date"
                                                value="{{ optional($topic->end_date)->format('Y-m-d') }}"></td>
                                    </tr>
                                    <tr>
                                        <th width="250" valign="middle">Days remaining</th>
                                        <td><input type="text" class="form-control" name="days_remaining"
                                                value="6" /></td>
                                    </tr>
                                    <tr>
                                        <th width="250" valign="middle">Provided feedback</th>
                                        <td><input type="text" class="form-control" name="provided_feedback"
                                                value="{{ $categoryCount }}" /></td>
                                    </tr>
                                </table>
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
@endpush
