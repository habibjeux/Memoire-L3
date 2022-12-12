<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="modif-param-year.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="res-classe.php">Responsable</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ue.php">UE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="module.php">Module</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="enseigner.php">Enseigner</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"><?php echo $_SESSION['annee']; ?></a>
        </li>
      </ul>
    </div>
  </div>
</nav>