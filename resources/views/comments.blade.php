@extends('layouts.app')

@section('title', 'Comentários Aprovados')

@section('content')
<div class="container mt-4">
    <h2>Comentários Aprovados</h2>

    @foreach($comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}</p>
                @if($comment->response)
                    <div class="card mt-3">
                        <div class="card-body">
                            <p><strong>Resposta:</strong> {{ $comment->response }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">Clique aqui para retornar à página inicial</a>
</div>
@endsection
