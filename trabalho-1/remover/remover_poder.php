<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_para_remover'])) {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Erro na conexão");
    
    $id = mysqli_real_escape_string($conexao, $_POST['id_para_remover']);
    
    $query_check = "SELECT COUNT(*) as total FROM pokemons WHERE poder_id = $id";
    $resultado = mysqli_query($conexao, $query_check);
    $dados = mysqli_fetch_assoc($resultado);
    
    if ($dados['total'] > 0) {
        session_start();
        $_SESSION['mensagem'] = "Não é possível remover este poder pois está sendo usado em Pokémons!";
        $_SESSION['tipo_mensagem'] = "error";
    } else {
        $query_select = "SELECT nome FROM poderes WHERE id = $id";
        $resultado = mysqli_query($conexao, $query_select);
        $poder = mysqli_fetch_assoc($resultado);
        $nome_poder = $poder['nome'];
        
        $query_delete = "DELETE FROM poderes WHERE id = $id";
        
        if (mysqli_query($conexao, $query_delete)) {
            session_start();
            $_SESSION['mensagem'] = "Poder '{$nome_poder}' removido com sucesso!";
            $_SESSION['tipo_mensagem'] = "success";
        } else {
            session_start();
            $_SESSION['mensagem'] = "Erro ao remover poder: " . mysqli_error($conexao);
            $_SESSION['tipo_mensagem'] = "error";
        }
    }
    
    mysqli_close($conexao);
    header("Location: ../poderes.php");
    exit();
} else {
    header("Location: ../poderes.php");
    exit();
}
?>