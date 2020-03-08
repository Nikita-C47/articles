@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    @if(count($articles) > 0)
        @foreach($articles as $article)
            <div class="card mb-3 border-primary">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('show-article', ['id' => $article->id]) }}">{{ $article->title }}</a>
                    </h5>
                    <p class="card-text">
                        {{ $article->preview }}
                    </p>
                </div>
                <div class="card-footer text-muted">
                    <div class="float-left">
                        {{ $article->created_at->diffForHumans() }}
                    </div>
                    <div class="float-right text-info">
                        Комментариев: {{ $article->comments_count }}
                    </div>
                </div>
            </div>
        @endforeach
        {{ $articles->links() }}
    @else
    <div class="jumbotron">
        <h1 class="display-4">Добро пожаловать!</h1>
        <p class="lead">
            На нашем ресурсе Вы можете прочитать самые интересные статьи на совершенно разные темы, а также
            делиться своим мнением в комментариях.
        </p>
        <hr class="my-4">
        <p>
            Судя по всему, еще не было добавлено ни одной статьи. Попробуйте зайти позже.
        </p>
        @auth
            <a class="btn btn-primary btn-lg" href="{{ route('create-article') }}" role="button">Добавить статью</a>
        @endauth
    </div>
    @endif
@endsection
