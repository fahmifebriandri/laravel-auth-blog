@extends('layouts.app')
@section('header')
@endsection
@section('body')
    <h1>Detail Comment</h1>
    <hr />
    <form action="{{ route('comment.update', $data['comment']->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-12 mb-3">
                <label class="form-label">Created By</label>
                <input type="text" name="created_by" class="form-control" value="{{ $data['comment']->created_by }}">
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Status</label><br />
                <input type="radio" name="allow" id="radio_allow" value="1"
                    {{ $data['comment']->allow == '1' ? 'checked' : '' }}> <label for="radio_allow">Allow</label>
                <input type="radio" name="allow" id="radio_not_allow" value="0" class="ms-3"
                    {{ $data['comment']->allow == '0' ? 'checked' : '' }}> <label for="radio_not_allow">Not Allow</label>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Article Title</label><br/>
                @php
                    $article = $data['articles']->where('id', $data['comment']->article_id)->first();
                @endphp
                <input type="text" class="form-control" value="{{ $article->title }}" readonly disabled />
                <input type="hidden" name="article_id" value="{{ $article->id }}" />
                {{-- <select class="form-control" name="article_id" required>
                    <option value="" disabled selected>Choose Article</option>
                    @foreach ($data['articles'] as $article)
                        <option value="{{ $article->id }}"
                            {{ $data['comment']->article_id == $article->id ? 'selected' : '' }}>{{ $article->title }}
                        </option>
                    @endforeach
                </select> --}}
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Comment</label>
                <textarea type="date" name="body" class="form-control" rows="5" placeholder="Post Comment" required>{{ $data['comment']->body }}</textarea>
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
    <script></script>
@endsection
