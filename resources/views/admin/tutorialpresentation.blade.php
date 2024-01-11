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
                                                        {{-- <input type="text" name="topic_id" id ="topic_id" hidden
                                                            value="{{ $topic->id }}">  --}}

                                                        <tr>
                                                            <td contenteditable="false" class="">
                                                                <div>
                                                                    {{ $rubric->title }}</div>

                                                            </td>
                                                            <td contenteditable="false" class="pointer-css"
                                                                onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">

                                                                <div>
                                                                    {{ $rubric->first }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css"
                                                                onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">

                                                                <div>
                                                                    {{ $rubric->second }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css"
                                                                onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">

                                                                <div>
                                                                    {{ $rubric->secondtwo }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css"
                                                                onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">
                                                                <div>{{ $rubric->third }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css"
                                                                onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">

                                                                <div>
                                                                    {{ $rubric->pass }}</div>
                                                            </td>
                                                            <td contenteditable="false" class="pointer-css"
                                                                onclick="highlightAndAppend(this, 'tutor_comment_{{ $topic->id }}')">

                                                                <div>
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
                                                        <textarea id="tutor_comment_{{ $topic->id }}" name="tutor_comment" class="form-control" style="height: 150px;"
                                                            topic-id="{{ $topic->id }}"></textarea>                                                        
                                                        <textarea id="tutor_comment_hidden_{{ $topic->id }}" name="tutor_hidden_comment" class="form-control" style="height: 150px;"
                                                            topic-id="{{ $topic->id }}" hidden></textarea>
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
                                            <div class='d-flex justify-content-between'>

                                                <div class="card-header new-rubic mb-3">
                                                    <button id="refreshBtn" class="btn btn-secondary">Reset</button>
                                                </div>

                                                <div class="card-header new-rubic mb-3">
                                                    <button id="copyDatabtn" data-tid="{{ $topic->id }}" class="btn btn-primary">Download</button>
                                                </div>

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
            var row = cell.closest('tr');
            if ($(cell).hasClass('highlight-text')) {
                $(cell).removeClass('highlight-text');
                // Remove the 'highlight-text' class from all cells in the row

            } else {
                $(row).find('td').removeClass('highlight-text');
                $(cell).addClass('highlight-text');
                // Get the value of the clicked cell
                var cellValue = cell.innerText;
                
                // Append the value to the tutor comment textarea
                var textarea = document.getElementById(textareaId);

                if ($(textarea).val().length == 0) {
                    textarea.innerHTML = cellValue + '\n';
                } else {
                    textarea.innerHTML += cellValue + '\n';
                }
                
                //----------------------------------------------------
                
                var tutor_comment_hidden = textareaId.replace('tutor_comment_', 'tutor_comment_hidden_')
                
                var textarea_hidden = document.getElementById(tutor_comment_hidden);

                if ($(textarea_hidden).val().length == 0) {
                    textarea_hidden.innerHTML = cellValue + '\n';
                } else {
                    textarea_hidden.innerHTML += cellValue + '\n';
                }
                
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('#copyDatabtn').forEach(function(deleteLink) {
                deleteLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    // var topicId = {{ $topic->id }};
                    // You can show a confirmation dialog here if needed
                    // var confirmDelete = confirm('Are you sure you want to download?');

                    //'student_name', 'student_id', 'student_mark', 'tutor_comment', 'alldata'
                    // var topicId = document.getElementById('topic_id');
                    var topicId = $(this).data('tid');
                    // alert(topicId);
                    var comment_id = `tutor_comment_${topicId}`;
                    var comment_hidden_id = `tutor_comment_hidden_${topicId}`;
                    var nameInput = document.getElementById('student_name');
                    var studentIdInput = document.getElementById('student_id');
                    var markInput = document.getElementById('student_mark');
                    var tutorCommentTextarea = document.getElementById(comment_id);
                    var tutorCommentTextareaHidden = document.getElementById(comment_hidden_id);


                    var tutor_sign = document.getElementById('tutor_sign');
                    var end_date = document.getElementById('end_date');

                    var alldata = document.getElementById('alldataId');

                    if (0==0) {
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
                            '"><input type="hidden" name="tutor_comment_hidden" value="' +
                            tutorCommentTextareaHidden.value +
                            '"><input type="hidden" name="topic_id" value="' +
                            topicId +
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
        document.addEventListener('DOMContentLoaded', function() {


            // Add event listener for changes in the active tab
            $('#customTabs a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                var activeTabId = $(e.target).attr('href');
                initializeTabFunctions(activeTabId);
            });

            // Initial setup for all tabs on page load
            initializeAllTabs();

            function initializeAllTabs() {
                $('#customTabs a[data-bs-toggle="tab"]').each(function() {
                    var tabId = $(this).attr('href');
                    initializeTabFunctions(tabId);
                });
            }

            function initializeTabFunctions(tabId) {

            }


        });

        $(document).ready(function() {
            // Add a click event listener to the "Reset" button
            $('#refreshBtn').on('click', function() {
                // Reload the current page
                location.reload();
            });
        });
    </script>
@endpush