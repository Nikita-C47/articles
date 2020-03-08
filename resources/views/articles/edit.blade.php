@extends('layouts.app')

@section('title', 'Редактировать статью #'.$article->id)

@section('content')
    <div class="card border-primary">
        <div class="card-body">
            <form method="post">
                @csrf
                <div class="form-group">
                    <label for="title" class="font-weight-bold">
                        Заголовок: <span class="text-danger">*</span>
                    </label>
                    <input id="title"
                           type="text"
                           class="form-control @error('title') is-invalid @enderror"
                           name="title"
                           value="{{ $article->title }}"
                           required
                           autocomplete="title"
                           autofocus>
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content" class="font-weight-bold">
                        Текст: <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('content') is-invalid @enderror"
                              rows="6"
                              style="resize: none;"
                              id="content"
                              required
                              autocomplete="content"
                              name="content">{{ $article->content }}</textarea>
                    @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                               class="custom-control-input"
                               id="published"
                               name="published" @if($article->published) checked @endif>
                        <label class="custom-control-label" for="published">Опубликовано</label>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">
                        Сохранить статью
                    </button>
                    <a href="{{ route('articles') }}" class="btn btn-primary">
                        К списку
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
