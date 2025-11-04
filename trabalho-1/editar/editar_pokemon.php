<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Erro na conexão");
    
    $id = mysqli_real_escape_string($conexao, $_POST['id']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $tipo_id = mysqli_real_escape_string($conexao, $_POST['tipo_id']);
    $poder_id = mysqli_real_escape_string($conexao, $_POST['poder_id']);
    
    $imagem_nome = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid() . '.' . $extensao;
        $caminho_destino = '../imagens/' . $imagem_nome;
        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_destino)) {
            $query = "UPDATE pokemons SET nome = '$nome', tipo_id = '$tipo_id', poder_id = '$poder_id', imagem = '$imagem_nome' WHERE id = $id";
        } else {
            echo "<script>alert('Erro ao fazer upload da imagem!');</script>";
        }
    } else {
        $query = "UPDATE pokemons SET nome = '$nome', tipo_id = '$tipo_id', poder_id = '$poder_id' WHERE id = $id";
    }
    
    if (mysqli_query($conexao, $query)) {
        mysqli_close($conexao);
        header("Location: ../pokemon.php");
        exit();
    } else {
        echo "<script>alert('Erro ao atualizar Pokémon: " . mysqli_error($conexao) . "');</script>";
    }
    
    mysqli_close($conexao);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_para_editar'])) {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Erro na conexão");
    
    $id = mysqli_real_escape_string($conexao, $_POST['id_para_editar']);
    $query = "SELECT * FROM pokemons WHERE id = $id";
    $resultado = mysqli_query($conexao, $query);
    $pokemon = mysqli_fetch_assoc($resultado);
    
    if (!$pokemon) {
        header("Location: ../pokemon.php");
        exit();
    }
} else {
    header("Location: ../pokemon.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pokémon</title>
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
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Pokémon</h1>
            
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="id" value="<?= $pokemon['id'] ?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome:</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($pokemon['nome']) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo:</label>
                    <select name="tipo_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Selecione um tipo</option>
                        <?php
                        $tipos = mysqli_query($conexao, "SELECT id, tipo FROM tipos ORDER BY tipo");
                        while($tipo = mysqli_fetch_array($tipos)) {
                            $selected = $tipo['id'] == $pokemon['tipo_id'] ? 'selected' : '';
                            echo "<option value='{$tipo['id']}' $selected>{$tipo['tipo']}</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Poder:</label>
                    <select name="poder_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Selecione um poder</option>
                        <?php
                        $poderes = mysqli_query($conexao, "SELECT id, nome FROM poderes ORDER BY nome");
                        while($poder = mysqli_fetch_array($poderes)) {
                            $selected = $poder['id'] == $pokemon['poder_id'] ? 'selected' : '';
                            echo "<option value='{$poder['id']}' $selected>{$poder['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagem Atual:</label>
                    <?php if ($pokemon['imagem']): ?>
                        <img src="../imagens/<?= $pokemon['imagem'] ?>" alt="<?= $pokemon['nome'] ?>" class="w-24 h-24 object-cover rounded border mb-2">
                    <?php else: ?>
                        <p class="text-gray-500">Nenhuma imagem</p>
                    <?php endif; ?>
                    
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nova Imagem (opcional):</label>
                    <input type="file" name="imagem" accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                        Atualizar Pokémon
                    </button>
                    <a href="../pokemon.php" 
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