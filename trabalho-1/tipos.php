<?php
$conexao = mysqli_connect("localhost","root","mysqluser","pokemons") or print (mysqli_error());

$query = "SELECT id, tipo FROM tipos ORDER BY tipo ASC ";

$resultado = mysqli_query($conexao,$query);
?>


<a href="/inserir_tipo.php"> Inserir novo tipo.</a>
<a href="/pokemon.php"> Ver lista de pokemons.</a>
<table border="1"><tr>
	<td><b>Nome</b></td>
</tr>

<?php


while($linha = mysqli_fetch_array($resultado)){
    echo "<tr><td>".$linha['tipo']."</td>
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