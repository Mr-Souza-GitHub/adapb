<?php
    include("../bootstrap-links.php");
    // include("../navbar.php");
?>

<?php
    //header("localhost:6969/adapb-main/adm");

    //PEGANDO VALORES DO FORMULARIO ATRAVÉS DO POST
    if(isset($_POST)) {
        print_r($_POST);
    $codigoanimal = $_POST["codanimal"];
    $nomeanimal = $_POST["nomeanimal"];
    $sexoanimal = $_POST["sexoanimal"];
    $tipoanimal = $_POST["tipoanimal"];
    $racaanimal = $_POST["racaanimal"];
    $deficienciasanimal = $_POST["deficienciasanimal"];
    $doencasanimal = $_POST["doencasanimal"];
    $vacinacaoanimal = $_POST["vacinacaoanimal"];
    $descricaoanimal = $_POST["descricaoanimal"];
    }
    //"SANIZING" OS DADOS PARA EVITAR SQL INJECTION
    $str_codigo = pg_escape_string($codigoanimal);
    $str_nome = pg_escape_string($nomeanimal);
    $str_sexo = pg_escape_string($sexoanimal);
    $str_tipo = pg_escape_string($tipoanimal);
    $str_raca = pg_escape_string($racaanimal);

    //echo $str_codigo;
    //$str_deficiencias = array();
    print_r($deficienciasanimal);
        foreach ($deficienciasanimal as $deficiencia) {
            echo $deficiencia;
            $str_deficiencias[] = pg_escape_string($deficiencia);
        }
    //$str_doencas = array();
        foreach ($doencasanimal as $doenca) {
            $str_doencas[] = pg_escape_string($doenca);
        }
    $str_vacinacao = pg_escape_string($vacinacaoanimal);
    $str_descricao = pg_escape_string($descricaoanimal);
    

    // EXECUÇÃO DOS CÓDIGOS
    include("../conexao.php");

    $dados_consulta = pg_fetch_assoc(pg_query("SELECT * FROM ANIMAL WHERE codanimal = {$str_codigo};"));
    
    // Variável que verifica se os dados referentes a tabela ANIMAL sofreram qualquer alteração
    $alterado = (!($str_nome == $dados_consulta["nomeanimal"] and $str_sexo == $dados_consulta["sexoanimal"] and $str_tipo == $dados_consulta["tipoanimal"] and $str_raca == $dados_consulta["racaanimal"] and $str_vacinacao == $dados_consulta["vacinacaoanimal"] and $str_descricao == $dados_consulta["descricaoanimal"])) ? true : false;

    echo ("alterado: " .$alterado);

    // Se for alterado, executa a atualização
    if ($alterado) {
        $sql_edicao_animal = "UPDATE ANIMAL
        SET nomeanimal = '{$str_nome}', sexoanimal = {$str_sexo}, tipoanimal = {$str_tipo}, racaanimal = {$str_raca}, vacinacaoanimal = {$str_vacinacao}, descricaoanimal = '{$str_descricao}'
        WHERE codanimal = {$str_codigo};";

        if(!pg_query($sql_edicao_animal)) {
            echo ("<p class='min-vh-100 text-warning text-uppercase text-center p-5'>Erro ao editar os dados!</p>");
        } else {
            echo ("<p class='min-vh-100 text-success text-uppercase text-center p-5'>Edicao efetuado com sucesso!</p>");
        }
    }
    // Verificar se alguma deficiência/doença está marcada, e se são diferentes das cadastradas em suas respectivas tabelas se foram desmarcadas

    // PRIMEIRO, precisa-se ds valores de cada deficiência cadastrada na tabela ANIMALDEFICIENCIA.

    // Para as DEFICIÊNCIAS
    $sql_consulta_animaldeficiencia = "select array_agg(coddeficiencia) from  (select * from animal as an 
    inner join ANIMALDEFICIENCIA as ad on an.codanimal = ad.ANIMALPORTADOR 
    inner join  DEFICIENCIA as d on ad.PORTADEFICIENCIA = d.CODDEFICIENCIA) as tabela where codanimal = {$str_codigo};";
    $resultado_animaldeficiencia = pg_fetch_assoc(pg_query($sql_consulta_animaldeficiencia));

    // consultar a tabela, verificar se as marcadas são as mesmas da tabela
    $alterado_deficiencias = (!($resultado_animaldeficiencia == $str_deficiencias)) ? true : false;

    // VERIFICA SE HÁ OU NÃO DEFICIÊNCIAS / DOENÇAS MARCADAS E ADICIONA ELAS AO ANIMAL CASO HAJAM.
    if ($alterado_deficiencias) {
        pg_query("DELETE FROM ANIMALDEFICIENCIA WHERE ANIMALPORTADOR = {$str_codigo}");

        if(isset($str_deficiencias)) {
            // FAZ LOOP PELO ARRAY
            foreach ($str_deficiencias as $codigodeficiencia) {
                $sql_edicao_animaldeficiencia = "INSERT INTO ANIMALDEFICIENCIA (ANIMALPORTADOR, PORTADEFICIENCIA) VALUES ({$str_codigo}, {$codigodeficiencia}); ";
    
                pg_query($sql_edicao_animaldeficiencia);
            }
        }
    }

    // Para as DOENÇAS
    $sql_consulta_animaldoenca = "select array_agg(coddoenca) from  (select * from animal as an 
    inner join ANIMALDOENCA as ad on an.codanimal = ad.ANIMALPORTADOR 
    inner join  DOENCA as d on ad.PORTADOENCA = d.CODDOENCA) as tabela where codanimal = {$str_codigo};";
    $resultado_animaldoenca = pg_fetch_assoc(pg_query($sql_consulta_animaldoenca));

    // consultar a tabela, verificar se as marcadas são as mesmas da tabela
    $alterado_doencas = (!($resultado_animaldoenca == $str_doencas)) ? true : false;

    // VERIFICA SE HÁ OU NÃO DEFICIÊNCIAS / DOENÇAS MARCADAS E ADICIONA ELAS AO ANIMAL CASO HAJAM.
    if ($alterado_doencas) {
        pg_query("DELETE FROM ANIMALDOENCA WHERE ANIMALPORTADOR = {$str_codigo}");

        if(isset($str_doencas)) {
            // FAZ LOOP PELO ARRAY
            foreach ($str_doencas as $codigodoenca) {
                $sql_edicao_animaldoenca = "INSERT INTO ANIMALdoenca (ANIMALPORTADOR, PORTAdoenca) VALUES ({$str_codigo}, {$codigodoenca}); ";
    
                pg_query($sql_edicao_animaldoenca);
            }
        }
    }
    
    pg_close($abrir_conexao);
    // REDIRECIONA A PAGINA DE VOLTA PARA A LISTA DE ANIMAIS
    // echo ('<meta http-equiv="refresh" content="5; url=http://localhost:6969/adapb-main/adm/">');
    //ALTERNATIVA - echo ("<script>window.location='http://localhost:6969/adapb-main/adm';</script>");
    //ALTERNATIVA - header("Location: http://localhost:6969/adapb-main/adm");
?>