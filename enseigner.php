<?php 
    session_start();
    $bdd = new PDO("mysql:hostname=localhost;dbname=SuiviCours", "root", "");
    $req = "SELECT idClasse, libelleClasse FROM classe";
    $stmt = $bdd->prepare($req);
    $stmt->execute();
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modif UE</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
</head>
<body>
    <header class="mb-4">
        <?php include_once("header.php"); ?>
    </header>
    <h1 class="text-light text-center pt-5">Choisissez une classe</h1>
    <div class="container">
        <div class="row justify-content-center">
            <?php while($row = $stmt->fetch()) : ?>
                <a class="btn btn-dark col-4 m-2" href="enseigner-classe.php?idClasse=<?php echo $row['idClasse']; ?>"><?php echo $row['libelleClasse']; ?></a>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>