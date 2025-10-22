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
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Cadastrar Novo Pokémon</h1>
                
                <form method="POST" enctype="multipart/form-data" class="space-y-4" onsubmit="return checkFileSize()">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nome:</label>
                        <input type="text" name="nome" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo:</label>
                        <select name="tipo_id" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecione um tipo</option>
                            <?php
                                require_once 'config.php';
                                $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                $tipos = mysqli_query($conexao, "SELECT id, tipo FROM tipos");
                                while($tipo = mysqli_fetch_array($tipos)) {
                                    echo "<option value='".$tipo['id']."'>".$tipo['tipo']."</option>";
                                }
                                mysqli_close($conexao);
                            ?>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Poder:</label>
                        <select name="poder_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecione um poder</option>
                            <?php
                                require_once 'config.php';
                                $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                $poderes = mysqli_query($conexao, "SELECT id, nome FROM poderes");
                                while($poder = mysqli_fetch_array($poderes)) {
                                    echo "<option value='".$poder['id']."'>".$poder['nome']."</option>";
                                }
                                mysqli_close($conexao);
                            ?>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Imagem:</label>
                        <input type="file" name="imagem" accept="image/*" id="imagem"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <small id="file-size-warning" style="color: red; display: none;">
                            ⚠️ Arquivo muito grande! Use imagens menores que 2MB.
                        </small>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                        Cadastrar Pokémon
                    </button>
                    
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        require_once 'config.php';
                        $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        
                        $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
                        $tipo_id = $_POST['tipo_id'];
                        $poder_id = $_POST['poder_id'] ? $_POST['poder_id'] : NULL;
                        
                        $imagem_nome = NULL;
                        
                        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                            $extensao = strtolower($extensao);
                            
                            if (in_array($extensao, ['jpg', 'jpeg', 'png', 'gif'])) {
                                $novo_nome = uniqid('pokemon_') . '.' . $extensao;
                                $pasta_upload = 'imagens/';
                                
                                if (!is_dir($pasta_upload)) {
                                    mkdir($pasta_upload, 0777, true);
                                }
                                
                                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $pasta_upload . $novo_nome)) {
                                    $imagem_nome = $novo_nome;
                                }
                            }
                        }
                        
                        $query = "INSERT INTO pokemons (nome, tipo_id, poder_id, imagem) 
                                VALUES ('$nome', '$tipo_id', " . ($poder_id ? "'$poder_id'" : "NULL") . ", " . ($imagem_nome ? "'$imagem_nome'" : "NULL") . ")";
                        
                        if (mysqli_query($conexao, $query)) {
                            echo '<div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">';
                            echo '✅ Pokémon cadastrado com sucesso!';
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

<script>
    function checkFileSize() {
        const fileInput = document.getElementById('imagem');
        const warning = document.getElementById('file-size-warning');
        
        if (fileInput.files[0]) {
            const fileSize = fileInput.files[0].size;
            const maxSize = 2 * 1024 * 1024;
            
            if (fileSize > maxSize) {
                warning.style.display = 'block';
                fileInput.focus();
                return false;
            } else {
                warning.style.display = 'none';
            }
        }
        return true;
    }

    document.getElementById('imagem').addEventListener('change', checkFileSize);
</script>