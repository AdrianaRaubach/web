<form action="inserir_tipo.php" method="POST">

        <label for="nome_pokemon">Nome: </label><br>
        <input type="text" name="nome_pokemon" required><br> 
        
    </form>

<?php

while($linha = mysqli_fetch_array($resultado)){
    echo "
        <label for=".$linha['id']">.$linha['tipo_nome']</label>
        <select name=".$linha['id']" id=".$linha['id']"></select>

    
    <br />";
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $tipo=$_POST["tipo"];
    $conexao = mysqli_connect("localhost","root","mysqluser","pokemons") or print (mysqli_error());

    $query = "insert into tipos(tipo) values ('". $tipo."')";tipo

    echo $query;


    $resultado = mysqli_query($conexao,$query);
    echo "<h3> Tipo cadastrado com sucesso!</h3><br>";
    

    mysqli_close($conexao);
}

?>
<a href="/tipos.php"> Voltar para a tela principal </a>