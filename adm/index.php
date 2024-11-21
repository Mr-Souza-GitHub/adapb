<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- LINKS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../css/bootstrap.css">
  <script src="../js/bootstrap.js" defer></script>
  <link rel="stylesheet" href="../css/style.css">

  <title>Página Administrativa</title>
</head>

<body>
  <!-- NAVBAR -->
  <header class="p-3">
    <nav class="navbar bg-body-tertiary fixed-top p-3">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Administração</a>
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

  <!-- CONTAINER PRINCIPAL -->
  <div class="container-fluid min-vh-100 d-flex flex-wrap justify-content-around p-5">

    

    <!-- INICIO DO PHP -->
    <?php
    include("conexao.php");

    $sql_select = "SELECT A.CODANIMAL, A.NOMEANIMAL, S.NOMESEXO, R.NOMERACA, V.ESTADOVACINACAO, A.DESCRICAOANIMAL
        FROM ANIMAL A, SEXO S, RACA R, VACINACAO V
        WHERE A.SEXOANIMAL = S.CODSEXO AND A.RACAANIMAL = R.CODRACA AND A.VACINACAOANIMAL = V.CODVACINACAO ORDER BY A.CODANIMAL;
          ";
    // EXECUTA A CONSULTA
    if ($consulta = pg_query($abrir_conexao, $sql_select)) {
      while ($dados_consulta = pg_fetch_assoc($consulta)) {
    ?>
        <!-- ESTRUTURA DE INSERÇÃO DOS DADOS NA TABELA -->

        <!-- CARDS LISTANDO ANIMAIS -->
    <div class="card my-3 rounded-3" style="width: 18rem;" id="<?php echo $dados_consulta["nomeanimal"]; //Id para pesquisa ?>">
    <div class="ratio ratio-1x1">
      <!-- INSERIR LINKS DE IMAGEM -->
      <img src="../assets/img/animais/dog1.jpeg" class="card-img-top" alt="">
    </div>
      <div class="card-body">
        <h5 class="card-title text-justify">
          <?php echo $dados_consulta["nomeanimal"]; // Nome ?>
          <a href="controle/index.php?valor_codigo=<?php echo $dados_consulta["codanimal"]; // Btn Visualizar ?>" class="border-0" id="btn-visualizar ms-2"><img src="../assets/icons/eye.svg" alt="Visualizar"></a>
        </h5>
        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Código: <?php echo $dados_consulta["codanimal"]; // Código 
                                            ?></li>
        <li class="list-group-item">Sexo: <?php echo $dados_consulta["nomesexo"]; // Sexo 
                                          ?></li>
        <li class="list-group-item">Raça: <?php echo $dados_consulta["nomeraca"]; // Raça 
                                          ?></li>
        <li class="list-group-item">Deficiências:
          <?php // Deficiencias
          // SQL da consulta
          $sql_animaldeficiencia = "SELECT * FROM ANIMALDEFICIENCIA, DEFICIENCIA WHERE ANIMALPORTADOR = {$dados_consulta["codanimal"]}";

          if ($consulta_animaldeficiencia = pg_query($sql_animaldeficiencia)) {
            while ($resposta_animaldeficiencia = pg_fetch_assoc($consulta_animaldeficiencia)) {
              // Verifica se são iguais e imprime apenas as deficiencias do animal

              if ($resposta_animaldeficiencia["portadeficiencia"] == $resposta_animaldeficiencia["coddeficiencia"]) {
          ?>
                <?php echo $resposta_animaldeficiencia["nomedeficiencia"]; ?> <br>
          <?php
              }
            }
          }
          ?>
        </li>
        <li class="list-group-item">Doenças:
          <?php
          // SQL da consulta
          $sql_animaldoenca = "SELECT * FROM ANIMALDOENCA, DOENCA WHERE ANIMALPORTADOR = {$dados_consulta["codanimal"]}";

          if ($consulta_animaldoenca = pg_query($sql_animaldoenca)) {
            while ($resposta_animaldoenca = pg_fetch_assoc($consulta_animaldoenca)) {
              // Verifica se são iguais e imprime apenas as doencas do animal

              if ($resposta_animaldoenca["portadoenca"] == $resposta_animaldoenca["coddoenca"]) {
          ?>
                <?php echo $resposta_animaldoenca["nomedoenca"]; ?> <br>
          <?php
              }
            }
          }
          ?>
        </li>
        <li class="list-group-item">Vacinação: <?php echo $dados_consulta["estadovacinacao"]; ?></li>
      </ul>
      <div class="card-body">
        <a href="edicao/index.php?valor_codigo=<?php echo $dados_consulta["codanimal"]; // Btn Editar ?>" class="btn btn-outline-secondary"><img src="../assets/icons/pencil.svg" alt="Editar"></a>
        <a href="edicao/index.php?valor_codigo=<?php echo $dados_consulta["codanimal"]; // Btn Apagar ?>" class="btn btn-outline-danger"><img src="../assets/icons/trash.svg" alt="Apagar"></a>
      </div>
    </div>

    <?php
        // FECHA OS LAÇOS E A CONEXÃO
      }
    }

    pg_close($abrir_conexao);
    ?>
  </div>
</body>

</html>