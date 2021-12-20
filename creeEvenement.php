<?php
session_start();
session_regenerate_id();
include_once('isConnected.php');
include('db.php');
include_once('header.php');
?>


<?php
$nberreur = 0;

if (!empty($_POST['creeEv_btn']) && !empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['datedebut']) && !empty($_POST['datefin']) && !empty($_POST['lieu'])) {
    if ($_POST['datedebut'] > $_POST['datefin']) { // le cas ou la date de debut est superieur à celle de la fin
        $erreur = "Merci de chosir une \"datedebut\" et \"datefin\" valide.";
        $nberreur = 1;
    } else { // le cas ou tous est bien choisi par l'utilisateur
        $requeteEv = "INSERT INTO evenement (titre, description, debutage, limiteage, lieu, datedebut, datefin) VALUES (:titre, :description, :debutage, :limiteage, :lieu, :datedebut, :datefin)";
        $insert = $db->prepare($requeteEv);
        $success = $insert->execute(array(
            ":titre" => $_POST['titre'],
            ":description" => $_POST['description'],
            ":debutage" => $_POST['debutage'],
            ":limiteage" => $_POST['limiteage'],
            ":lieu" => $_POST['lieu'],
            ":datedebut" => $_POST['datedebut'],
            ":datefin" => $_POST['datefin']
        ));
        $num = $db->lastInsertId();

        $categroiepresent = $db->prepare("SELECT nomcategorie FROM categorie WHERE nomcategorie=:nomcategorie;");
        $categroiepresent->bindParam(':nomcategorie', $_POST['nomcategorie']);
        $categroiepresent->execute();
        $resultat = $categroiepresent->fetch();

        if (!$resultat) {
            // insertion categorie
            $requeteCat = $db->prepare("INSERT INTO categorie VALUES ('{$_POST['nomcategorie']}')");
            $requeteCat->execute();
        }

        //appartient
        $requeteApp =  $db->prepare("INSERT INTO appartient VALUES ({$num},'{$_POST['nomcategorie']}')");
        $requeteApp->execute();
        header('location: index.php');
    }
} else if (!empty($_POST['creeEv_btn'])) { // utilisateur à cliquer le bouton pour inserer un evenement mais il y a des informations manquantes
    $erreur = "Informations manquantes.";
    $nberreur = 1;
}

?>

<?php if ($nberreur == 1) : ?>
    <div class="alert alert-danger"><?php echo $erreur ?></div>
<?php endif; ?>

<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Créer un évenement</h4>
                </div>
                <div class="card-body">
                    <form action="creeEvenement.php" method="POST">
                        <div class="mb-2">
                            <label>Date de début: </label>
                            <input type="date" name="datedebut" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Date de fin: </label>
                            <input type="date" name="datefin" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Debut Age: </label>
                            <input type="number" name="debutage" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Limite Age: </label>
                            <input type="number" name="limiteage" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Lieu de l'événement: </label>
                            <input type="text" name="lieu" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Titre de l'événement: </label>
                            <input type="text" name="titre" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Catégorie de l'événement: </label>
                            <input type="text" name="nomcategorie" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Description: </label>
                            <textarea name="description" class="form-control" cols="4" style="resize:none" rows="5"></textarea>
                        </div>
                        <div class="mb-2">
                            <button type="submit" name="creeEv_btn" value="1" class="btn btn-primary">Envoyé</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include_once "footer.php" ?>