<?php 
    session_start();
    $bdd = new PDO("mysql:hostname=localhost;dbname=SuiviCours", "root", "");
    $req = "SELECT UE.codeUE, UE.nomUE, UA.codeSem, UA.credit FROM `ue-annee` UA, UE WHERE UA.codeUE = UE.codeUE AND annee = ?";
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
    <title>Modif UE</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="mb-4">
        <?php include_once("header.php"); ?>
    </header>
    <h1 class="text-light text-center pt-5">Liste des UE</h1>
    <div class="container">
    <button class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter</button>
        <table class="table table-hover">
            <thead>
                <tr class="table-dark">
                    <th>codeUE</th>
                    <th>Nom UE</th>
                    <th>Semestre</th>
                    <th>Crédit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php while($row = $stmt->fetch()) : ?> 
            <tr>
                <td><?php echo $row['codeUE']; ?></td>
                <td><?php echo $row['nomUE']; ?></td>
                <td><?php echo $row['codeSem']; ?></td>
                <td><?php echo $row['credit']; ?></td>
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
                        <label for="codeUE">code UE</label>
                        <input type="text" class="form-control" name="codeUE">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nomUE" class="form-label">Nom UE</label>
                        <input type="text" class="form-control" name="nomUE">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="codeSem" class="form-label">Semestre</label>
                        <select name="codeSem" class="form-select">
                            <option value="1">Semestre 1</option>
                            <option value="2">Semestre 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="credit" class="form-label">Crédit</label>
                        <input type="number" min="1" max="30" class="form-control" name="credit">
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
                <h5 class="modal-title" id="exampleModalLabel">Formulaire modification UE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <fieldset disabled="disabled">
                        <div class="mb-3">
                            <label for="codeUEM">code UE</label>
                            <input id="codeUEM" type="text" class="form-control" name="codeUEM">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="nomUEM" class="form-label">Nom UE</label>
                            <input id="nomUEM" type="text" class="form-control" name="nomUEM">
                            <div class="form-text"></div>
                        </div>
                    </fieldset>
                    <input type="hidden" id="codeUEH" name="codeUEH">
                    <div class="mb-3">
                        <label for="codeSemM" class="form-label">Semestre</label>
                        <select id="codeSemM" name="codeSemM" class="form-select">
                            <option value="1">Semestre 1</option>
                            <option value="2">Semestre 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="creditM" class="form-label">Crédit</label>
                        <input id="creditM" type="number" min="1" max="30" class="form-control" name="creditM">
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


    <?php
        if(isset($_POST['submitAdd'])) {
            $codeUE = $_POST['codeUE'];
            $nomUE = $_POST['nomUE'];
            $codeSem = $_POST['codeSem'];
            $credit = $_POST['credit'];
            
            $req2 = "INSERT INTO UE(codeUE, nomUE) VALUES (?, ?)";
            $stmt2 = $bdd->prepare($req2);
            $stmt2->execute(array($codeUE, $nomUE));
            if($stmt2) {
                $req3 = "INSERT INTO `ue-annee`(codeUE, codeSem, annee, credit) VALUES (?, ?, ?, ?)";
                $stmt3 = $bdd->prepare($req3);
                $stmt3->execute(array($codeUE, $codeSem, $_SESSION['annee'], $credit));
                if($stmt3) :
            ?>
            <script>
                window.location.href="ue.php";
            </script>
            <?php
                endif;
            }
        }

    if(isset($_POST['submitMod'])) {
        $codeUEM = $_POST['codeUEH'];
        $codeSemM = $_POST['codeSemM'];
        $creditM = $_POST['creditM'];
        
        $req4 = "UPDATE `ue-annee` SET codeSem = ?, credit = ? WHERE codeUE = ? AND annee = ?";
        $stmt4 = $bdd->prepare($req4);
        $stmt4->execute(array($codeSemM, $creditM, $codeUEM, $_SESSION['annee']));
        if($stmt4) :
        ?>
        <script>
            window.location.href="ue.php";
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

                $('#codeUEM').val(data[0]);
                $('#codeUEH').val(data[0]);
                $('#nomUEM').val(data[1]);
                $('#codeSemM').val(data[2]);
                $('#creditM').val(data[3]);
            });
        });
    </script>
</body>
</html>