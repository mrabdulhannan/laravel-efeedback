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
    </style>
@endpush
@section('content')
    <h1>tutorialpresentation</h1>
    <!-- Row start -->
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

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
                                                    <td><input type="text" id="student_name" name="student_name" class="form-control"/></td>
                                                    <th width="150" valign="middle">Student ID:
                                                    </th>
                                                    <td><input type="text" id="student_id" name="student_id" class="form-control"/></td>
                                                    <th width="150" valign="middle">Mark
                                                    </th>
                                                    <td><input type="text" id="student_mark" name="student_mark" class="form-control"/></td>
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
                                                @foreach ($rubrics as $key => $rubric)
                                                    <form action="{{ route('updaterubrics', ['id' => $rubric->id]) }}"
                                                        method="post">
                                                        @csrf <!-- Laravel CSRF token -->
                                                        @method('PUT')
                                                        <input type="text" name="topic_id" hidden
                                                            value="{{ $topic->id }}">

                                                        <tr>
                                                            <td contenteditable="false">
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment')">{{ $rubric->title }}</div>
    
                                                            </td>
                                                            <td contenteditable="false">
                                                                {{-- <textarea name="first" placeholder="1st:">{{ $rubric->first }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment')">{{ $rubric->first }}</div>
                                                            </td>
                                                            <td contenteditable="false">
                                                                {{-- <textarea name="second" placeholder="2.1:">{{ $rubric->second }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment')">{{ $rubric->second }}</div>
                                                            </td>
                                                            <td contenteditable="false">
                                                                {{-- <textarea name="secondtwo" placeholder="2.2:">{{ $rubric->secondtwo }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment')">{{ $rubric->secondtwo }}</div>
                                                            </td>
                                                            <td contenteditable="false">
                                                                {{-- <textarea name="third" placeholder="3rd:">{{ $rubric->third }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment')">{{ $rubric->third }}</div>
                                                            </td>
                                                            <td contenteditable="false">
                                                                {{-- <textarea name="pass" placeholder="Pass:">{{ $rubric->pass }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment')">{{ $rubric->pass }}</div>
                                                            </td>
                                                            <td contenteditable="false">
                                                                {{-- <textarea name="fail" placeholder="Fail:">{{ $rubric->fail }}</textarea> --}}
                                                                <div onclick="highlightAndAppend(this, 'tutor_comment')">{{ $rubric->fail }}</div>
                                                            </td>


                                                        </tr>
                                                    </form>
                                                @endforeach
                                            </table>
                                            
                                            <table class="table">
                                                <tr id="tutorComment">
                                                    <th width="150"  valign="middle">Tutor Commment
                                                    </th>
                                                    <td>
                                                        <textarea id ="tutor_comment" name="tutor_comment" class="form-control" style="height: 150px;"></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="table">
                                                <tr id="tutorSign">
                                                    <th width="150" valign="middle">Tutor Signature
                                                    </th>
                                                    <td><input type="text" id="tutor_sign" name="tutor_sign" class="form-control"/></td>
                                                    <th width="150" valign="middle">Date
                                                    </th>
                                                    <td><input type="date" class="form-control" name="end_date"
                                                        value=""></td>
                                                </tr>
                                            </table>
                                            <div id="alldata">
                                                
                                            </div>

                                            <div class="card-header new-rubic mb-3">
                                                <button id="copyDatabtn" class="btn btn-secondary"
                                                    >Copy Data</button>
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
            // Highlight the clicked cell
            cell.style.backgroundColor = '#ffff99';
    
            // Get the value of the clicked cell
            var cellValue = cell.innerText;
    
            // Append the value to the tutor comment textarea
            var textarea = document.getElementById(textareaId);
            
            textarea.innerHTML += cellValue + '\n';
            
        }
    </script>
    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     document.getElementById('copyDatabtn').addEventListener('click', function () {
        //         copyData('studentInfo', 'alldata');
        //     });
    
        //     function copyData(sourceId, targetId) {
        //         var sourceRow = document.getElementById(sourceId);
        //         var targetTextarea = document.getElementById(targetId);
    
        //         if (sourceRow && targetTextarea) {
        //             // Highlight the source row
        //             sourceRow.style.backgroundColor = '#ffff99';
    
        //             // Copy data to the target textarea
        //             targetTextarea.innerHTML = sourceRow.innerText;
        //             targetTextarea.innerHTML += '\n';
        //         }
        //     }
        // });
        document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('copyDatabtn').addEventListener('click', function () {
        copyData('student_name', 'student_id', 'student_mark', 'tutor_comment','alldata');
    });

    function copyData(nameId, studentId, markId, tutorCommentId, alldataId) {
        var nameInput = document.getElementById(nameId);
        var studentIdInput = document.getElementById(studentId);
        var markInput = document.getElementById(markId);
        var tutorCommentTextarea = document.getElementById(tutorCommentId);
        var alldata = document.getElementById(alldataId);

        if (nameInput && studentIdInput && markInput && tutorCommentTextarea && alldata) {
            // Copy data to the target textarea
            alldata.innerHTML = "Name: " + nameInput.value + "\n";
            alldata.innerHTML += "Student ID: " + studentIdInput.value + "\n";
            alldata.innerHTML += "Mark: " + markInput.value;
            alldata.innerHTML += "tutor Comment: " + tutorCommentTextarea.value;
        }
    }
});

    </script>
@endpush
