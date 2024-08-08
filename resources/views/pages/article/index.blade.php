@extends('layouts.app')

@section('body')
    <div class="d-flex align-items-center justify-content-between">
        <h1>List Article</h1>
        <a href="{{ route('article.create') }}" class="btn btn-primary">Add Article</a>
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
                <th>Title</th>
                <th>Author</th>
                <th>Post date</th>
                <th class="text-center">Comments</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($articles->count() > 0)
                @foreach ($articles as $article)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $article->title }}</td>
                        <td class="align-middle">{{ $article->author }}</td>
                        <td class="align-middle">{{ $article->post_date }}</td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('comment.index', ['article_id' => $article->id]) }}" type="button"
                                    class="btn btn-sm btn-secondary">{{ $article->comments()->count(); }} Comments</a>
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('article.edit', $article->id) }}" type="button"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form class="btn btn-sm btn-danger p-0"
                                    action="{{ route('article.destroy', $article->id) }}" method="POST"
                                    onsubmit="return confirm('Delete?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let table = new DataTable('table',{
                pageLength: 100
            });
        });
    </script>
@endsection


