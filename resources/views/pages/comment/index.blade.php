@extends('layouts.app')

@section('body')
    <div class="d-flex align-items-center justify-content-between">
        <h1>List Comment
            @if (isset($data['request']->comment_id))
                Level 1
            @endif
        </h1>
        @if (!isset($data['request']->comment_id))
            <a href="{{ route('comment.create', ['article_id' => $data['request']->article_id]) }}"
                class="btn btn-primary">Add
                Comment</a>
        @endif
    </div>
    <hr />
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Article Title</th>
                <th>Created By</th>
                <th>Body</th>
                <th class="text-center">Status Allow</th>
                <th>Created At</th>
                @if (count($data['comments']) > 0 && $data['comments']->first()->parent_id == '0')
                    <th class="text-center">Comments</th>
                    <th class="text-center">Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if ($data['comments']->count() > 0)
                @foreach ($data['comments'] as $comment)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $comment->article->title }}</td>
                        <td class="align-middle">{{ $comment->created_by }}</td>
                        <td class="align-middle">{{ $comment->body }}</td>
                        <td class="align-middle text-center"><a href="{{ route('update-allow', ['article_id' => $data['request']->article_id, 'comment_id' => $comment->id]) }}" class="btn btn-sm btn-info">{{ ($comment->allow == "1")?"Aktif":"Non Aktif" }}</a></td>
                        <td class="align-middle">{{ $comment->created_at }}</td>
                        @if ($comment->parent_id == '0')
                            <td class="align-middle text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('comment.index', ['article_id' => $data['request']->article_id, 'comment_id' => $comment->id]) }}"
                                        type="button"
                                        class="btn btn-sm btn-secondary">{{ $comment->getCommentsByParentId($comment->id)->count() }}
                                        Comments</a>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('comment.edit', $comment->id) }}" type="button"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form class="btn btn-sm btn-danger p-0"
                                        action="{{ route('comment.destroy', $comment->id) }}" method="POST"
                                        onsubmit="return confirm('Delete?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger m-0">Delete</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let table = new DataTable('table', {
                pageLength: 100
            });
        });
    </script>
@endsection
