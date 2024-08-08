@extends('template-blog.app')
@section('style')
    <style>
        .reply a {
            text-decoration: none;
        }
    </style>
@endsection
@section('body')
    <div class="container">
        <div class="jumbotron jumbotron-fluid mb-3 pt-0 pb-0 bg-lightblue position-relative">
            <div class="pl-4 pr-0 h-100 tofront">
                <div class="row justify-content-between">
                    <div class="col-md-6 pt-6 pb-6 align-self-center">
                        <h1 class="secondfont mb-3 font-weight-bold">
                            {{ $data['article']->title }}
                        </h1>
                    </div>
                    <div class="col-md-6 d-none d-md-block pr-0"
                        style="
                        background-size: cover;
                        background-image: url({{ asset('/assets/images/' . $data['article']->image_cover) }});
                    ">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-4 pb-4">
        <div class="row justify-content-center">
            <div class="col-lg-2 pr-4 mb-4 col-md-12">
                <div class="sticky-top text-center">
                    <div class="text-muted">
                        Share this
                    </div>
                    <div class="share d-inline-block">
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                            <a class="a2a_button_facebook"></a>
                            <a class="a2a_button_twitter"></a>
                        </div>
                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                        <!-- AddToAny END -->
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-8">
                <article class="article-post">
                    {!! $data['article']->content !!}
                </article>
                @if (session('member'))
                    <div class="border px-5 pb-5 pt-3 bg-lightblue">
                        <div class="card bg-lightblue">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-8 d-flex">
                                            <h3>Article Comments</h3>
                                        </div>
                                        <div class="col-4">
                                            <div class="float-right reply">
                                                <a href="javascript:void(0);" class="openCommentModal" data-toggle="modal"
                                                    data-target="#commentModal" data-article-id="{{ $data['article']->id }}"
                                                    data-parent-id="0">
                                                    <span><i class="fa fa-reply"></i>reply</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    @if (count($data['comments']) > 0)
                                        @foreach ($data['comments'] as $comment)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="media mt-4">
                                                        <div class="media-body">
                                                            <div class="row">
                                                                <div class="col-8 d-flex">
                                                                    <h5>{{ ucwords($comment->created_by) }}</h5>
                                                                    <span>&nbsp;- {{ $comment->created_at }}</span>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="float-right reply">
                                                                        <a href="javascript:void(0);"
                                                                            class="openCommentModal" data-toggle="modal"
                                                                            data-target="#commentModal"
                                                                            data-article-id="{{ $data['article']->id }}"
                                                                            data-parent-id="{{ $comment->id }}"><span><i
                                                                                    class="fa fa-reply"></i>reply</span></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{ $comment->body }}
                                                            @foreach ($data['comment_subs'] as $comment_sub)
                                                                @if ($comment_sub->parent_id == $comment->id)
                                                                    <div class="media mt-4">
                                                                        <a class="px-4" href="#">&nbsp;</a>
                                                                        <div class="media-body">
                                                                            <div class="row">
                                                                                <div class="col-12 d-flex">
                                                                                    <h5>{{ ucwords($comment_sub->created_by) }}
                                                                                    </h5>
                                                                                    <span>&nbsp;-
                                                                                        {{ $comment_sub->created_at }}</span>
                                                                                </div>
                                                                            </div>
                                                                            {{ $comment_sub->body }}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                --- No comment here---
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="border px-5 pb-5 pt-3 bg-lightblue">
                        <div class="row justify-content-between">
                            <div class="col-md-5 mb-2 mb-md-0">
                                {{-- <h5 class="font-weight-bold secondfont">Please Login</h5> --}}
                                <b>Please Login,</b> For View and Send Comment.
                            </div>
                            <div class="col-md-7">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                            href="#nav-home" role="tab" aria-controls="nav-home"
                                            aria-selected="true">Login</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                            href="#nav-profile" role="tab" aria-controls="nav-profile"
                                            aria-selected="false">Register</a>
                                    </div>
                                </nav>
                                <div class="tab-content mt-3" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <form method="POST" action="{{ route('member-login') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="Enter your e-mail address" required>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Enter your password" required>
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <button type="submit"
                                                        class="btn btn-success btn-block">Login</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                        aria-labelledby="nav-profile-tab">
                                        <form method="POST" action="{{ route('member-register') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <input type="text" class="form-control" name="full_name"
                                                        placeholder="Enter your full name" required>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="Enter your e-mail address" required>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Enter your password" required>
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <button type="submit"
                                                        class="btn btn-success btn-block">Register</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Modal Comment-->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('member-comment-send') }}">
                @csrf
                <input type="hidden" name="articleId" id="articleId">
                <input type="hidden" name="parentId" id="parentId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commentModalLabel">Comment Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sender">Sender : {{ session('member.full_name') }}</label>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send Comment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.openCommentModal').click(function() {
                var articleId = $(this).data('article-id');
                var parentId = $(this).data('parent-id');
                $('#commentModal #articleId').val(articleId);
                $('#commentModal #parentId').val(parentId);
            });
        });
    </script>
@endsection
