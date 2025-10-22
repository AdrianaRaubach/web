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
            <a href="/pokemon.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver lista de pokemons</a>
            <a href="/poderes.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver lista de poderes</a>
            <a href="/tipos.php" class="hover:bg-blue-700 px-3 py-2 rounded transition">Ver lista de tipos</a>
        </div>
    </nav>

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
            
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Imagem</th>
                            <th class="px-4 py-3 text-left">Nome</th>
                            <th class="px-4 py-3 text-left">Tipo</th>
                            <th class="px-4 py-3 text-left">Poder</th>
                            <th class="px-4 py-3 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($linha = mysqli_fetch_array($resultado)): 
                            $tipo = $linha['nome_tipo'] ? $linha['nome_tipo'] : 'Nenhum';
                            $poder = $linha['nome_poder'] ? $linha['nome_poder'] : 'Nenhum';
                            $imagem = $linha['imagem'] ? 'imagens/' . $linha['imagem'] : 'imagens/sem_imagem.jpg';
                        ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <img src="<?= $imagem ?>" 
                                     alt="<?= $linha['nome'] ?>" 
                                     class="w-12 h-12 object-cover rounded-full border">
                            </td>
                            <td class="px-4 py-3 font-medium"><?= $linha['nome'] ?></td>
                            <td class="px-4 py-3">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">
                                    <?= $tipo ?>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-sm">
                                    <?= $poder ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <form action='remover.php' method='POST' class="inline">
                                    <input type='hidden' name='id_para_remover' value="<?= $linha['id'] ?>">
                                    <button type='submit' 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                        Remover
                                    </button>
                                </form>
                                <form action='editar.php' method='POST' class="inline">
                                    <input type='hidden' name='id_para_editar' value="<?= $linha['id'] ?>">
                                    <button type='submit' 
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">
                                        Editar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php mysqli_close($conexao); ?>
</body>
</html>