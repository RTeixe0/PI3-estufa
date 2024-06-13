<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estufa - PI3</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Link para o CSS customizado -->
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <i class="fas fa-seedling"></i> Controle de Estufa
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" id="cab">
                    <a class="nav-link" href="#">HOME</a>
                </li>
                <li class="nav-item" id="cab">
                    <a class="nav-link" href="#">COMENTÁRIOS</a>
                </li>
                <li class="nav-item" id="cab">
                    <a class="nav-link" href="#">LOGIN</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo ao Controle de Estufa</h1>
        <p class="text-center">Gerencie sua estufa de forma eficiente e inteligente.</p>
    </div>

    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('comments.store') }}">
            @csrf
            <div class="form-group">
                <label for="comment">Deixe um Comentário:</label>
                <textarea name="comment" id="comment" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        @if(isset($comments) && $comments->isEmpty())
        @elseif(isset($comments))
            @foreach($comments as $comment)
                <div class="comment">
                    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}</p>
                </div>
            @endforeach
        @else
        @endif
    </div>

    <footer class="bg-secondary text-white pt-1 pb-1 mt-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <p>Desenvolvido para auxiliar no controle de estufas</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
