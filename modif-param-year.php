<?php 
    $bdd = new PDO("mysql:hostname=localhost;dbname=SuiviCours", "root", "");
    $req = "SELECT * FROM annee ORDER BY annee DESC";
    $stmt = $bdd->prepare($req);
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.min.js"></script>
    <title>Paramétrage</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1 class="text-light text-center">Choisissez une année</h1>
    <div class="container">
        <div class="row justify-content-center">
        <?php while($row = $stmt->fetch()) : ?>
        <form class="col-4" action="modif-param.php" method="POST">
                <input type="hidden" name="annee"  value="<?php echo $row['annee'] ?>">
                <button class="btn btn-dark w-100" type="submit" name="submit"><?php echo $row['annee'] ?></button>
        </form>
        <?php endwhile; ?>
       </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>
</html>