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

        .new-rubic {
            float: right;
        }

        .pointer-css {
            cursor: pointer;
        }

        .highlight-text {
            background-color: #ffff99;
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
                    <h2 class="card-title">Write New Feedback</h2>
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
                                        $categoryCount = Auth::user()
                                            ->definecategories->where('topic_id', $topic->id)
                                            ->count();
                                        $rubrics = Auth::user()->definerubrics->where('topic_id', $topic->id);

                                    @endphp
                                    <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                        id="tab-{{ $topic->id }}" role="tabpanel"
                                        aria-labelledby="tab-{{ $topic->id }}">
                                        <div class="">
                                            <table class="table">
                                                <tr id="studentInfo">
                                                    <th width="150" valign="middle">Name:
                                                    </th>
                                                    <td><input type="text" id="student_name" name="student_name"
                                                            class="form-control" /></td>
                                                    <th width="150" valign="middle">Student ID:
                                                    </th>
                                                    <td><input type="text" id="student_id" name="student_id"
                                                            class="form-control" /></td>
                                                    <th width="150" valign="middle">Mark
                                                    </th>
                                                    <td><input type="text" id="student_mark" name="student_mark"
                                                            class="form-control" /></td>
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
                                                </tr>
                                                <tr class="table">
                                                    <td></td>
                                                    <td>
                                                        <p class="text-center"> 90-100 | 80-89 | 70-79</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-center"> 60-69</p>
                                                    </td>

                                                    <td>
                                                        <p class="text-center"> 50-59</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-center"> 45-49</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-center"> 40-44</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-center"> 35-39 | 25-34 | 15-24</p>
                                                    </td>
                                                </tr>
                                                @foreach ($rubrics as $key => $rubric)
                                                    <form action="{{ route('updaterubrics', ['id' => $rubric->id]) }}"
                                                        method="post">
                                                        @csrf <!-- Laravel CSRF token -->
                                                        @method('PUT')
                                                        <input type="text" name="topic_id" hidden
                                                            value="{{ $topic->id }}">

                                                        <tr>
                                                            <td contenteditable="false" class="">
                                                                <div>
                                                                    {{ $rubric->title }}</div>

                                                            </td>
                                                            <td contenteditable="false" class="pointer-css">
                                                                {{-- <textarea name="first" placeholder="1st:">{{ $rubric->first }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">
                                                                    {{ $rubric->first }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css">
                                                                {{-- <textarea name="second" placeholder="2.1:">{{ $rubric->second }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">
                                                                    {{ $rubric->second }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css">
                                                                {{-- <textarea name="secondtwo" placeholder="2.2:">{{ $rubric->secondtwo }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">
                                                                    {{ $rubric->secondtwo }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css">
                                                                {{-- <textarea name="third" placeholder="3rd:">{{ $rubric->third }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">
                                                                    {{ $rubric->third }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css">
                                                                {{-- <textarea name="pass" placeholder="Pass:">{{ $rubric->pass }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">
                                                                    {{ $rubric->pass }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css">
                                                                {{-- <textarea name="fail" placeholder="Fail:">{{ $rubric->fail }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">
                                                                    {{ $rubric->fail }}</div>
                                                            </td>


                                                        </tr>
                                                    </form>
                                                @endforeach
                                            </table>

                                            <table class="table">
                                                <tr id="tutorComment">
                                                    <th width="150" valign="middle">Tutor Commment
                                                    </th>
                                                    <td>
                                                        {{-- <textarea id ="tutor_comment" name="tutor_comment" class="form-control" style="height: 150px;"></textarea> --}}
                                                        <textarea id="tutor_comment_{{ $topic->id }}" name="tutor_comment" class="form-control" style="height: 150px;" topic-id="{{ $topic->id }}"></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="table">
                                                <tr id="tutorSign">
                                                    <th width="150" valign="middle">Tutor Signature
                                                    </th>
                                                    <td><input type="text" id="tutor_sign" name="tutor_sign"
                                                            class="form-control" value="{{ Auth::user()->name }}" /></td>
                                                    <th width="150" valign="middle">Date
                                                    </th>
                                                    <td><input type="date" class="form-control" id="end_date"
                                                            name="end_date" value="{{ now()->format('Y-m-d') }}"></td>
                                                </tr>
                                            </table>
                                            <div id="alldata">

                                            </div>

                                            <div class="card-header new-rubic mb-3">
                                                <button id="copyDatabtn" class="btn btn-secondary">Download</button>
                                            </div>
                                        </div>
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

    <script>


        function highlightAndAppend(cell, textareaId) {
            // Check if the cell is already selected
            if (cell.style.backgroundColor !== '' && cell.style.backgroundColor !== 'transparent') {
                // If already selected, remove background color and return
                resetBackground(cell);
                return;
            }

            // Highlight the clicked cell
            toggleBackground(cell);

            // Get the value of the clicked cell
            var cellValue = cell.innerText;

            // Append the value to the tutor comment textarea
            var textarea = document.getElementById(textareaId);

            textarea.innerHTML += cellValue + '\n';
        }

        function toggleBackground(cell) {
            // Check the current background color
            var currentColor = cell.style.backgroundColor || window.getComputedStyle(cell).backgroundColor;

            // Define the two colors you want to toggle between
            var color1 = '#ffff99'; // Your first color
            var color2 = '#ffffff'; // Your second color

            // Toggle the background color
            cell.style.backgroundColor = currentColor === color1 ? color2 : color1;

            // Check the background color of the parent element if not set directly on the cell
            if (cell.style.backgroundColor !== currentColor) {
                cell.parentElement.style.backgroundColor = currentColor === color1 ? color2 : color1;
            }
        }

        function resetBackground(cell) {
            // Reset the background color to default (no color)
            cell.style.backgroundColor = '';
            cell.parentElement.style.backgroundColor = '';
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('#copyDatabtn').forEach(function(deleteLink) {
                deleteLink.addEventListener('click', function(event) {
                    event.preventDefault();

                    // You can show a confirmation dialog here if needed
                    var confirmDelete = confirm('Are you sure you want to download?');

                    //'student_name', 'student_id', 'student_mark', 'tutor_comment', 'alldata'
                    var nameInput = document.getElementById('student_name');
                    var studentIdInput = document.getElementById('student_id');
                    var markInput = document.getElementById('student_mark');
                    var tutorCommentTextarea = document.getElementById('tutor_comment_{{ $topic->id }}');

                    var tutor_sign = document.getElementById('tutor_sign');
                    var end_date = document.getElementById('end_date');

                    var alldata = document.getElementById('alldataId');

                    if (confirmDelete) {
                        var rubricId = 1;
                        var wordForm = document.createElement('form');
                        wordForm.method = 'POST';
                        wordForm.action = '{{ url('sendDataToController?test=1') }}';
                        wordForm.innerHTML = '<input type="hidden" name="_method" value="POST">' +
                            '{{ csrf_field() }}<input type="hidden" name="student_name" value="' +
                            nameInput.value + '"><input type="hidden" name="student_id" value="' +
                            studentIdInput.value +
                            '"><input type="hidden" name="student_mark" value="' + markInput.value +
                            '"><input type="hidden" name="tutor_comment" value="' +
                            tutorCommentTextarea.value +
                            '"><input type="hidden" name="tutor_sign" value="' + tutor_sign.value +
                            '"><input type="hidden" name="end_date" value="' + end_date.value +
                            '">';
                        document.body.appendChild(wordForm);
                        wordForm.submit();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add 'active' class to the first tab on page load
            $('#customTabs li:first-child a').addClass('active tab-active');

            // ... Your existing JavaScript code ...
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Your existing script...

            // Add event listener for changes in the active tab
            $('#customTabs a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                var activeTabId = $(e.target).attr('href');
                initializeTabFunctions(activeTabId);
            });

            // Initial setup for all tabs on page load
            initializeAllTabs();

            function initializeAllTabs() {
                $('#customTabs a[data-bs-toggle="tab"]').each(function () {
                    var tabId = $(this).attr('href');
                    initializeTabFunctions(tabId);
                });
            }

            function initializeTabFunctions(tabId) {
                // Your existing code for each tab

                // For example, if you have specific functions to call for each tab, call them here
                // For your code, you can call functions related to highlighting and appending
                // ...

                // Initialize other tab-specific functionalities here
            }

            // ... Your existing functions and code ...
        });
    </script>
@endpush
