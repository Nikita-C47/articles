@extends('layouts.app')

@section('title', 'Добавить статью')

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
                           value="{{ old('title') }}"
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
                              name="content">{{ old('content') }}</textarea>
                    @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="published" name="published" checked>
                        <label class="custom-control-label" for="published">Опубликовано</label>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">
                        Добавить статью
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
