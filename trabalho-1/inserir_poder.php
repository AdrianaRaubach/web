<nav>
    <a href="/inserir_tipo.php"> Inserir novo tipo.</a>
    <a href="/inserir_poder.php"> Inserir novo poder.</a>
    <a href="/inserir_pokemon.php">Inserir novo pokemon</a>
    <a href="/pokemon.php"> Ver lista de pokemons.</a>
    <a href="/poderes.php"> Ver lista de poderes.</a>
    <a href="/tipos.php"> Ver lista de tipos.</a>
</nav>
<form action="inserir_poder.php" method="POST">

        <label>Poder: </label><br>
        <input type="text" name="poder" required><br> 
        <button type="submit">Enviar</button>
    </form>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once 'config.php';

    $poder=$_POST["poder"];
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or print(mysqli_error());

    $query = "insert into poderes(nome) values ('". $poder."')";

    echo $query;


    $resultado = mysqli_query($conexao,$query);
    echo "<h3> Poder cadastrado com sucesso!</h3><br>";
    

    mysqli_close($conexao);
}

?>
