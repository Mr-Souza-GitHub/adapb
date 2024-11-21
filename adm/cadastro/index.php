<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include("../bootstrap-links.php"); ?>
  <link rel="stylesheet" href="../css/style.css">

  <title>Controle</title>
</head>

<body>

  <? include("../navbar.php"); ?>

  <form action="query-cadastro.php" method="POST" class="needs-validation row g-3 d-flex justify-content-center p-5">

    <!-- FORMULARIO DE CADASTRO DE ANIMAIS -->
    <h1 class="h1 text-uppercase text-center">Cadastrar animal</h1>

    <?php include("../conexao.php"); ?>

    <!-- Nome -->
    <div class="col-md-12">
      <label for="nomeanimal" class="form-label fw-bold">Nome do Animal</label>
      <input type="text" id="nomeanimal" name="nomeanimal" class="form-control" value="" required>
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
            <option value="<?php echo $resposta_sexo["codsexo"]; ?>" id="<?php echo $resposta_sexo["nomesexo"]; ?>">
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
            <option value="<?php echo $resposta_tipo["codtipo"]; ?>" id="<?php echo $resposta_tipo["nometipo"]; ?>">
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
            <option value="<?php echo $resposta_raca["codraca"]; ?>" id="<?php echo $resposta_raca["nomeraca"]; ?>">
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
      <div class="form-check" id="deficienciasanimal">
        <?php
        $sql_deficiencias = "SELECT * FROM DEFICIENCIA;";

        if ($consulta_deficiencias = pg_query($sql_deficiencias)) {
          while ($resposta_deficiencias = pg_fetch_assoc($consulta_deficiencias)) {
        ?>
            <input class="form-check-input" type="checkbox" value="<?php echo $resposta_deficiencias["coddeficiencia"]; ?>" id="<?php echo $resposta_deficiencias["nomedeficiencia"]; ?>" name="deficienciasanimal[]">
            <label class="form-check-label" for="deficienciasanimal[]">
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
      <div class="form-check" id="doencasanimal">
        <?php
        $sql_doencas = "SELECT * FROM DOENCA;";

        if ($consulta_doencas = pg_query($sql_doencas)) {
          while ($resposta_doencas = pg_fetch_assoc($consulta_doencas)) {
        ?>
            <input class="form-check-input" type="checkbox" value="<?php echo $resposta_doencas["coddoenca"]; ?>" id="<?php echo $resposta_doencas["nomedoenca"]; ?>" name="doencasanimal[]">
            <label class="form-check-label" for="doencasanimal[]">
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
      <p class="form-label fw-bold">Vacinação</p>
      <select class="form-select" aria-label="Estado da Vacinação" id="vacinacaoanimal" name="vacinacaoanimal" required>

        <?php
        $sql_vacinacao = "SELECT * FROM VACINACAO";

        if ($consulta_vacinacao = pg_query($sql_vacinacao)) {
          while ($resposta_vacinacao = pg_fetch_assoc($consulta_vacinacao)) {
        ?>
            <option value="<?php echo $resposta_vacinacao["codvacinacao"]; ?>" id="<?php echo $resposta_vacinacao["estadovacinacao"]; ?>">
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
      <p class="form-label fw-bold">Descrição</p>
      <div class="form-floating">
        <textarea class="form-control" placeholder="Escreva uma breve descrição" id="descricaoanimal" name="descricaoanimal" style="height: 25%" required></textarea>
        <label for="descricaoanimal">Descrição</label>
      </div>
    </div>

    <div class="col-md-12 d-flex justify-content-between">
      <button type="reset" class="btn btn-outline-danger mx-auto">Limpar</button>
      <button type="submit" class="btn btn-primary mx-auto">Cadastrar</button>
    </div>

    <?php
    pg_close($abrir_conexao);
    ?>
  </form>
</body>

</html>