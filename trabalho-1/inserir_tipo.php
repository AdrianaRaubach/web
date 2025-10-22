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
            <a href="/pokemon.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver lista de pokemons</a>
            <a href="/poderes.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver lista de poderes</a>
            <a href="/tipos.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver lista de tipos</a>
        </div>
    </nav>
    <div class="container mx-auto p-6 max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Cadastrar Novo Tipo</h1>
            <form action="inserir_tipo.php" class="space-y-4" method="POST">
                <label>Tipo: </label>
                <input type="text" name="tipo" required><br> 
            </form>
        </div>
    </div>
    </body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once 'config.php';

    $tipo=$_POST["tipo"];
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or print(mysqli_error());

    $query = "insert into tipos(tipo) values ('". $tipo."')";

    echo $query;


    $resultado = mysqli_query($conexao,$query);
    echo "<h3> Tipo cadastrado com sucesso!</h3><br>";
    

    mysqli_close($conexao);
}

?>