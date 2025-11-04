<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poderes de Pokémon</title>
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
                    po.id, 
                    po.nome, 
                    t.tipo as nome_tipo
                  FROM poderes po
                  LEFT JOIN tipos t ON po.tipo_id = t.id
                  ORDER BY po.nome ASC";

        $resultado = mysqli_query($conexao, $query);
        ?>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Lista de Poderes</h1>
            
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Nome do Poder</th>
                            <th class="px-4 py-3 text-left">Tipo</th>
                            <th class="px-4 py-3 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($linha = mysqli_fetch_array($resultado)): 
                            $tipo = $linha['nome_tipo'] ? $linha['nome_tipo'] : 'Nenhum';
                        ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium"><?= htmlspecialchars($linha['nome']) ?></td>
                            <td class="px-4 py-3">
                                <span class="bg-purple-100 text-purple-800 px-3 py-2 rounded-full text-sm font-medium">
                                    <?= htmlspecialchars($tipo) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <form action='remover/remover_poder.php' method='POST' class="inline">
                                    <input type='hidden' name='id_para_remover' value="<?= $linha['id'] ?>">
                                    <button type='submit' 
                                            onclick="return confirm('Tem certeza que deseja remover este poder?')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                        Remover
                                    </button>
                                </form>
                                <form action='editar/editar_poder.php' method='POST' class="inline">
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