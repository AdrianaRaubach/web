<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémons</title>
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

    <?php
        session_start();
        if (isset($_SESSION['mensagem'])) {
            $tipo = $_SESSION['tipo_mensagem'] ?? 'info';
            $cores = [
                'success' => 'bg-green-100 border-green-400 text-green-700',
                'error' => 'bg-red-100 border-red-400 text-red-700',
                'info' => 'bg-blue-100 border-blue-400 text-blue-700'
            ];
            $cor = $cores[$tipo] ?? $cores['info'];
        ?>
            <div class="container mx-auto p-6">
                <div class="<?= $cor ?> border px-4 py-3 rounded mb-4">
                    <?= $_SESSION['mensagem'] ?>
                </div>
            </div>
        <?php
            unset($_SESSION['mensagem']);
            unset($_SESSION['tipo_mensagem']);
        }
    ?>

    <div class="container mx-auto p-6">
        <?php
        require_once 'config.php';
        $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or print(mysqli_error());

        $query = "SELECT 
                    p.id, 
                    p.nome, 
                    t.tipo as nome_tipo, 
                    po.nome as nome_poder,
                    p.imagem
                  FROM pokemons p
                  LEFT JOIN tipos t ON p.tipo_id = t.id
                  LEFT JOIN poderes po ON p.poder_id = po.id
                  ORDER BY p.nome ASC";

        $resultado = mysqli_query($conexao, $query);
        ?>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Lista de Pokémons</h1>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <?php while($linha = mysqli_fetch_array($resultado)): 
                    $tipo = $linha['nome_tipo'] ? $linha['nome_tipo'] : 'Nenhum';
                    $poder = $linha['nome_poder'] ? $linha['nome_poder'] : 'Nenhum';
                    $imagem = $linha['imagem'] ? 'imagens/' . $linha['imagem'] : 'imagens/sem_imagem.jpg';
                ?>
                <div class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <!-- Imagem do Pokémon -->
                    <div class="p-4 flex justify-center">
                        <img src="<?= $imagem ?>" 
                             alt="<?= $linha['nome'] ?>" 
                             class="w-24 h-24 object-cover rounded-full border-4 border-gray-100">
                    </div>
                    
                    <!-- Informações do Pokémon -->
                    <div class="p-4 pt-0">
                        <h3 class="text-lg font-bold text-gray-800 text-center mb-3"><?= $linha['nome'] ?></h3>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-600 w-12">Tipo:</span>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm flex-1 text-center">
                                    <?= $tipo ?>
                                </span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-600 w-12">Poder:</span>
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-sm flex-1 text-center">
                                    <?= $poder ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Botões de Ação -->
                        <div class="flex gap-2">
                            <form action='remover/remover_pokemon.php' method='POST' class="flex-1">
                                <input type='hidden' name='id_para_remover' value="<?= $linha['id'] ?>">
                                <button type='submit' 
                                        onclick="return confirm('Tem certeza que deseja remover <?= $linha['nome'] ?>?')"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded text-sm transition">
                                    Remover
                                </button>
                            </form>
                            <form action='editar/editar_pokemon.php' method='POST' class="flex-1">
                                <input type='hidden' name='id_para_editar' value="<?= $linha['id'] ?>">
                                <button type='submit' 
                                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded text-sm transition">
                                    Editar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            
            <?php if(mysqli_num_rows($resultado) === 0): ?>
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg">Nenhum Pokémon cadastrado ainda.</p>
                <a href="/inserir_pokemon.php" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition">
                    Cadastrar Primeiro Pokémon
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php mysqli_close($conexao); ?>
</body>
</html>