@extends('layouts.app')
@section('header')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
@endsection
@section('body')
    <h1>Detail Article</h1>
    <hr />
    @if ($errors->has('image_cover'))
        <div class="alert alert-danger">
            {{ $errors->first('image_cover') }}
        </div>
    @endif
    <form action="{{ route('article.update', $article->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="content" id="editor-content">
        <div class="row mb-3">
            <div class="col-12 mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $article->title }}">
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Author</label>
                <input type="text" name="author" class="form-control" value="{{ $article->author }}">
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Post Date</label>
                <input type="date" name="post_date" class="form-control" value="{{ $article->post_date }}">
            </div>

            <div class="col-12 mb-3">
                @php
                    $imagePath = 'assets/images/' . $article->image_cover;
                    $isImage = false;
                    if (file_exists(public_path($imagePath))) {
                        $mimeType = mime_content_type(public_path($imagePath));
                        $isImage = in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
                    }
                @endphp
                @if ($isImage)
                    <img src="{{ asset($imagePath) }}" class="img-thumbnail" style="max-width: 200px"><br />
                @endif
                <label class="form-label">Image Cover</label>
                <input type="file" name="image_cover" class="form-control" accept=".png, .jpg, .jpeg">
                <small>Recommended ratio 5:4 and maximum size 2MB, Upload for replace Image</small>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Content</label>
                <div id="toolbar-container">
                    <span class="ql-formats">
                        <select class="ql-font"></select>
                        <select class="ql-size"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-color"></select>
                        <select class="ql-background"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-script" value="sub"></button>
                        <button class="ql-script" value="super"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-header" value="1"></button>
                        <button class="ql-header" value="2"></button>
                        <button class="ql-blockquote"></button>
                        <button class="ql-code-block"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-indent" value="-1"></button>
                        <button class="ql-indent" value="+1"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-direction" value="rtl"></button>
                        <select class="ql-align"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-link"></button>
                        <button class="ql-image"></button>
                        <button class="ql-video"></button>
                        <button class="ql-formula"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-clean"></button>
                    </span>
                </div>
                <div id="editor" style="height:50em;overflow-y:auto;"></div>
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            modules: {
                syntax: true,
                toolbar: '#toolbar-container',
            },
            placeholder: 'Create Content here...',
            theme: 'snow',
        });
        $(document).ready(function() {
            quill.clipboard.dangerouslyPasteHTML(`{!! $article->content !!}`);
            $('form').on('submit', function() {
                var textContent = quill.root.textContent;
                var htmlContent = quill.root.innerHTML;
                $('#editor-content').val(htmlContent);
                if (textContent.trim() == "") {
                    event.preventDefault();
                    alert("content harus di isi!");
                }
            });
        });
    </script>
@endsection
