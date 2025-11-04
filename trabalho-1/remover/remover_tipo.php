<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_para_remover'])) {
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Erro na conexão");
    
    $id = mysqli_real_escape_string($conexao, $_POST['id_para_remover']);
    
    $query_check = "SELECT 
        (SELECT COUNT(*) FROM pokemons WHERE tipo_id = $id) as total_pokemons,
        (SELECT COUNT(*) FROM poderes WHERE tipo_id = $id) as total_poderes";
    
    $resultado = mysqli_query($conexao, $query_check);
    $dados = mysqli_fetch_assoc($resultado);
    
    if ($dados['total_pokemons'] > 0 || $dados['total_poderes'] > 0) {
        session_start();
        $_SESSION['mensagem'] = "Não é possível remover este tipo pois está sendo usado em Pokémons ou Poderes!";
        $_SESSION['tipo_mensagem'] = "error";
    } else {
        $query_select = "SELECT tipo FROM tipos WHERE id = $id";
        $resultado = mysqli_query($conexao, $query_select);
        $tipo = mysqli_fetch_assoc($resultado);
        $nome_tipo = $tipo['tipo'];
        
        $query_delete = "DELETE FROM tipos WHERE id = $id";
        
        if (mysqli_query($conexao, $query_delete)) {
            session_start();
            $_SESSION['mensagem'] = "Tipo '{$nome_tipo}' removido com sucesso!";
            $_SESSION['tipo_mensagem'] = "success";
        } else {
            session_start();
            $_SESSION['mensagem'] = "Erro ao remover tipo: " . mysqli_error($conexao);
            $_SESSION['tipo_mensagem'] = "error";
        }
    }
    
    mysqli_close($conexao);
    header("Location: ../tipos.php");
    exit();
} else {
    header("Location: ../tipos.php");
    exit();
}
?>