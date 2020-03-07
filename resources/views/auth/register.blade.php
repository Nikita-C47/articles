@extends('layouts.app')

@section('title', 'Зарегистрироваться')

@section('content')
    <div class="alert alert-info" role="alert">
        Введите свои учетные данные в форму ниже.
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name" class="font-weight-bold">
                Имя: <span class="text-danger">*</span>
            </label>
            <input id="name"
                   type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autocomplete="name"
                   autofocus>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="font-weight-bold">
                Email: <span class="text-danger">*</span>
            </label>
            <input id="email"
                   type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="font-weight-bold">
                Пароль: <span class="text-danger">*</span>
            </label>
            <input id="password"
                   type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password"
                   required
                   autocomplete="new-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm" class="font-weight-bold">
                Подтверждение пароля: <span class="text-danger">*</span>
            </label>
            <input id="password-confirm"
                   type="password"
                   class="form-control"
                   name="password_confirmation"
                   required
                   autocomplete="new-password">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Зарегистрироваться
            </button>
        </div>
    </form>
@endsection
