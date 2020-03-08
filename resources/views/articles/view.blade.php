@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="card border-primary">
        <div class="card-body">
            {{ $article->content }}
        </div>
        <div class="card-footer text-muted">
            <div class="float-left">
                Добавлено: {{ $article->created_at->format('d.m.Y H:i:s') }}
                <br>
                Изменено: {{ $article->updated_at->format('d.m.Y H:i:s') }}
            </div>
            <div class="float-right">
                <a href="{{ route('edit-article', ['id' => $article->id]) }}" class="btn btn-primary">
                    Редактировать
                </a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletionModal">
                    Удалить
                </button>
                <!-- Modal -->
                <div class="modal fade" id="deletionModal" tabindex="-1" role="dialog" aria-labelledby="deletionModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deletionModalLabel">Подтверждение удаления</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <span class="text-danger">ВНИМАНИЕ!</span>
                                <span>
                                    Вы действительно хотите удалить эту запись? Это действие необратимо!
                                </span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                <form method="post" action="{{ route('delete-article', ['id' => $article->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($comments) > 0)
        <div class="mt-3">
            <h4>Комментарии ({{ $article->comments_count }}):</h4>
            <div class="table-responsive-sm">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Автор</th>
                        <th>Текст</th>
                        <th>Добавлен</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->author }}</td>
                            <td>{{ $comment->content }}</td>
                            <td>{{ $comment->created_at->format('d.m.Y H:i:s') }}</td>
                            <td>
                                <confirmation-modal v-bind:id="{{ $comment->id }}"
                                                    v-bind:entity_name="'{{ $comment->id }}'"
                                                    v-bind:action="'{{ route('delete-comment', ['id' => $comment->id]) }}'"></confirmation-modal>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                {{ $comments->links() }}
            </div>
        </div>
    @endif
@endsection
