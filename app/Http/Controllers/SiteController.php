<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $target_search_title = $request->target_search_title;
        $target_search_content = $request->target_search_content;
        $target_search_order_by = $request->target_search_order_by;
        
        $data['title_component'] = "All Stories";
        $data['request'] = $request;
        $data['popular_articles'] = Article::orderBy('viewer', 'DESC')->limit(5)->get();

        $order = ($target_search_order_by == 'oldest') ? 'ASC' : 'DESC';
        $query = Article::orderBy('id', $order);
        if (!empty($search)) {
            $query->where('title', 'LIKE', "%{$search}%");
        }
        if (!empty($search) && !empty($target_search_content)) {
            $query->orWhere('content', 'LIKE', "%{$search}%");
        }
        $data['articles'] = $query->limit(10)->get();
        if (!empty($search)) {
            $data['title_component'] = "Search Result : " . $data['articles']->count();
        }
        return view('template-blog.welcome', compact('data'));
    }
    public function showArticle($article_title)
    {
        $article_title = str_replace("-", " ", $article_title);
        $article = Article::where('title', $article_title)->first();
        if ($article) {
            // Menambahkan nilai +1 pada kolom viewer
            $article->viewer += 1;
            $article->save();
        }
        $data['article'] = $article;
        $data['comments'] = Comment::where('article_id', $article->id)->where('parent_id', '0')->where('allow', '1')->orderBy("id", "ASC")->get();
        $data['comment_subs'] = Comment::where('article_id', $article->id)->where('parent_id', '!=', 0)->where('allow', '1')->orderBy("id", "ASC")->get();
        return view('template-blog.article', compact('data'));
    }
    public function memberRegister(Request $request)
    {
        $user = new Models\Member();
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Register Successfully!');
    }
    public function memberLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = Models\Member::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            $request->session()->put('member', [
                'id' => $user->id,
                'email' => $user->email,
                'full_name' => $user->full_name,
            ]);
            return back()->with('success', 'Login Successfully!');
        } else {
            return back()->with('error', 'Login failed, invalid email or password');
        }
    }
    public function memberLogout(Request $request)
    {
        $request->session()->forget('member');
        return back()->with('success', 'Logout Successfully!');
    }
    public function memberCommentSend(Request $request)
    {
        $member_id = $request->session()->get('member.id');
        $member_email = $request->session()->get('member.email');
        $member_full_name = $request->session()->get('member.full_name');
        $articleId = $request->articleId;
        $parentId = $request->parentId;
        $comment = $request->comment;

        Comment::create([
            "parent_id" => $parentId,
            "article_id" => $articleId,
            "body" => $comment,
            "created_by" => $member_full_name,
            "allow" => "1"
        ]);

        return back()->with('success', 'Comment saved successfully!');
    }
}
