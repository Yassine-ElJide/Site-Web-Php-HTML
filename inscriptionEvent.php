<?php
session_start();
session_regenerate_id();
include_once('isConnected.php');
include_once('header.php');
include_once('db.php');
?>

<?php
if (!empty($_POST['inscription_btn'])) : ?>
    <?php if (!empty($_POST['dateinscription'])) :
        $numevenement = $_POST['btn_id'];
        $login = $_SESSION['login'];
        $dateinscription = $_POST['dateinscription'];
        $requete = $db->query("SELECT datedebut, datefin FROM evenement WHERE numevenement = {$numevenement}");
        $dateEvenementActuel = $requete->fetch();



        $datepresent = $db->prepare("SELECT dateinscription FROM datee WHERE dateinscription=:dateinscription;");
        $datepresent->bindParam(':dateinscription', $_POST['dateinscription']);
        $datepresent->execute();
        $resultat = $datepresent->fetch();

        if ($dateinscription <= $dateEvenementActuel['datefin'] && $dateinscription >= $dateEvenementActuel['datedebut']) {
            if(!$resultat) {
                $insertionDate = $db->prepare("INSERT INTO datee VALUES('{$dateinscription}')");
                $insertionDate->execute();
            }
            $statement = $db->prepare("INSERT INTO inscrit (numevenement, login, dateinscription) VALUES (:numevenement, :login, :dateinscription)");
            $statement->bindValue(':numevenement', $numevenement);
            $statement->bindValue(':login', $login);
            $statement->bindValue(':dateinscription', $dateinscription);
            $statement->execute();
            header("Location: index.php");
        } else {
            header("Location: profil.php");
        }
    ?>
    <?php else : ?>

        <form action="inscriptionEvent.php" method="POST" class="p-5 container-fluid d-inline-block">
            <input type="hidden" value="<?php echo $_POST['btn_id'] ?>" name="btn_id" />
            <h3>Vous avez Pas remplit La case de La date</h3>
            <button type="submit" name="retour" value="1" class="btn btn-primary btn-sm">Ressayer</button>
        </form>
    <?php endif; ?>
<?php else : ?>
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Inscrivez vous à cet évenement!</h4>
                        </div>
                        <div class="card-body">
                            <form action="inscriptionEvent.php" method="POST">
                                <div class="mb-3">
                                    <label>Date d'inscription: </label>
                                    <input type="date" name="dateinscription" class="form-control m-2">
                                    <input type="hidden" value="<?php echo $_POST['btn_id'] ?>" name="btn_id" />
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="inscription_btn" value="1" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php include_once "footer.php" ?>