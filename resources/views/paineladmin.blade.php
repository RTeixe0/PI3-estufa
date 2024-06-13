@extends('layouts.app')

@section('title', 'Painel Administrativo - Comentários')

@section('content')
<div class="container mt-4">
    <h2>Comentários Pendentes</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Comentário</th>
                <th>Resposta</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->comment }}</td>
                    <td>{{ $comment->response }}</td>
                    <td>{{ $comment->status }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.comments.update', $comment->id) }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success">Aprovar</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comments.update', $comment->id) }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger">Reprovar</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comments.update', $comment->id) }}" class="d-inline">
                            @csrf
                            <input type="text" name="response" placeholder="Adicionar resposta" required>
                            <button type="submit" class="btn btn-primary">Responder</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">Clique aqui para retornar à página inicial</a>
</div>
@endsection
