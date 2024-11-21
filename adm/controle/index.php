<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- LINKS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../css/bootstrap.css">
  <script src="../js/bootstrap.js" defer></script>
  <link rel="stylesheet" href="../css/style.css">

  <title>Controle</title>
</head>

<body>
  <!-- NAVBAR -->
  <header class="p-3">
    <nav class="navbar bg-body-tertiary fixed-top p-3">
      <div class="container-fluid">
        <a class="navbar-brand" href="http://localhost/adapb/adm">Administração</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Páginas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Animais</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pessoas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Funcionários</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Website</a>
              </li>
            </ul>
            <form class="d-flex mt-3" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <form action="query.php" method="post" class="row g-3 d-flex justify-content-center p-5">
    <!-- CONSULTA DOS DADOS -->
    <?php

    include("../conexao.php");

    $consulta_url = $_GET["valor_codigo"];

    $select_codigo = "SELECT A.CODANIMAL, A.NOMEANIMAL, S.NOMESEXO, R.NOMERACA, V.ESTADOVACINACAO, A.DESCRICAOANIMAL
      FROM ANIMAL A, SEXO S, RACA R, VACINACAO V
      WHERE A.SEXOANIMAL = S.CODSEXO AND A.RACAANIMAL = R.CODRACA AND A.VACINACAOANIMAL = V.CODVACINACAO AND CODANIMAL = {$consulta_url};";

    // a consulta vai mostrar os dados no formulario

    if ($resposta = pg_query($select_codigo)) {
      # code...
      if ($dados_animal = pg_fetch_assoc($resposta)) {
            

    ?>

        <!-- FORMULARIO COM OS DADOS DO ANIMAL -->
        <!-- Código -->
        <div class="col-md-2">
          <label for="codanimal" class="form-label fw-bold">Código</label>
          <input type="text" id="codanimal" class="form-control" value="<?php echo $dados_animal["codanimal"]; ?>" disabled readonly>
        </div>

        <!-- Nome -->
        <div class="col-md-7">
          <label for="nomeanimal" class="form-label fw-bold">Nome do Animal</label>
          <input type="text" id="nomeanimal" class="form-control" value="<?php echo $dados_animal["nomeanimal"]; ?>" disabled readonly>
        </div>

        <!-- Sexo -->
        <div class="col-md-4">
          <label for="sexoanimal" class="form-label fw-bold">Sexo</label>
          <input type="text" id="sexoanimL" class="form-control" value="<?php echo $dados_animal["nomesexo"]; ?>" disabled readonly>
        </div>

        <!-- Raça -->
        <div class="col-md-6">
          <label for="racaanimal" class="form-label fw-bold">Raça</label>
          <input type="text" id="racaanimal" class="form-control" value="<?php echo $dados_animal["nomeraca"]; ?>" disabled readonly>
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
                  <input class="form-check-input" type="checkbox" value="<?php echo $resposta_deficiencias["coddeficiencia"]; ?>" id="<?php echo $resposta_deficiencias["nomedeficiencia"]; ?>" 
                   <?php str_contains($deficienciasanimal["deficiencia"], $resposta_deficiencias["nomedeficiencia"]) ?  print("checked") : print("") ?>  disabled readonly>
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
                  <input class="form-check-input" type="checkbox" value="<?php echo $resposta_doencas["coddoenca"]; ?>" id="<?php echo $resposta_doencas["nomedoenca"]; ?>" 
                   <?php str_contains($doencasanimal["doenca"], $resposta_doencas["nomedoenca"]) ?  print("checked") : print("") ?>  disabled readonly>
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
          <p class="form-label fw-bold">Vacinação</p>
          <select class="form-select" aria-label="Estado da Vacinação" id="select-vacinacao" disabled readonly>

            <?php
            $sql_vacinacao = "SELECT * FROM VACINACAO";

            if ($consulta_vacinacao = pg_query($sql_vacinacao)) {
              while ($resposta_vacinacao = pg_fetch_assoc($consulta_vacinacao)) {
            ?>

                  <option value="<?php echo $resposta_vacinacao["codvacinacao"]; ?>" id="<?php echo $resposta_vacinacao["estadovacinacao"]; ?>" 
                  <?php ($dados_animal["estadovacinacao"] == $resposta_vacinacao["estadovacinacao"]) ? print("selected") : print(""); ?> >
                    <?php echo $resposta_vacinacao["estadovacinacao"]; ?>
                  </option>

            <?php
              }
            }
            ?>

          </select>
        </div>
        
      <!-- FINAL DA CONSULTA -->
    <?php
      } else {
        echo ("ERRO");
        pg_close($abrir_conexao);
      }
    }
    ?>
  </form>
</body>

</html>