@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="card border-primary">
        <div class="card-body">
            {{ $article->content }}
        </div>
        <div class="card-footer text-muted">
            {{ $article->created_at->diffForHumans() }}
        </div>
    </div>
    <div class="my-3">
        <button class="btn btn-primary"
                type="button"
                data-toggle="collapse"
                data-target="#addComment"
                aria-expanded="false"
                aria-controls="addComment">
            Добавить комментарий
        </button>
        <div class="collapse pt-3" id="addComment">
            <div class="card border-primary">
                <div class="card-body">
                    <form method="post" action="{{ route('create-comment') }}">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        @guest
                        <div class="form-group">
                            <label class="font-weight-bold" for="author">
                                Ваше имя: <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('author') is-invalid @enderror"
                                   value="{{ old('author') }}"
                                   required
                                   autocomplete="author"
                                   autofocus
                                   name="author"
                                   id="author" />
                            @error('author')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endguest
                        <div class="form-group">
                            <label for="content" class="font-weight-bold">
                                Текст комментария: <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      rows="6"
                                      style="resize: none;"
                                      id="content"
                                      required
                                      autocomplete="content"
                                      name="content">{{ old('content') }}</textarea>
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @guest
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{{ config('app.google_recaptcha.key') }}"></div>
                            @error('g-recaptcha-response')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endguest
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                Добавить комментарий
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(count($comments) > 0)
    <div>
        <h4>Комментарии ({{ $article->comments_count }}):</h4>
        @foreach($comments as $comment)
            <div class="card border-info mt-3">
                <div class="card-body">
                    {{ $comment->content }}
                </div>
                <div class="card-footer text-muted">
                    {{ $comment->author }}, {{ $comment->created_at->diffForHumans() }}
                </div>
            </div>
        @endforeach
    </div>
    <div class="pt-3">
        {{ $comments->links() }}
    </div>
    @endif
@endsection

@guest
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
@endguest
