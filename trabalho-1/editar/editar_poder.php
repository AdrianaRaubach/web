<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Erro na conexão");
    
    $id = mysqli_real_escape_string($conexao, $_POST['id']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $tipo_id = mysqli_real_escape_string($conexao, $_POST['tipo_id']);
    
    $query_check = "SELECT id FROM poderes WHERE nome = '$nome' AND id != $id";
    $resultado_check = mysqli_query($conexao, $query_check);
    
    if (mysqli_num_rows($resultado_check) > 0) {
        echo "<script>alert('Já existe um poder com este nome!');</script>";
    } else {
        $query = "UPDATE poderes SET nome = '$nome', tipo_id = '$tipo_id' WHERE id = $id";
        
        if (mysqli_query($conexao, $query)) {
            mysqli_close($conexao);
            header("Location: ../poderes.php");
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar poder: " . mysqli_error($conexao) . "');</script>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_para_editar'])) {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Erro na conexão");
    
    $id = mysqli_real_escape_string($conexao, $_POST['id_para_editar']);
    $query = "SELECT p.*, t.tipo as nome_tipo 
              FROM poderes p 
              LEFT JOIN tipos t ON p.tipo_id = t.id 
              WHERE p.id = $id";
    $resultado = mysqli_query($conexao, $query);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $poder = mysqli_fetch_assoc($resultado);
    } else {
        header("Location: ../poderes.php");
        exit();
    }
} else {
    header("Location: ../poderes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Poder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex flex-wrap gap-4 justify-center">
            <a href="/inserir_tipo.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Inserir novo tipo</a>
            <a href="/inserir_poder.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Inserir novo poder</a>
            <a href="/inserir_pokemon.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Inserir novo pokemon</a>
            <a href="/tipos.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver lista de tipos</a>
            <a href="/poderes.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver lista de poderes</a>
            <a href="/pokemon.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver lista de pokemons</a>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Poder</h1>
            
            <form action="" method="POST" class="space-y-4">
                <input type="hidden" name="id" value="<?= $poder['id'] ?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Poder:</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($poder['nome']) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required
                           placeholder="Ex: Lança-chamas, Jato d'Água, Trovão...">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo do Poder:</label>
                    <select name="tipo_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Selecione um tipo</option>
                        <?php
                        $tipos_query = mysqli_query($conexao, "SELECT id, tipo FROM tipos ORDER BY tipo");
                        while($tipo = mysqli_fetch_array($tipos_query)) {
                            $selected = $tipo['id'] == $poder['tipo_id'] ? 'selected' : '';
                            echo "<option value='{$tipo['id']}' $selected>{$tipo['tipo']}</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <?php if ($poder['nome_tipo']): ?>
                <div class="bg-gray-50 p-3 rounded-md">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Tipo atual:</span> 
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-sm ml-2">
                            <?= $poder['nome_tipo'] ?>
                        </span>
                    </p>
                </div>
                <?php endif; ?>
                
                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                        Atualizar Poder
                    </button>
                    <a href="../poderes.php" 
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