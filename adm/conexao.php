<?php 
    $servidor = "localhost";
    $porta = "5432";
    $banco = "ada";
    $usuario = "postgres";
    $senha = "123";

    $info_string = "host=$servidor port=$porta dbname=$banco user=$usuario password=$senha";

    $abrir_conexao = pg_connect($info_string) or die ("Não foi possível conectar ao PostgreSQL!");
    // echo "Conexão com PostgreSQL estabelecida com sucesso!";
?>