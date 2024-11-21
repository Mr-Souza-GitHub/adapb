<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links -->

  <!-- Fontes -->
  <!-- Google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/bootstrap/bootstrap.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

  <!-- CSS Proprio -->
  <link rel="stylesheet" href="css/style.css">


  <title>Adoção</title>
</head>

<body>
  <style>
    body {
      background: url('../assets/img/bg-new.png') repeat-y;
      background-size: auto;
      height: fit-content;
    }
  </style>
  <!-- NAVBAR -->
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <!-- Logo da navbar -->
        <a href="../index.html" class="back-btn mx-4"><img src="../assets/icons/arrow-left.svg" class="bi bi-arrow-left" width="40" height="auto" /></a>
        <a class="navbar-brand" href="#"><img src="../assets/icons/logo.svg" alt="" width="180" height="60"></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Botoes -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Como Ajudar?</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contato">Contato</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Adoção</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="container-fluid">
    <div class="d-flex align-items-center justify-content-center flex-column">
        <!-- INICIO DO PHP -->
      <?php
      include("../adm/conexao.php");

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
      <div class="card my-3 rounded-3 p-3 w-75" id="<?php echo $dados_consulta["codanimal"]; //Id para pesquisa ?>">
        <div class="row g-0">
          <!-- Imagem -->
          <div class="col-md-4 shadow">
            <div class="ratio ratio-1x1">
              <!-- INSERIR LINKS DE IMAGEM -->
              <img src="../assets/img/animais/dog1.jpeg" class="card-img-top" alt="">
            </div>
          </div>
  
          <!-- Textos -->
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title text-justify">
                <?php echo $dados_consulta["nomeanimal"]; // Nome ?>
              </h5>
              <p class="card-text"><?php echo $dados_consulta["descricaoanimal"]; ?></p>
            </div>
            <ul class="list-group list-group-flush">
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
              <!-- indicação de status de adoção -->
            </div>
          </div>
        </div>
      </div>

      <?php
          // FECHA OS LAÇOS E A CONEXÃO
        }
      }

      pg_close($abrir_conexao);
      ?>
    </div>
  </section>
</body>

</html>