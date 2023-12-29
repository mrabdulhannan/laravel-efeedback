@extends('layouts.app')

@push('stylesheet-page-level')
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
                    <h2 class="card-title">All Topics</h2>
                </div>

                <div class="card-body">
                    <div class="custom-tabs-container">
                        @if (Auth::user()->definetopic !== null && count(Auth::user()->definetopic) > 0)
                            <ul class="nav nav-tabs" id="customTabs" role="tablist">
                                @foreach (Auth::user()->definetopic as $key => $topic)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $key === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                                            href="#tab-{{ $topic->id }}" role="tab"
                                            aria-controls="tab-{{ $topic->id }}"
                                            aria-selected="{{ $key === 0 ? 'true' : 'false' }}">{{ $topic->title }}
                                            @php
                                                // Count the categories for the current topic
                                                $categoryCount = Auth::user()
                                                    ->definecategories->where('topic_id', $topic->id)
                                                    ->count();
                                            @endphp
                                            @if ($categoryCount > 0)
                                                <span class="badge bg-info">{{ $categoryCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content" id="customTabContent">
                                @foreach (Auth::user()->definetopic as $key => $topic)
                                    @php
                                        // Count the categories for the current topic
                                        $categoryCount = Auth::user()
                                            ->definecategories->where('topic_id', $topic->id)
                                            ->count();
                                        $rubrics = Auth::user()->definerubrics->where('topic_id', $topic->id);

                                    @endphp
                                    <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                        id="tab-{{ $topic->id }}" role="tabpanel"
                                        aria-labelledby="tab-{{ $topic->id }}">
                                        <!-- Your existing tab content... -->
                                        <h2>Rubrics Form</h2>
                                        <div class="">
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

                                                th {
                                                    background-color: #f2f2f2;
                                                }

                                                form {
                                                    margin-top: 20px;
                                                }

                                                textarea {
                                                    width: 100%;
                                                    box-sizing: border-box;
                                                    resize: none;
                                                    overflow-y: auto;
                                                    /* Set to 'scroll' if you want a scrollbar always visible */
                                                    min-height: 100px;
                                                    word-wrap: break-word;
                                                    white-space: pre-wrap;
                                                }
                                            </style>
                                            <h2>Tutorial Presentation Evaluation</h2>
                                            <table>
                                                <tr>
                                                    <th>Name :</th>
                                                    <th>Student ID:</th>
                                                    <th>Mark:</th>
                                                    <th></th>
                                                </tr>
                                            </table>
                                            <table>
                                                <tr class="main-table">
                                                    <th>Title</th>
                                                    <th>1st</th>
                                                    <th>2.1</th>
                                                    <th>2.2</th>
                                                    <th>3rd</th>
                                                    <th>Pass</th>
                                                    <th>F</th>
                                                    <th></th>
                                                </tr>
                                                @foreach ($rubrics as $key => $rubric)
                                                    <form action="{{ route('updaterubrics', ['id' => $rubric->id]) }}" method="post">
                                                        @csrf <!-- Laravel CSRF token -->
                                                        @method('PUT')
                                                        <input type="text" name="topic_id" hidden
                                                            value="{{ $topic->id }}">

                                                        <tr>
                                                            <td>
                                                                <textarea name="title" placeholder="Title">{{ $rubric->title }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="first" placeholder="1st:">{{ $rubric->first }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="second" placeholder="2.1:">{{ $rubric->second }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="secondtwo" placeholder="2.2:">{{ $rubric->secondtwo }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="third" placeholder="3rd:">{{ $rubric->third }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="pass" placeholder="Pass:">{{ $rubric->pass }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="fail" placeholder="Fail:">{{ $rubric->fail }}</textarea>
                                                            </td>

                                                            <td>
                                                                <button type="submit">Update Rubrics</button>
                                                            </td>
                                                        </tr>




                                                    </form>
                                                @endforeach
                                            </table>
                                            <form action="{{ route('storerubrics') }}" method="post">
                                                @csrf <!-- Laravel CSRF token -->
                                                <input type="text" name="topic_id" hidden value="{{ $topic->id }}">
                                                <table>

                                                    <tr>
                                                        <td>
                                                            <input type="textarea" name="title" placeholder="Title">
                                                        </td>
                                                        <td>
                                                            <input type="textarea" name="first" placeholder="1st:">
                                                        </td>
                                                        <td>
                                                            <input type="textarea" name="second" placeholder="2.1:">
                                                        </td>
                                                        <td>
                                                            <input type="textarea" name="secondtwo" placeholder="2.2:">
                                                        </td>
                                                        <td>
                                                            <input type="textarea" name="third" placeholder="3rd:">
                                                        </td>
                                                        <td>
                                                            <input type="textarea" name="pass" placeholder="Pass:">
                                                        </td>
                                                        <td>
                                                            <input type="textarea" name="fail" placeholder="Fail:">
                                                        </td>

                                                        <td>
                                                            <button type="submit">Save Rubric</button>
                                                        </td>
                                                    </tr>
                                                </table>



                                            </form>

                                            <table>
                                                <tr>
                                                    <th rowspan="6">Content Coverage</th>
                                                    <td>Excellent and thorough understanding of the reading material. All
                                                        content clearly and thoroughly explained and referenced.</td>
                                                </tr>
                                            </table>

                                            <p>Tutor Comments:</p>

                                            <p>Tutor Signature: Dr Atif Sarwar Date: </p>
                                        </div>
                                        <!-- Your existing form code... -->

                                        <p>
                                            {{-- @if ($categoryCount > 0)
                                            Number of categories for this topic: {{ $categoryCount }}
                                        @else
                                            No categories available for this topic.
                                        @endif --}}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No topics available.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page-level')
@endpush
