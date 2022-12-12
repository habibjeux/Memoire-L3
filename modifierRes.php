<?php 
    session_start();
    $bdd = new PDO("mysql:hostname=localhost;dbname=SuiviCours", "root", "");
    $reNow = "SELECT matricule FROM `resped-classe` WHERE idClasse = ? AND annee = ?";
    $result = $bdd->prepare($reNow);
    $result->execute(array($_GET['classe'], $_SESSION['annee']));
    $prof = $result->fetch()['matricule'];
    $req = "SELECT DISTINCT E.matricule, E.prenom, E.nom FROM enseignant E, enseigner EN WHERE E.matricule = EN.matricule AND EN.idClasse = ? AND EN.annee = ?";
    $stmt = $bdd->prepare($req);
    $stmt->execute(array($_GET['classe'], $_SESSION['annee']));
    if(!$prof)
        header("Location: res-classe.php");
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
        <form action="" method="POST" class="formSeance">
            <fieldset disabled="disabled">
                <div class="form-outline mb-2">
                    <label for="classe" class="form-label">Classe</label>
                    <input type="text" class="form-control" name ="classe" value="<?php echo $_GET['classe']; ?>">
                </div>
            </fieldset>
            <div class="form-outline mb-4">
                <select name="ens" required class="form-select">
                    <?php while($row = $stmt->fetch()) : ?>
                    <option <?php if($prof == $row['matricule']) echo "selected"; ?> value="<?php echo $row['matricule']; ?>"><?php echo $row['matricule'].'-'.$row['prenom'].' '.$row['nom']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button  type="submit" class="btn btn-primary" name="submit">Modifier</button>
            <?php
    
                if(isset($_POST['submit'])) {
                    $req2 = "UPDATE `resped-classe` SET matricule = ? WHERE matricule = ? AND idClasse = ? AND annee = ?";
                    $stmt2 = $bdd->prepare($req2);
                    $stmt2->execute(array($_POST['ens'], $prof, $_GET['classe'], $_SESSION['annee']));
                    if($stmt2) 
                        echo "Modification effectuée avec succès";
                    else
                        echo "Erreur lors de la modification";
                }
            ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>
</html>