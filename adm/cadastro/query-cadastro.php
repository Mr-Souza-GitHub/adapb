<?php
    include("../bootstrap-links.php");
    include("../navbar.php");
?>

<?php
    //header("localhost:6969/adapb-main/adm");

    //PEGANDO VALORES DO FORMULARIO ATRAVÉS DO POST
    $nomeanimal = $_POST["nomeanimal"];
    $sexoanimal = $_POST["sexoanimal"];
    $tipoanimal = $_POST["tipoanimal"];
    $racaanimal = $_POST["racaanimal"];
    $deficienciasanimal = $_POST["deficienciasanimal"];
    $doencasanimal = $_POST["doencasanimal"];
    $vacinacaoanimal = $_POST["vacinacaoanimal"];
    $descricaoanimal = $_POST["descricaoanimal"];

    //"SANIZING" OS DADOS PARA EVITAR SQL INJECTION
    $str_nome = pg_escape_string($nomeanimal);
    $str_sexo = pg_escape_string($sexoanimal);
    $str_tipo = pg_escape_string($tipoanimal);
    $str_raca = pg_escape_string($racaanimal);
    //$str_deficiencias = array();
        foreach ($deficienciasanimal as $deficiencia) {
            $str_deficiencias[] = pg_escape_string($deficiencia);
        }
    //$str_doencas = array();
        foreach ($doencasanimal as $doenca) {
            $str_doencas[] = pg_escape_string($doenca);
        }
    $str_vacinacao = pg_escape_string($vacinacaoanimal);
    $str_descricao = pg_escape_string($descricaoanimal);

    $sql_cadastro_animal = "INSERT INTO ANIMAL (NOMEANIMAL, SEXOANIMAL, TIPOANIMAL, RACAANIMAL, VACINACAOANIMAL, DESCRICAOANIMAL) VALUES ('{$str_nome}', {$str_sexo}, {$str_tipo}, {$str_raca}, {$str_vacinacao}, '{$str_descricao}');";

    include("../conexao.php");

    //pg_query($sql_cadastro_animal);
    if(!pg_query($sql_cadastro_animal)) {
        echo ("<p class='min-vh-100 text-warning text-uppercase text-center p-5'>Erro ao cadastrar!</p>");
    } else {
        echo ("<p class='min-vh-100 text-success text-uppercase text-center p-5'>Cadastro efetuado com sucesso!</p>");
        
        // REDIRECIONA A PAGINA DE VOLTA PARA A LISTA DE ANIMAIS
        echo ('<meta http-equiv="refresh" content="5; url=http://localhost:6969/adapb-main/adm/">');
        //ALTERNATIVA - echo ("<script>window.location='http://localhost:6969/adapb-main/adm';</script>");
        //ALTERNATIVA - header("Location: http://localhost:6969/adapb-main/adm");
    }

    // VERIFICA SE HÁ OU NÃO DEFICIÊNCIAS / DOENÇAS MARCADAS E ADICIONA ELAS AO ANIMAL CASO HAJAM.
        // PRIMEIRO, precisa-se do código do animal recém cadastrado.
        $sql_consulta_animal = "SELECT CODANIMAL FROM ANIMAL WHERE NOMEANIMAL = '{$str_nome}'; ";
        $resultado_animal = pg_fetch_assoc(pg_query($sql_consulta_animal));

        // Para as DEFICIÊNCIAS
    if(isset($str_deficiencias)) {
        // FAZ LOOP PELO ARRAY
        foreach ($str_deficiencias as $codigodeficiencia) {
            $sql_cadastro_animaldeficiencia = "INSERT INTO ANIMALDEFICIENCIA (ANIMALPORTADOR, PORTADEFICIENCIA) VALUES ({$resultado_animal["codanimal"]}, {$codigodeficiencia}); ";

            pg_query($sql_cadastro_animaldeficiencia);
        }
    }

        // Para as DOENÇAS
    if(isset($str_doencas)) {
        // FAZ LOOP PELO ARRAY
        foreach ($str_doencas as $codigodoenca) {
            $sql_cadastro_animaldoenca = "INSERT INTO ANIMALDOENCA (ANIMALPORTADOR, PORTADOENCA) VALUES ({$resultado_animal["codanimal"]}, {$codigodoenca}); ";

            pg_query($sql_cadastro_animaldoenca);
        }
    }

    pg_close($abrir_conexao);
?>