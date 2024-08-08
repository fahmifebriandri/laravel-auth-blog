@extends('layouts.app')
@section('header')
@endsection
@section('body')
    <h1>Add Comment</h1>
    <hr />
    <form action="{{ route('comment.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Created By</label>
                <input name="created_by" class="form-control" placeholder="Created By" value="{{ Auth::user()->name }}"
                    required />
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Status</label><br />
                <input type="radio" name="allow" id="radio_allow" value="1" checked> <label
                    for="radio_allow">Allow</label>
                <input type="radio" name="allow" id="radio_not_allow" value="0" class="ms-3"> <label
                    for="radio_not_allow">Not Allow</label>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Article Title</label><br/>
                @if (isset($data['request']->article_id))
                    @php
                        $article = $data['articles']->where('id', $data['request']->article_id)->first();
                    @endphp
                    <input type="text" class="form-control" value="{{ $article->title }}" readonly disabled />
                    <input type="hidden" name="article_id" value="{{ $article->id }}" />
                @else
                    <select class="form-control" name="article_id" required>
                        <option value="" disabled selected>Choose Article</option>
                        @foreach ($data['articles'] as $article)
                            <option value="{{ $article->id }}">{{ $article->title }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Comment</label>
                <textarea type="date" name="body" class="form-control" rows="5" placeholder="Post Comment" required></textarea>
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script></script>
@endsection
