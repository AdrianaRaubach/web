<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Erro na conexão");
    
    $id = mysqli_real_escape_string($conexao, $_POST['id']);
    $tipo_nome = mysqli_real_escape_string($conexao, $_POST['tipo']);
    
    $query_check = "SELECT id FROM tipos WHERE tipo = '$tipo_nome' AND id != $id";
    $resultado_check = mysqli_query($conexao, $query_check);
    
    if (mysqli_num_rows($resultado_check) > 0) {
        echo "<script>alert('Já existe um tipo com este nome!');</script>";
    } else {
        $query = "UPDATE tipos SET tipo = '$tipo_nome' WHERE id = $id";
        
        if (mysqli_query($conexao, $query)) {
            mysqli_close($conexao);
            header("Location: ../tipos.php");
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar tipo: " . mysqli_error($conexao) . "');</script>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_para_editar'])) {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Erro na conexão");
    
    $id = mysqli_real_escape_string($conexao, $_POST['id_para_editar']);
    $query = "SELECT * FROM tipos WHERE id = $id";
    $resultado = mysqli_query($conexao, $query);
    $tipo = mysqli_fetch_assoc($resultado);
    
    if (!$tipo) {
        header("Location: ../tipos.php");
        exit();
    }
} else {
    header("Location: ../tipos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tipo</title>
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
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Tipo</h1>
            
            <form action="" method="POST" class="space-y-4">
                <input type="hidden" name="id" value="<?= $tipo['id'] ?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Tipo:</label>
                    <input type="text" name="tipo" value="<?= htmlspecialchars($tipo['tipo']) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required
                           placeholder="Ex: Fogo, Água, Elétrico...">
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                        Atualizar Tipo
                    </button>
                    <a href="../tipos.php" 
                       class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php mysqli_close($conexao); ?>
</body>
</html>