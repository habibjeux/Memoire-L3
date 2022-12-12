<?php 
    $bdd = new PDO("mysql:hostname=localhost;dbname=SuiviCours", "root", "");
    $reqAnnee = "SELECT * FROM annee ORDER BY annee DESC LIMIT 1";
    $stmtAnnee = $bdd->prepare($reqAnnee);
    $stmtAnnee->execute();
    $anneePre = $stmtAnnee->fetch()['annee'];
    $array = str_split($anneePre);
    $anneeSuiv = "";
    for ($i=0; $i < count($array); $i++) { 
        if($i == 3 || $i == 8)
            $anneeSuiv .= strval($array[$i] + 1);
        else        
            $anneeSuiv .= strval($array[$i]);

    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.min.js"></script>
    <title>Interface - Paramétrage</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/seance.css">
</head>
<body>
    <div class="col-lg-4 col-md-6 contenu">
        <form action="" method="POST" class="formSeance">
            <fieldset disabled="disabled">
                <div class="form-outline mb-4">
                    <label for="an-pre" class="form-label">Année en cours</label>
                    <input type="text" class="form-control" name ="an-pre" value="<?php echo $anneePre; ?>">
                </div>
            </fieldset>
            <div class="form-outline mb-4">
                <label for="an-suiv" class="form-label">Nouvelle année</label>
                <input type="text" class="form-control" name ="an-suiv" value="<?php echo $anneeSuiv; ?>">
            </div>
            <?php
    
                if(isset($_POST['submit'])) {
                    $newYear = $_POST['an-suiv'];

                    $reqAn = "INSERT INTO annee VALUES (?)";
                    $reqCal = "SELECT * FROM `calendrier` WHERE annee = ?";
                    $reqUA = "SELECT * FROM `ue-annee` WHERE annee = ?";
                    $reqMA = "SELECT * FROM `module-annee` WHERE annee = ?";
                    $reqEnseigner = "SELECT * FROM enseigner WHERE annee = ?";
                    $reqRA = "SELECT * FROM `resad-classe` WHERE annee = ?";
                    $reqRP = "SELECT * FROM `resped-classe` WHERE annee = ?";

                    $reqIRA = "INSERT INTO `resad-classe`(`NCE`, `idClasse`, `annee`, `role`) 
                    VALUES(?, ?, ?, ?)";
                    $reqIRP = "INSERT INTO `resped-classe`(`matricule`, `idClasse`, `annee`) 
                    VALUES(?, ?, ?)";
                    $reqICal = "INSERT INTO `calendrier`(idCalendrier, ddebut, dfin, annee, codeSem, idClasse) 
                    VALUES(?, ?, ?, ?, ?, ?)";
                    $reqIUA = "INSERT INTO `ue-annee`(codeUE, codeSem, idClasse, annee, credit)
                    VALUES(?, ?, ?, ?, ?)";
                    $reqIMA = "INSERT INTO `module-annee`(idModule, codeUE, annee, nbHeureModule)
                    VALUES(?, ?, ?, ?)";
                    $reqIEnseigner = "INSERT INTO `enseigner` (`matricule`, `idModule`, `idClasse`, `annee`, `examenFait`, `dateDebut`, `dateFin`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

                    $stmtAn = $bdd->prepare($reqAn);
                    $stmtAn->execute(array($newYear));
                    if($stmtAn) {
                        $resultRA = $bdd->prepare($reqRA);
                        $resultRA->execute(array($anneePre));
                        while ($row = $resultRA->fetch()) {
                            $stmtRA = $bdd->prepare($reqIRA);
                            $stmtRA->execute(array($row['NCE'], $row['idClasse'], $newYear, $row['role']));
                        }

                        $resultRP = $bdd->prepare($reqRP);
                        $resultRP->execute(array($anneePre));
                        while ($row = $resultRP->fetch()) {
                            $stmtRP = $bdd->prepare($reqIRP);
                            $stmtRP->execute(array($row['matricule'], $row['idClasse'], $newYear));
                        }


                        $resultCal = $bdd->prepare($reqCal);
                        $resultCal->execute(array($anneePre));
                        while ($row = $resultCal->fetch()) {
                            $stmtCal = $bdd->prepare($reqICal);
                            $stmtCal->execute(array(NULL, NULL, NULL, $newYear, $row['codeSem'], $row['idClasse']));
                        }

                        $resultUA = $bdd->prepare($reqUA);
                        $resultUA->execute(array($anneePre));
                        while ($row = $resultUA->fetch()) {
                            $stmtUA = $bdd->prepare($reqIUA);
                            $stmtUA->execute(array($row['codeUE'], $row['codeSem'], $row['idClasse'], $newYear, $row['credit']));
                        }

                        $resultMA = $bdd->prepare($reqMA);
                        $resultMA->execute(array($anneePre));
                        while ($row = $resultMA->fetch()) {
                            $stmtMA = $bdd->prepare($reqIMA);
                            $stmtMA->execute(array($row['idModule'], $row['codeUE'], $newYear, $row['nbHeureModule']));
                        }
                
                        $resultEn = $bdd->prepare($reqEnseigner);
                        $resultEn->execute(array($anneePre));
                        while ($row = $resultEn->fetch()) {
                            $stmtEn = $bdd->prepare($reqIEnseigner);
                            $stmtEn->execute(array($row['matricule'], $row['idModule'], $row['idClasse'], $newYear, '0', NULL, NULL));
                        }
                    }
                    
                }           
            ?>
            <div class="formButtons">
                <button  type="submit" class="btn btn-primary" name="submit">Valider</button>
            </div> 
        </form>
    </div>
</body>
</html>