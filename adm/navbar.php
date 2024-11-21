
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
                <a class="nav-link" href="#">Cadastrar animal</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Cadastrar pessoa</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Website</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../index.php">Website</a>
              </li>
            </ul>
            <form class="d-flex mt-3" role="" method="get">
              <input class="form-control me-2" type="url" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </div>
    </nav>
  </header>