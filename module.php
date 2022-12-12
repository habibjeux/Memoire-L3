<?php 
    session_start();
    $bdd = new PDO("mysql:hostname=localhost;dbname=SuiviCours", "root", "");
    $req = "SELECT M.idModule, M.libelleModule, MA.codeUE, MA.nbHeureModule FROM `module-annee` MA, module M WHERE MA.idModule = M.idModule AND MA.annee = ?";
    $stmt = $bdd->prepare($req);
    $stmt->execute(array($_SESSION['annee']));

    $req0 = "SELECT UE.codeUE, UE.nomUE FROM `ue-annee` UA, UE WHERE UA.codeUE = UE.codeUE AND annee = ?";
    $stmt0 = $bdd->prepare($req0);
    $stmt0->execute(array($_SESSION['annee']));

    $stmt1 = $bdd->prepare($req0);
    $stmt1->execute(array($_SESSION['annee']));
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
    <h1 class="text-light text-center pt-5">Liste des modules</h1>
    <div class="container">
    <button class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter</button>
        <table class="table table-hover">
            <thead>
                <tr class="table-dark">
                    <th>idModule</th>
                    <th>Libelle Module</th>
                    <th>CodeUE</th>
                    <th>Nombre Heure Module</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php while($row = $stmt->fetch()) : ?> 
            <tr>
                <td><?php echo $row['idModule']; ?></td>
                <td><?php echo $row['libelleModule']; ?></td>
                <td><?php echo $row['codeUE']; ?></td>
                <td><?php echo $row['nbHeureModule']; ?></td>
                <td>
                <button class="btn btn-light editbtn" data-bs-toggle="modal" data-bs-target="#modifierModal">Modifier</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>


    <!-- Aouter Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulaire d'ajout UE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="idModule" class="form-label">idModule</label>
                        <input type="text" class="form-control" name="idModule">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="libelleModule" class="form-label">Libelle Module</label>
                        <input type="text" class="form-control" name="libelleModule">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="codeUE" class="form-label">Nom UE</label>
                        <select id="codeUE" name="codeUE" class="form-select">
                            <?php while($row = $stmt1->fetch()) : ?>
                                <option value="<?php echo $row['codeUE']; ?>"><?php echo $row['nomUE']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nbHeureModule" class="form-label">Nombre Heure Module</label>
                        <input type="number" min="1" max="100" class="form-control" name="nbHeureModule">
                        <div class="form-text"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="submitAdd" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    
    <!-- Modifer Modal -->
    <div class="modal fade" id="modifierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulaire modification Module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <fieldset disabled="disabled">
                        <div class="mb-3">
                            <label for="idModuleM">idModule</label>
                            <input id="idModuleM" type="text" class="form-control" name="idModuleM">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="libelleModuleM" class="form-label">Libelle Module</label>
                            <input id="libelleModuleM" type="text" class="form-control" name="libelleModuleM">
                            <div class="form-text"></div>
                        </div>
                    </fieldset>
                    <input id="idModuleH" type="hidden" name="idModuleH">
                    <input type="hidden" id="libelleModuleH" name="libelleModuleH">
                    <div class="mb-3">
                        <label for="codeUEM" class="form-label">Nom UE</label>
                        <select id="codeUEM" name="codeUEM" class="form-select">
                            <?php while($row = $stmt0->fetch()) : ?>
                                <option value="<?php echo $row['codeUE']; ?>"><?php echo $row['nomUE']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nbHeureModuleM" class="form-label">Nombre Heure Module</label>
                        <input id="nbHeureModuleM" type="number" min="1" max="100" class="form-control" name="nbHeureModuleM">
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

<div class="modal fade" id="succesModal" tabindex="-1">
    <div class="modal-dialog row">
        <div class="modal-content col-4 pb-4">
            <div class="modal-body">
                <h5 class="modal-title text-center">Success</h5>
                <p class="text-center"><i class="bi bi-check-circle-fill text-success"></i></p>
                <p class="text-center">Modification effectuée avec succes.</p>
            </div>
            <button type="button ml-3 mr-4" class="btn btn-success" data-bs-dismiss="modal">OK</button>
        </div>
    </div>
</div>


    <?php
        if(isset($_POST['submitAdd'])) {
            $idModule = $_POST['idModule'];
            $libelleModule = $_POST['libelleModule'];
            $codeUE = $_POST['codeUE'];
            $nbHeureModule = $_POST['nbHeureModule'];
            
            $req2 = "INSERT INTO Module(idModule, libelleModule) VALUES (?, ?)";
            $stmt2 = $bdd->prepare($req2);
            $stmt2->execute(array($idModule, $libelleModule));
            if($stmt2) {
                $req3 = "INSERT INTO `module-annee`(idModule, codeUE, annee, nbHeureModule) VALUES (?, ?, ?, ?)";
                $stmt3 = $bdd->prepare($req3);
                $stmt3->execute(array($idModule, $codeUE, $_SESSION['annee'], $nbHeureModule));
                if($stmt3) :
            ?>
            <script>
                window.location.href="module.php";
            </script>
            <?php
                endif;
            }
        }
        if(isset($_POST['submitMod'])) {

            $idModuleM = $_POST['idModuleH'];
            $libelleModuleM = $_POST['libelleModuleH'];
            $codeUEM = $_POST['codeUEM'];
            $nbHeureModuleM = $_POST['nbHeureModuleM'];
    
            $req4 = "UPDATE `module-annee` SET codeUE = ?, nbHeureModule = ? WHERE idModule = ? AND annee = ?";
            $stmt4 = $bdd->prepare($req4);
            $stmt4->execute(array($codeUEM, $nbHeureModuleM, $idModuleM, $_SESSION['annee']));
            if($stmt4) :
            ?>
            <script>
                window.location.href="module.php";
            </script>
            <?php
                endif;
           
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="js/jquery.js"></script>
    <script>
        $(document).ready(function () {
            $('.editbtn').on('click', function () {
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                $('#idModuleM').val(data[0]);
                $('#idModuleH').val(data[0]);
                $('#libelleModuleM').val(data[1]);
                $('#libelleModuleH').val(data[1]);
                $('#codeUEM').val(data[2]);
                $('#nbHeureModuleM').val(data[3]);
            });
        });

        // $(document).ready(function() {
        //     $('#succesModal').modal('show');
        // });
    </script>
</body>
</html>