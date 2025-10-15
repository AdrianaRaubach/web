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
    </form>
<a href="/poderes.php"> Voltar para a tela principal </a>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $poder=$_POST["poder"];
    $conexao = mysqli_connect("localhost","root","mysqluser","pokemons") or print (mysqli_error());

    $query = "insert into poderes(nome_poder) values ('". $poder."')";

    echo $query;


    $resultado = mysqli_query($conexao,$query);
    echo "<h3> Poder cadastrado com sucesso!</h3><br>";
    

    mysqli_close($conexao);
}

?>
