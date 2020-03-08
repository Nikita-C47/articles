@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="card">
        <div class="card-body">
            {{ $article->content }}
        </div>
        <div class="card-footer text-muted">
            {{ $article->created_at->diffForHumans() }}
        </div>
    </div>
@endsection
