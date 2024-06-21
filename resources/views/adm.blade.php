<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="{{ asset('style1.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<header>
    <nav class="navbar navbar-light " id="nav-inicial1">
        <div class="container-fluid">
            <div class="icone-flor">
            <i class="ph ph-plant"></i>
            </div>
            <div class="escrita-painel">
            <h1>Painel Administrativo</h1>
            </div>
            <div class="logout">
            <a class="nav-link"  href="{{ route('index') }}">HOME</a>
            <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            LOGOUT
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
            </div>
        </div>
    </nav>

    </header>
<body style="background-color: #212529;">

    <main>
        <div class="button-container">
            <a href="estufa1" class="button">
            <i class="ph ph-tree"></i><br>
                <span>Relatório por data</span>
            </a>
            <a href="admin" class="button">
            <i class="ph ph-acorn"></i>
                <span>Relatório - Log</span>   <!-- Lembrar de trocar ID da tabela por data, pedido Renan -->
            </a>
        </div>
    </main>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <footer>
        <p>Desenvolvido para auxiliar no Gerenciamento de Estufas!</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</body>
</html>
