@extends('layouts.app')

@push('stylesheet-page-level')
@endpush

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Preview</div>
            </div>
            <div class="card-body">
                <div class="container mt-4">
                    <h2>Received Data</h2>

                    @if (!empty($selectedData))
                        <div class="list-group">
                            <div id="receivedDataContainer" class="list-group list-group-item">
                                <textarea class="tinymce">
                                    @foreach ($selectedData as $item)
                                    <h5>{{ $item['title'] }}</h5>
                                    <p>{{ $item['description'] }}</p>
                                    @endforeach
                                </textarea>

                            </div>
                        </div>
                    @else
                        <p>No data received.</p>
                    @endif

                </div>
                <div class="card-footer">
                    <button class="btn btn-success" id="copyContentBtn">Copy Content</button>
                </div>
            </div>
        </div>
    </div>

    @push('script-page-level')
        <script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                tinymce.init({
                    selector: 'textarea.tinymce',
                    plugins: ['link'],
                    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | link',
                    branding: false,
                    menubar: false,
                });

                var copyContentBtn = document.getElementById('copyContentBtn');

                copyContentBtn.addEventListener('click', function() {
                    var editorHtmlContent = tinymce.activeEditor.getContent({
                        format: 'html'
                    });

                    var tempTextArea = document.createElement('textarea');
                    tempTextArea.value = editorHtmlContent;

                    document.body.appendChild(tempTextArea);

                    tempTextArea.select();
                    document.execCommand('copy');

                    document.body.removeChild(tempTextArea);

                    alert('Content has been copied as HTML successfully.');
                });
            });
        </script>
    @endpush
@endsection
