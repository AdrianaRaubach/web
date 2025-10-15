<?php
    $conexao = mysqli_connect("localhost","root","mysqluser","pokemons") or print (mysqli_error());

    $query = "SELECT id, tipo FROM tipos";
    $resultado = mysqli_query($conexao,$query);

?>



<nav>
    <a href="/inserir_tipo.php"> Inserir novo tipo.</a>
    <a href="/inserir_poder.php"> Inserir novo poder.</a>
    <a href="/inserir_pokemon.php">Inserir novo pokemon</a>
    <a href="/pokemon.php"> Ver lista de pokemons.</a>
    <a href="/poderes.php"> Ver lista de poderes.</a>
    <a href="/tipos.php"> Ver lista de tipos.</a>
</nav>

<form action="inserir_pokemon.php" method="POST">
    
        <div>
            <label for="nome_pokemon">Nome: </label><br>
            <input type="text" name="nome_pokemon" required><br> 
        </div>
        <div>
            <label for="tipo_pokemon">Tipo:</label>
            <select name="tipo_pokemon" id="tipo_pokemon">
                <?php
                while ($linha=mysqli_fetch_array($resultado)){
                    echo "<option value=".$linha['id']." name=".$linha['id'].">".$linha['tipo']."</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit">Enviar</button>
    </form>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $pokemon=$_POST["pokemon"];
    $nome_pokemon=$_POST["nome_pokemon"];
    $tipo_id=$_POST["tipo_pokemon"];

    $query = "insert into pokemons(nome_pokemon, tipo_id) values ('". $nome_pokemon."','".$tipo_id."')";

    echo $query;

    $resultado = mysqli_query($conexao,$query);
    echo "<h3> Pokemon cadastrado com sucesso!</h3><br>";
    
    mysqli_close($conexao);
}

?>