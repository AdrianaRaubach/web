<form action="inserir_tipo.php" method="POST">

        <label>Tipo: </label><br>
        <input type="text" name="tipo" required><br> 
    </form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $tipo=$_POST["tipo"];
    $conexao = mysqli_connect("localhost","root","mysqluser","pokemons") or print (mysqli_error());

    $query = "insert into tipos(tipo) values ('". $tipo."')";

    echo $query;


    $resultado = mysqli_query($conexao,$query);
    echo "<h3> Tipo cadastrado com sucesso!</h3><br>";
    

    mysqli_close($conexao);
}

?>
<a href="/tipos.php"> Voltar para a tela principal </a>