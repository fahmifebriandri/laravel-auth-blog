<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $article_id = $request->article_id;
        $comment_id = $request->comment_id;
        $query = Comment::query();
        if (isset($article_id) && $article_id != "" && $article_id != null) {
            $query->where("article_id", $article_id);
        }
        if (isset($comment_id) && $comment_id != "" && $comment_id != null) {
            $query->where("parent_id", $comment_id);
        } else {
            $query->where("parent_id", "0");
        }
        $data['comments'] = $query->orderBy('id', 'DESC')->get();
        $data['request'] = $request;
        return view('pages.comment.index', compact('data'));
    }
    public function create(Request $request)
    {
        $data['request'] = $request;
        $data['articles'] = Article::orderBy('title', 'ASC')->get();
        return view('pages.comment.create', compact('data'));
    }
    public function store(Request $request)
    {
        Comment::create($request->all());
        return redirect()->route('comment.index', ['article_id' => $request->article_id])->with('success', 'Comment added successfully!');
    }
    public function edit($id)
    {
        $data['comment'] = Comment::findOrFail($id);
        $data['articles'] = Article::orderBy('title', 'ASC')->get();
        return view('pages.comment.edit', compact('data'));
    }
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $article_id = $comment->article_id;
        $comment->update($request->all());
        return redirect()->route('comment.index', ['article_id' => $article_id])->with('success', 'Comment updated successfully!');
    }
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $article_id = $comment->article_id;
        $comment->delete();
        return redirect()->route('comment.index', ['article_id' => $article_id])->with('success', 'Comment deleted successfully!');
    }
    public function updateAllow(Request $request)
    {
        $article_id = $request->article_id;
        $comment_id = $request->comment_id;

        $comment = Comment::findOrFail($comment_id);
        $parent_id = $comment->parent_id;
        $comment->update(["allow" => $comment->allow == 0 ? "1" : "0"]);

        return redirect()->route('comment.index', ['article_id' => $article_id, 'comment_id' => $parent_id])->with('success', 'Allow updated successfully!');
    }
}
