@extends('template-blog.app')

@section('body')
    <!--------------------------------------
                                                                                                                HEADER
                                                                                                                --------------------------------------->
    <div class="container">
        <div class="jumbotron jumbotron-fluid mb-3 pt-0 pb-0 bg-lightblue position-relative">
            <div class="pl-4 pr-0 h-100 tofront">
                <div class="row justify-content-between">
                    <div class="col-md-6 pt-6 pb-6 align-self-center">
                        <h1 class="secondfont mb-3 font-weight-bold">
                            Blog dengan Topik-Topik Penting dalam Kehidupan Modern.
                        </h1>
                        <p class="mb-3">
                            Menyimpulkan Berbagai Aspek Penting Seperti Kesehatan Mental di Tempat Kerja, Pendidikan
                            Karakter, Manajemen Keuangan Pribadi, Teknologi Ramah Lingkungan, dan Manfaat Belajar Bahasa
                            Asing.
                        </p>
                    </div>
                    <div class="col-md-6 d-none d-md-block pr-0"
                        style="
                            background-size: cover;
                            background-image: url({{ asset('template-blog') }}/assets/img/demo/home.jpg);
                        ">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->
    <!--------------------------------------MAIN--------------------------------------->
    <div class="container mb-3">
        <form action="" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="{{ $data['request']->search }}" placeholder="Search Article" >
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
                            <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                data-target="#collapseExample"><i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Target Search</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="target_search_title"
                                            value="1" id="defaultCheck1" checked disabled>
                                        <label class="form-check-label" for="defaultCheck1">
                                            Title
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="target_search_content"
                                            value="1" id="defaultCheck2" {{ ($data['request']->target_search_content == "1")?"checked":"" }}>
                                        <label class="form-check-label" for="defaultCheck2">
                                            Content
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Order By</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target_search_order_by"
                                            value="newest" id="defaultCheck3" checked>
                                        <label class="form-check-label" for="defaultCheck3">
                                            Newest 
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target_search_order_by"
                                            value="oldest" id="defaultCheck4">
                                        <label class="form-check-label" for="defaultCheck4">
                                            Oldest
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-8">
                <h5 class="font-weight-bold spanborder">
                    <span>{{ $data['title_component'] }}</span>
                </h5>
                @foreach ($data['articles'] as $article)
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="pr-3">
                            <h2 class="mb-1 h4 font-weight-bold">
                                <a class="text-dark"
                                    href="{{ route('show-article', ['article_title' => strtolower(str_replace(' ', '-', $article->title))]) }}">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            <p>
                                @php
                                    $content = strip_tags($article->content);
                                    $words = explode(' ', $content);
                                    $words = array_slice($words, 0, 20);
                                    $excerpt = implode(' ', $words) . '...';
                                @endphp
                                {{ $excerpt }}
                            </p>
                            <div class="card-text text-muted small">
                                Author : {{ $article->author }}
                            </div>
                            @php
                                $date = new DateTime($article->post_date);
                                $formattedDate = $date->format('d F Y');
                            @endphp
                            <small class="text-muted">Post Date : {{ $formattedDate }}</small>
                        </div>
                        <img height="120" src="{{ asset('/assets/images/' . $article->image_cover) }}" />
                    </div>
                @endforeach
            </div>
            <div class="col-md-4 pl-4">
                <h5 class="font-weight-bold spanborder">
                    <span>Popular</span>
                </h5>
                <ol class="list-featured">
                    @foreach ($data['popular_articles'] as $popular_articles)
                        <li>
                            <span>
                                <h6 class="font-weight-bold">
                                    <a href="{{ route('show-article', ['article_title' => strtolower(str_replace(' ', '-', $popular_articles->title))]) }}"
                                        class="text-dark">{{ $popular_articles->title }}</a>
                                </h6>
                                <small>Viewer : {{ $popular_articles->viewer }}</small>
                                <p class="text-muted">Author : {{ $popular_articles->author }}</p>

                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endsection
