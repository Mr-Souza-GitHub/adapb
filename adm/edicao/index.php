
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include("../bootstrap-links.php"); ?>
  <link rel="stylesheet" href="../css/style.css">

  <title>
    Edição
  </title>
</head>

<body>

  <?php include("../navbar.php"); ?>

  <form action="query-edicao.php" method="POST" class="needs-validation row g-3 d-flex justify-content-center p-5">

    <!-- FORMULARIO DE EDICAO DE ANIMAIS -->
    <h1 class="h1 text-uppercase text-center">Editar animal</h1>

    <?php include("../conexao.php"); ?>
    <!-- CONSULTA DOS DADOS DO ANIMAL -->
    <?php

    include("../conexao.php");

    $consulta_url = $_GET["valor_codigo"];

    $select_codigo = "SELECT A.CODANIMAL, A.NOMEANIMAL, S.NOMESEXO, T.NOMETIPO, R.NOMERACA, V.ESTADOVACINACAO, A.DESCRICAOANIMAL
    FROM ANIMAL A, SEXO S, TIPO T, RACA R, VACINACAO V
    WHERE A.SEXOANIMAL = S.CODSEXO AND A.TIPOANIMAL = T.CODTIPO AND A.RACAANIMAL = R.CODRACA AND A.VACINACAOANIMAL = V.CODVACINACAO AND CODANIMAL = {$consulta_url};";

    // a consulta vai mostrar os dados no formulario

    if ($resposta = pg_query($select_codigo)) {
      # code...
      if ($dados_animal = pg_fetch_assoc($resposta)) {


    ?>
        <!-- Código -->
        <div class="col-md-2">
          <label for="codanimal" class="form-label fw-bold">Código</label>
          <input type="text" id="codanimal" name="codanimal" class="form-control" value="<?php echo $dados_animal["codanimal"]; ?>" readonly required>
        </div>

        <!-- Nome -->
        <div class="col-md-10">
          <label for="nomeanimal" class="form-label fw-bold">Nome do Animal</label>
          <input type="text" id="nomeanimal" name="nomeanimal" class="form-control" value="<?php echo $dados_animal["nomeanimal"]; ?>" required>
        </div>

        <!-- Sexo -->
        <div class="col-md-4">
          <p class="form-label fw-bold">Sexo</p>
          <select class="form-select" aria-label="Estado da Vacinação" id="sexoanimal" name="sexoanimal" required>

            <?php
            $sql_sexo = "SELECT * FROM SEXO";

            if ($consulta_sexo = pg_query($sql_sexo)) {
              while ($resposta_sexo = pg_fetch_assoc($consulta_sexo)) {
            ?>
                <option value="<?php echo $resposta_sexo["codsexo"]; ?>" id="<?php echo $resposta_sexo["nomesexo"]; ?>" <?php ($dados_animal["nomesexo"] == $resposta_sexo["nomesexo"]) ? print("selected") : print(""); ?>>
                  <?php echo $resposta_sexo["nomesexo"]; ?>
                </option>
            <?php
              }
            }
            ?>

          </select>
        </div>

        <!-- Tipo -->
        <div class="col-md-4">
          <p class="form-label fw-bold">Tipo</p>
          <select class="form-select" aria-label="Estado da Vacinação" id="tipoanimal" name="tipoanimal" required>

            <?php
            $sql_tipo = "SELECT * FROM TIPO";

            if ($consulta_tipo = pg_query($sql_tipo)) {
              while ($resposta_tipo = pg_fetch_assoc($consulta_tipo)) {
            ?>
                <option value="<?php echo $resposta_tipo["codtipo"]; ?>" id="<?php echo $resposta_tipo["nometipo"]; ?>" <?php ($dados_animal["nometipo"] == $resposta_tipo["nometipo"]) ? print("selected") : print(""); ?>>
                  <?php echo $resposta_tipo["nometipo"]; ?>
                </option>
            <?php
              }
            }
            ?>

          </select>
        </div>

        <!-- Raça -->
        <div class="col-md-4">
          <p class="form-label fw-bold">Raça</p>
          <select class="form-select" aria-label="Estado da Vacinação" id="racaanimal" name="racaanimal" required>

            <?php
            $sql_raca = "SELECT * FROM RACA";

            if ($consulta_raca = pg_query($sql_raca)) {
              while ($resposta_raca = pg_fetch_assoc($consulta_raca)) {
            ?>
                <option value="<?php echo $resposta_raca["codraca"]; ?>" id="<?php echo $resposta_raca["nomeraca"]; ?>" <?php ($dados_animal["nomeraca"] == $resposta_raca["nomeraca"]) ? print("selected") : print(""); ?>>
                  <?php echo $resposta_raca["nomeraca"]; ?>
                </option>
            <?php
              }
            }
            ?>

          </select>
        </div>

        <!-- Deficiência -->
        <div class="col-md-6">
          <p class="form-label fw-bold">Deficiências</p>
          <div class="form-check">
            <?php
            $sql_deficiencias = "SELECT * FROM DEFICIENCIA;";

            if ($consulta_deficiencias = pg_query($sql_deficiencias)) {
              while ($resposta_deficiencias = pg_fetch_assoc($consulta_deficiencias)) {
                // Verifica se os valores da tabela DEFICIENCIAANIMAL onde o código do animal portador é igual código do animal apresentado e se o código da deficiência que este porta é igual ao código da deficiência na tabela DEFICIENCIA

                //pegar dificiencias do animal
                $sql_deficienciaanimal = "SELECT array_agg(nomedeficiencia) as deficiencia from  (select * from animal as an 
          inner join ANIMALDEFICIENCIA as ad on an.codanimal = ad.ANIMALPORTADOR 
          inner join  DEFICIENCIA as d on ad.PORTADEFICIENCIA = d.CODDEFICIENCIA) as tabela where  codanimal = {$dados_animal["codanimal"]};";

                $deficienciasanimal = pg_fetch_assoc(pg_query($sql_deficienciaanimal));
            ?>
                <input class="form-check-input" name="deficienciasanimal[]" type="checkbox" value="<?php echo $resposta_deficiencias["coddeficiencia"]; ?>" id="<?php echo $resposta_deficiencias["nomedeficiencia"]; ?>" <?php str_contains($deficienciasanimal["deficiencia"], $resposta_deficiencias["nomedeficiencia"]) ?  print("checked") : print("") ?> >
                <label class="form-check-label" for="<?php echo $resposta_deficiencias["nomedeficiencia"]; ?>">
                  <?php echo $resposta_deficiencias["nomedeficiencia"]; ?>
                </label>
                <br>

            <?php
              }
            }
            ?>
          </div>

        </div>

        <!-- Doenças -->
        <div class="col-md-6">
          <p class="form-label fw-bold">Doenças</p>
          <div class="form-check">
            <?php
            $sql_doencas = "SELECT * FROM DOENCA;";

            if ($consulta_doencas = pg_query($sql_doencas)) {
              while ($resposta_doencas = pg_fetch_assoc($consulta_doencas)) {
                // Verifica se os valores da tabela DOENCAANIMAL onde o código do animal portador é igual código do animal apresentado e se o código da deficiência que este porta é igual ao código da deficiência na tabela DOENCA

                //pegar dificiencias do animal
                $sql_doencaanimal = "SELECT array_agg(nomedoenca) as doenca from  (select * from animal as an 
          inner join ANIMALDOENCA as ad on an.codanimal = ad.ANIMALPORTADOR 
          inner join  DOENCA as d on ad.PORTADOENCA = d.CODDOENCA) as tabela where  codanimal = {$dados_animal["codanimal"]};";

                $doencasanimal = pg_fetch_assoc(pg_query($sql_doencaanimal));
            ?>
                <input class="form-check-input" name="doencasanimal[]" type="checkbox" value="<?php echo $resposta_doencas["coddoenca"]; ?>" id="<?php echo $resposta_doencas["nomedoenca"]; ?>" <?php str_contains($doencasanimal["doenca"], $resposta_doencas["nomedoenca"]) ?  print("checked") : print("") ?> >
                <label class="form-check-label" for="<?php echo $resposta_doencas["nomedoenca"]; ?>">
                  <?php echo $resposta_doencas["nomedoenca"]; ?>
                </label>
                <br>

            <?php
              }
            }
            ?>
          </div>

        </div>

        <!-- Vacinação -->
        <div class="col-md-3">
          <label class="form-label fw-bold">Vacinação</label>
          <select class="form-select" aria-label="Estado da Vacinação" id="vacinacaoanimal" name="vacinacaoanimal" required>

            <?php
            $sql_vacinacao = "SELECT * FROM VACINACAO";

            if ($consulta_vacinacao = pg_query($sql_vacinacao)) {
              while ($resposta_vacinacao = pg_fetch_assoc($consulta_vacinacao)) {
            ?>
                <option value="<?php echo $resposta_vacinacao["codvacinacao"]; ?>" id="<?php echo $resposta_vacinacao["estadovacinacao"]; ?>" <?php ($dados_animal["estadovacinacao"] == $resposta_vacinacao["estadovacinacao"]) ? print("selected") : print(""); ?>>
                  <?php echo $resposta_vacinacao["estadovacinacao"]; ?>
                </option>
            <?php
              }
            }
            ?>

          </select>
        </div>

        <!-- Descrição -->
        <div class="col-md-9">
          <label for="descricaoanimal" class="form-label fw-bold">Descrição</label>
          <input type="text" id="descricaonanimal" name="descricaoanimal" class="form-control" style="height: min(10vh);" value="<?php echo $dados_animal["descricaoanimal"]; ?>" required>
        </div>

        <!-- Botões -->
        <div class="col-md-12 d-flex justify-content-between">
          <button type="reset" class="btn btn-outline-danger mx-auto">Limpar</button>
          <button type="submit" class="btn btn-primary mx-auto">Atualizar</button>
        </div>

    <?php
        // FINAL DA CONSULTA
      }
    }
    pg_close($abrir_conexao);
    ?>
  </form>
</body>

</html>