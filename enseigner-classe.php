<?php
    session_start();
    $bdd = new PDO("mysql:hostname=localhost;dbname=SuiviCours", "root", "");
    $req = "SELECT idClasse, libelleClasse FROM classe WHERE idClasse = ?";
    $stmt = $bdd->prepare($req);
    $stmt->execute(array($_GET['idClasse']));
    $idClasse = $stmt->fetch();
    if(!$idClasse)
        header("Location: enseigner.php");

    $req2 = "SELECT EN.matricule, EN.prenom, EN.nom, M.idModule, M.libelleModule, E.examenFait, E.dateDebut, E.dateFin FROM `enseigner` E, enseignant EN, Module M WHERE E.matricule = EN.matricule AND M.idModule = E.idModule AND E.idClasse = ? AND E.annee = ?";
    $stmt2 = $bdd->prepare($req2);
    $stmt2->execute(array($_GET['idClasse'], $_SESSION['annee']));

    $req3 = "SELECT matricule, prenom, nom FROM enseignant";
    $stmt3 = $bdd->prepare($req3);

    $req5 = "";
    $stmt5 = $bdd->prepare($req5);
    $stmt5->execute();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enseignant Classe</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
</head>
<body>
    <header class="mb-4">
        <?php include_once("header.php"); ?>
    </header>
    <h1 class="text-light text-center pt-5">Matières enseignés : <?php echo $idClasse['libelleClasse']; ?></h1>
    <div class="container">
        <button class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter</button>
        <div class="row justify-content-center">
            <table class="table table-hover">
            <thead>
                <tr class="table-dark">
                    <th>Professeur</th>
                    <th>Nom Module</th>
                    <th>examenFait</th>
                    <th>dateDebut</th>
                    <th>dateFin</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php while($row = $stmt2->fetch()) : ?> 
                <tr>
                    <td><?php echo $row['matricule'].'-'.$row['prenom'].' '.$row['nom']; ?></td>
                    <td><?php echo $row['libelleModule']; ?></td>
                    <td><?php if($row['examenFait']) echo "Oui"; else echo "Non"; ?></td>
                    <td><?php if(!$row['dateDebut']) echo "Pas encore"; else echo $row['dateDebut']; ?></td>
                    <td><?php if(!$row['dateFin']) echo "Pas encore"; else echo $row['dateFin']; ?></td>

                    <td>
                    <button class="btn btn-light editbtn" data-bs-toggle="modal" data-bs-target="#modifierModal<?php echo $row['matricule'].''.$row['idModule']; ?>">Modifier</button>
                    </td>
                </tr>
                <!-- Modifer Modal -->
                <div class="modal fade" id="modifierModal<?php echo $row['matricule'].''.$row['idModule']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Formulaire modification UE</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="">
                                <fieldset disabled="disabled">
                                    <div class="mb-3">
                                        <label for="libelleModuleM">Libellé Module</label>
                                        <input value="<?php echo $row['libelleModule']; ?>" type="text" class="form-control" name="libelleModuleM">
                                        <div class="form-text"></div>
                                    </div>
                                </fieldset>
                                <input value="<?php echo $row['idModule']; ?>" type="hidden" name="idModuleH">
                                <input value="<?php echo $row['matricule']; ?>" type="hidden" name="matriculeH">
                                <div class="mb-3">
                                    <label for="matriculeM" class="form-label">Professeur</label>
                                    <select name="matriculeM" class="form-select">
                                        <?php  $stmt3->execute(); ?>
                                        <?php while($row2 = $stmt3->fetch()) : ?>
                                            <option <?php if($row['matricule'] == $row2['matricule']) echo "selected"; ?> value="<?php echo $row2['matricule']; ?>"><?php echo $row2['matricule'].'-'.$row2['prenom'].' '.$row2['nom']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="examenFaitM" class="form-label">Examen Fait ?</label>
                                    <select name="examenFaitM" class="form-select">
                                        <option <?php if($row['examenFait']) echo "selected"; ?> value="1">Oui</option>
                                        <option <?php if(!$row['examenFait']) echo "selected"; ?> value="0">Non</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dateDebutM" class="form-label">Date Début</label>
                                    <input value="<?php echo $row['dateDebut']; ?>" type="date" class="form-control" name="dateDebutM">
                                    <div class="form-text"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="dateFinM" class="form-label">Date Fin</label>
                                    <input value="<?php echo $row['dateFin']; ?>" type="date" class="form-control" name="dateFinM">
                                    <div class="form-text"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" name="submitMod" class="btn btn-primary">Modifier</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </table>
        </div>
    </div>

    <!-- Modifer Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulaire modification UE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <fieldset disabled="disabled">
                        <div class="mb-3">
                            <label for="idClasse">Classe</label>
                            <input value="<?php echo $_GET['idClasse']; ?>" type="text" class="form-control" name="libelleModuleM">
                            <div class="form-text"></div>
                        </div>
                    </fieldset>
                    <div class="mb-3">
                        <label for="matricule" class="form-label">Professeur</label>
                        <select name="matricule" class="form-select">
                            <?php  $stmt3->execute(); ?>
                            <?php while($row2 = $stmt3->fetch()) : ?>
                                <option value="<?php echo $row2['matricule']; ?>"><?php echo $row2['matricule'].'-'.$row2['prenom'].' '.$row2['nom']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submitMod'])) {
            $matriculeM = $_POST['matriculeM'];
            $matriculeH = $_POST['matriculeH'];
            $idModuleM = $_POST['idModuleH'];
            $examenFaitM = $_POST['examenFaitM'];
            $dateDebutM = $_POST['dateDebutM'];
            $dateFinM = $_POST['dateFinM'];

            if(!$dateDebutM) $dateDebutM = NULL;
            if(!$dateFinM) $dateFinM = NULL;

            $req4 = "UPDATE enseigner SET matricule = ?, examenFait = ?, dateDebut = ?, dateFin = ? WHERE matricule = ? AND idModule = ? AND idClasse = ? AND annee = ?";
            $stmt4 = $bdd->prepare($req4);
            $stmt4->execute(array($matriculeM, $examenFaitM, $dateDebutM, $dateFinM, $matriculeH, $idModuleM, $_GET['idClasse'], $_SESSION['annee']));
             
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>
</html>