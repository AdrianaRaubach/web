

<nav>
    <a href="/inserir_tipo.php"> Inserir novo tipo.</a>
    <a href="/inserir_poder.php"> Inserir novo poder.</a>
    <a href="/inserir_pokemon.php">Inserir novo pokemon</a>
    <a href="/tipos.php"> Ver tipos.</a>
    <a href="/poderes.php"> Ver poderes.</a>
    <a href="/pokemon.php"> Pokédex.</a>
</nav>


<?php
    require_once 'config.php';
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or print(mysqli_error());


mysqli_close($conexao);

?>