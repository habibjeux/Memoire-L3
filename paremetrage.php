<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.min.js"></script>
    <title>Paramétrage</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/seance.css">
</head>
<body>
    <div class="col-lg-4 col-md-6 contenu">
        <form action="" method="POST" class="formSeance">
            <div class="form-outline mb-4">
            <select id="sem" name="sem" class="form-select" required onchange="getModule(this.value);">
                <option value="">Selectionnez un Semestre</option>
                <option value="1">Semestre 1</option>
                <option value="2">Semestre 2</option>
            </select>
            </div>
            <div class="form-outline mb-4">
                <select id="module" name="module" required class="form-select" onchange="getProf(this.value);">
                    <option value="">Choisissez un module</option>
                </select>
            </div>
            <div class="form-outline mb-4">
                <select id="prof" name="prof" required class="form-select">
                    <option value="">Choisissez un professeur</option>
                </select>
            </div>
            <div class="form-outline mb-2">
                <label for="date" class="form-label">Date de la Séance</label>
                <input type="date" class="form-control" name ="date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-outline mb-4">
                <label for="nbHeure" class="form-label">Nombre Heure</label>
                <input type="number" name="nbHeure" class="form-control" min="1" max="4" required>
            </div>
            <div class="formButtons">
                <button  type="submit" class="btn btn-primary" name="fait">Fait</button>
                <button type="submit" class="btn btn-danger" name="nonfait">Non Fait</button>
            </div> 
            <?php
    
                if(isset($_POST['fait'])) {
                    $reqT = "SELECT * FROM enseigner WHERE idModule = ? AND idClasse = ? AND annee = ? AND dateDebut IS NULL";
                    $result = $bdd->prepare($reqT);
                    $result->execute(array($_POST['module'], $idClasse, $annee));
                    if($result->rowCount() > 0) {
                        $req3 = "UPDATE enseigner SET dateDebut = ? WHERE idModule = ? AND idClasse = ? AND annee = ?";
                        $stmt3 = $bdd->prepare($req3);
                        $stmt3->execute(array($_POST['date'], $_POST['module'], $idClasse, $annee));
                    } 
                    $req = "INSERT INTO cours VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $bdd->prepare($req);
                    $stmt->execute(array(NULL, $_POST['date'], $_POST['nbHeure'], '1', $_POST['prof'], $_POST['module'], $idClasse, $annee));
                    if($stmt) 
                        echo "Insertion réussi";
                    else
                        "Erreur lors de l'insertion";
                }
                else if(isset($_POST['nonfait'])) {
                    $reqT = "SELECT * FROM enseigner WHERE idModule = ? AND idClasse = ? AND annee = ? AND dateDebut IS NULL";
                    $result = $bdd->prepare($reqT);
                    $result->execute(array($_POST['module'], $idClasse, $annee));
                    if($result->rowCount() > 0) {
                        $req3 = "UPDATE enseigner SET dateDebut = ? WHERE idModule = ? AND idClasse = ? AND annee = ?";
                        $stmt3 = $bdd->prepare($req3);
                        $stmt3->execute(array($_POST['date'], $_POST['module'], $idClasse, $annee));
                    } 
                    $req = "INSERT INTO cours VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $bdd->prepare($req);
                    $stmt->execute(array(NULL, $_POST['date'], $_POST['nbHeure'], '0', $_POST['prof'], $_POST['module'], $idClasse, $annee));
                    if($stmt) 
                        echo "Insertion réussi";
                    else
                        "Erreur lors de l'insertion";
                }
            ?>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        let form = document.getElementsByTagName("form")[0];

        form.addEventListener('submit', (e) => {
           
        });
        

        function getModule(val) {
            $.ajax({
                type: "POST",
                url: 'getModule.php',
                data : 'codeSem='+val,
                success : function(data) {
                    $("#module").html(data);
                }
            })
        }
        function getProf(val) {
            $.ajax({
                type: "POST",
                url: 'getProf.php',
                data : 'idModule='+val,
                success : function(data) {
                    $("#prof").html(data);
                }
            })
        }
    </script>


</body>
</html>