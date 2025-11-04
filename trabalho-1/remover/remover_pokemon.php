<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_para_remover'])) {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Erro na conexão");
    
    $id = mysqli_real_escape_string($conexao, $_POST['id_para_remover']);
    
    $query_select = "SELECT nome FROM pokemons WHERE id = $id";
    $resultado = mysqli_query($conexao, $query_select);
    $pokemon = mysqli_fetch_assoc($resultado);
    $nome_pokemon = $pokemon['nome'];
    
    $query_delete = "DELETE FROM pokemons WHERE id = $id";
    
    if (mysqli_query($conexao, $query_delete)) {
        session_start();
        $_SESSION['mensagem'] = "Pokémon '{$nome_pokemon}' removido com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        session_start();
        $_SESSION['mensagem'] = "Erro ao remover Pokémon: " . mysqli_error($conexao);
        $_SESSION['tipo_mensagem'] = "error";
    }
    
    mysqli_close($conexao);
    header("Location: ../pokemon.php");
    exit();
} else {
    header("Location: ../pokemon.php");
    exit();
}
?>