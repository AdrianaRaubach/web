<nav>
    <a href="/inserir_tipo.php"> Inserir novo tipo.</a>
    <a href="/inserir_poder.php"> Inserir novo poder.</a>
    <a href="/inserir_pokemon.php">Inserir novo pokemon</a>
    <a href="/pokemon.php"> Ver lista de pokemons.</a>
    <a href="/poderes.php"> Ver lista de poderes.</a>
    <a href="/tipos.php"> Ver lista de tipos.</a>
</nav>
<?php
    require_once 'config.php';
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or print(mysqli_error());

$query = "SELECT id, nome, tipo_id FROM poderes ORDER BY nome ASC ";

$resultado = mysqli_query($conexao,$query);
?>


<table border="1"><tr>
	<td><b>Nome</b></td>
</tr>

<?php


while($linha = mysqli_fetch_array($resultado)){
    echo "<tr><td>".$linha['nome']."</td>
    <td>
        <form action='remover.php' method='POST'>
            <input type='hidden' name='id_para_remover' value=".$linha['id'].">
            <button type='submit'> Remover </button>
        </form>
    </td>

    <td>
        <form action='editar.php' method='POST'>
            <input type='hidden' name='id_para_editar' value=".$linha['id'].">
            <button type='submit'> Editar </button>
        </form>
    </td>






    </tr>
    
    <br />";
}

mysqli_close($conexao);

?>