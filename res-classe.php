<?php 
    session_start();
    $bdd = new PDO("mysql:hostname=localhost;dbname=SuiviCours", "root", "");
    $req = "SELECT E.matricule, E.prenom, E.nom, RC.idclasse FROM enseignant E, `resped-classe` RC WHERE E.matricule = RC.matricule AND annee = ?";
    $stmt = $bdd->prepare($req);
    $stmt->execute(array($_SESSION['annee']));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.min.js"></script>
    <title>Modif Res Classe</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="mb-4">
        <?php include_once("header.php"); ?>
    </header>
    <h1 class="text-light text-center pt-5">Liste des responsables de classe</h1>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr class="table-dark">
                    <th>Matricule</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Classe</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php while($row = $stmt->fetch()) : ?> 
            <tr>
                <td><?php echo $row['matricule']; ?></td>
                <td><?php echo $row['prenom']; ?></td>
                <td><?php echo $row['nom']; ?></td>
                <td><?php echo $row['idclasse']; ?></td>
                <td>
                    <a class="btn btn-light" href="modifierRes.php?classe=<?php echo $row['idclasse']?>">Modifier</a>
                </th>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>
</html>