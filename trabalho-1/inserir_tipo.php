<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pokémon</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex flex-wrap gap-4 justify-center">
            <a href="/inserir_tipo.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Inserir novo tipo</a>
            <a href="/inserir_poder.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Inserir novo poder</a>
            <a href="/inserir_pokemon.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Inserir novo pokemon</a>
            <a href="/tipos.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver tipos</a>
            <a href="/poderes.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver poderes</a>
            <a href="/pokemon.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Pokédex</a>
        </div>
    </nav>
    <div class="container mx-auto p-6 max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Cadastrar Novo Tipo</h1>
            <form action="inserir_tipo.php" class="space-y-4" method="POST">
                <label  class="block text-sm font-medium text-gray-700 mb-1">Tipo: </label>
                <input type="text" name="tipo" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                    Cadastrar Tipo
                </button>

                <?php

                    if ($_SERVER["REQUEST_METHOD"] == "POST"){
                        require_once 'config.php';

                        $tipo=$_POST["tipo"];
                        $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or print(mysqli_error());

                        $query = "insert into tipos(tipo) values ('". $tipo."')";

                        $resultado = mysqli_query($conexao,$query);
                        
                        if (mysqli_query($conexao, $query)) {
                            echo '<div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">';
                            echo '✅ Tipo cadastrado com sucesso!';
                            echo '</div>';
                        } else {
                            echo '<div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">';
                            echo '❌ Erro: ' . mysqli_error($conexao);
                            echo '</div>';
                        }
                        

                        mysqli_close($conexao);
                    }

                    ?>
            </form>
        </div>
    </div>
    </body>
</html>

