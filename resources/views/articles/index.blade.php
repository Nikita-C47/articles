@extends('layouts.app')

@section('title', 'Список статей')

@section('content')
    @if(count($articles) > 0)
        <a href="{{ route('create-article') }}" class="btn btn-success">
            Добавить статью
        </a>
        <hr>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Заголовок</th>
                    <th>Опубликовано</th>
                    <th>Изменено</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>
                            {{ $article->id }}
                        </td>
                        <td>
                            <a href="{{ route('view-article', ['id' => $article->id]) }}">
                                {{ $article->title }}
                            </a>
                        </td>
                        <td>
                            @if($article->published)
                                <i class="fas fa-check text-success"></i>
                            @else
                                <i class="fas fa-times text-danger"></i>
                            @endif
                        </td>
                        <td>{{ $article->updated_at->format('d.m.Y H:i:s') }}</td>
                        <td>
                            <div class="row">
                                <div class="col pr-0">
                                    <a href="{{ route('edit-article', ['id' => $article->id]) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="col pl-0">
                                    <confirmation-modal v-bind:id="{{ $article->id }}"
                                                        v-bind:entity_name="'{{ $article->title }}'"
                                                        v-bind:action="'{{ route('delete-article', ['id' => $article->id]) }}'"></confirmation-modal>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        {{ $articles->links() }}
    @else
        <div class="alert alert-info" role="alert">
            В данный момент ни одной статьи не добавлено.
            Вы можете <a href="{{ route('create-article') }}" class="alert-link">создать первую</a>.
        </div>
    @endif
@endsection
