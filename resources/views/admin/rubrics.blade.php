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
                                                    <form action="{{ route('updaterubrics', ['id' => $rubric->id]) }}"
                                                        method="post">
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
                                                                <button type="submit" class="btn btn-primary">Update
                                                                </button>
                                                                <a href="#" class="btn btn-danger delete-rubric" data-rubric-id="{{ $rubric->id }}">X</a>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                @endforeach
                                            </table>
                                            <div class="card-header new-rubic mb-3">
                                                <button id="showFormBtn" class="btn btn-secondary" onclick="showForm('{{ $topic->id }}')">Add New</button>
                                            </div>
                                            <form id="rubricForm_{{ $topic->id }}" action="{{ route('storerubrics') }}" method="post"
                                                style="display: none;">
                                                @csrf
                                                <input type="text" name="topic_id" hidden value="{{ $topic->id }}">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <textarea name="title" placeholder="Title"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="first" placeholder="1st:"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="second" placeholder="2.1:"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="secondtwo" placeholder="2.2:"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="third" placeholder="3rd:"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="pass" placeholder="Pass:"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="fail" placeholder="Fail:"></textarea>
                                                        </td>

                                                        <td>
                                                            <button type="submit">Save Rubrics</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
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
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-rubric').forEach(function (deleteLink) {
            deleteLink.addEventListener('click', function (event) {
                event.preventDefault();
                
                // You can show a confirmation dialog here if needed
                var confirmDelete = confirm('Are you sure you want to delete this rubric?');

                if (confirmDelete) {
                    var rubricId = this.getAttribute('data-rubric-id');
                    var deleteForm = document.createElement('form');
                    deleteForm.method = 'POST';
                    deleteForm.action = '{{ url('deleteRubric') }}/' + rubricId;
                    deleteForm.innerHTML = '<input type="hidden" name="_method" value="DELETE">' +
                        '{{ csrf_field() }}';
                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
                }
            });
        });
    });
</script>
    <script>
        function showForm(topicId) {
            console.log('Button clicked');
            var form = document.getElementById('rubricForm_' + topicId);
            form.style.display = 'block';
            console.log('Form displayed');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Get the active tab from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('active_tab');
            console.log(urlParams.get('active_tab'));

            // Activate the tab if the activeTab is not null
            if (activeTab) {
                const tabLink = document.querySelector(`[href="#tab-${activeTab}"]`);
                if (tabLink) {
                    tabLink.click();
                }
            }
        });
    </script>
@endpush