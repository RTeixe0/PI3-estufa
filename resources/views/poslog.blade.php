<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        // Função que será chamada após 1 segundo
        function redirect() {
            // Redireciona para o link especificado
            window.location.href = "{{ route('index') }}";
        }

        // Configura um timer para chamar a função redirect após 1000 milissegundos (1 segundo)
        setTimeout(redirect, 1000);
    </script>
</head>
<body>
    <a href="{{ route('index') }}">Clique aqui para retornar a página!</a>
</body>
</html>