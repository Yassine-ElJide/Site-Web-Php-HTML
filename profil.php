<?php
session_start();
session_regenerate_id();
include_once('header.php');
include_once('db.php');
include_once('isConnected.php');
// Evenements passés
$now = date('20y-m-d');
$requete = $db->prepare("SELECT titre, numevenement FROM evenement NATURAL JOIN inscrit WHERE login = '{$_SESSION['login']}' and dateinscription <= '{$now}'");
$requete->execute();
$evenementsPasses = $requete->fetchAll();

//Evenements à venir
$requeteAv = $db->prepare("SELECT titre, numevenement, dateinscription  FROM evenement NATURAL JOIN inscrit WHERE login = '{$_SESSION['login']}' and dateinscription > '{$now}'");
$requeteAv->execute();
$evenementsAvenir = $requeteAv->fetchAll();


?>
<style>
    .custom {
        width: 78px !important;
    }
</style>

<?php
if (isset($_POST['btn_even'])) {
    $file = $_FILES['image'];
    //Upload image
    $filename = $_FILES['image']['name'];
    $filetmpname = $_FILES['image']['tmp_name'];
    $filesize = $_FILES['image']['size'];
    $fileerror = $_FILES['image']['error'];
    $filetype = $_FILES['image']['type'];
    $fileext = explode('.', $filename);
    $fileactualext = strtolower(end($fileext));
    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($fileactualext, $allowed)) {
        if ($fileerror === 0) {
            if($filesize < 1000000){
                $filenamenew = uniqid('', true).".".$fileactualext;
                $filedestination = 'uploads/'.$filenamenew;
                move_uploaded_file($filetmpname, $filedestination);
            } else {
                echo "Votre fichier est immense";
            }
        } else {
            echo "Une erreur en uploadant votre image";
        }
    } else {
        echo "Vous pouvez pas uploader des fichiers de ce type";
    };




    //requete insertion image et commentaire
    $statement1 = $db->prepare("UPDATE inscrit set commentaire = '{$_POST['commentaire']}' , avis = '{$_POST['note']}' WHERE login = '{$_SESSION['login']}' AND numevenement = '{$_POST['btn_even']}' ");
    $statement1->execute();
    $statement2 = $db->prepare("INSERT INTO photo (lienphoto, numevenement, login) VALUES('{$filedestination}', '{$_POST['btn_even']}', '{$_SESSION['login']}')");
    $statement2->execute();
}
?>

<section class="p-5">
    <div class="container">
        <div class="row ">
            <!-- Evenements passés -->
            <div class="col-lg-6">
                <h3 class="text-center m-2 align-items-center">Evenements Passés</h3>
                <div class="row align-items-center justify-content-center m-2 bg-secondary p-4 rounded">
                    <?php foreach ($evenementsPasses as $evePs) : ?>
                        <div class="container p-3">
                        <div class="col p-2 bg-secondary justify-content-start">
                            <?php echo $evePs['titre']; ?>
                        </div>
                        <div class="col text-light">
                            <form action="profil.php" method="POST" enctype="multipart/form-data">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">Note</span>
                                    <input class="form-control" type="number" name="note" min="0" max="5">
                                </div>
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">Commentaire</span>
                                    <textarea name="commentaire" class="form-control" cols="4" style="resize:none" rows="5"></textarea>
                                </div>
                                <div class="input-group input-group-sm mb-3">
                                    <input type="file" class="form-control" name="image" />
                                </div>
                                <button href="#" class="btn btn-warning text-decoration-none" type="submit" name="btn_even" value="<?php echo $evePs['numevenement']; ?>">Envoyé</button>
                            </form>
                        </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Evenements à venir -->
            <div class="col-lg-4 p-5">
                <h3 class="text-center m-2 align-items-center">Evenements A venir</h3>
                <?php foreach ($evenementsAvenir as $eveAv) : ?>
                    <div class="col-md p-4">
                        <div class="card bg-dark text-light">
                            <div class="card-body text-center">
                                <p><?php echo $eveAv['titre']; ?></p>
                                <button class="btn btn-primary btn" data-bs-toggle="modal" data-bs-target="#invitations">
                                    Invitez vos proches
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
            if (isset($_POST['accept_btn']) || isset($_POST['refus_btn'])) {
                $statut = $_POST['accept_btn'] ?? $_POST['refus_btn'];
                $idinvitation = $_POST['idinvitation'];
                $response = $db->query("UPDATE invitation SET statut = '{$statut}' WHERE idinvitation = {$idinvitation}");
                $response->execute();
            }
            ?>

            <!-- CSS EVENEMENT PASSES -->
            <?php
            //invitations envoyées
            $requeteInvit = $db->prepare("SELECT logindestinataire, statut, message FROM invitation NATURAL JOIN evenement WHERE loginexpediteur = '{$_SESSION['login']}'");
            $requeteInvit->execute();
            $invitationsEnvoyes = $requeteInvit->fetchAll();

            //invitations reçus
            $requeteRecus = $db->prepare("SELECT loginexpediteur, message, statut, idinvitation FROM invitation NATURAL JOIN evenement WHERE logindestinataire = '{$_SESSION['login']}' ");
            $requeteRecus->execute();
            $invitationsRecus = $requeteRecus->fetchAll();
            ?>
            <!-- Invitations -->
            <div class="col-lg-2">
                <h3 class="text-center m-2 align-items-center">Invitations</h3>
                <?php foreach ($invitationsEnvoyes as $invEnv) : ?>
                    <div class="row align-items-center justify-content-center bg-info rounded p-2 m-2">
                        <span class="col p-3 text-light">A: <?php echo $invEnv['logindestinataire']; ?></span>
                        <p class="col"><?php echo $invEnv['message'] ?></p>
                        <div class="col d-flex"><span>Statut:</span><?php echo $invEnv['statut']; ?></div>
                    </div>
                <?php endforeach; ?>
                <?php foreach ($invitationsRecus as $invRec) : ?>
                    <div class="row align-items-center justify-content-center bg-dark rounded p-3 m-2">
                        <span class="col p-3 text-light">De: <?php echo $invRec['loginexpediteur']; ?></span>
                        <p class="col text-light"><?php echo $invRec['message'] ?></p>
                        <form action="profil.php" method="POST">
                            <?php if ($invRec['statut'] != 'Refusé' && $invRec['statut'] != 'Accepté') : ?>
                                <button class="btn btn-info btn-sm custom m-1" type="submit" name="accept_btn" value="Accepté">Accepter</button>
                                <button class="btn btn-danger btn-sm custom m-1" type="submit" name="refus_btn" value="Refusé">Refuser</button>
                            <?php endif; ?>
                            <input type="hidden" name="idinvitation" value="<?php echo $invRec['idinvitation']; ?>">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <!-- Form des invitations -->
        <?php
        //requete pour les destinatires 
        $requete = $db->prepare("SELECT login FROM utilisateur WHERE login != '{$_SESSION['login']}' ORDER BY login");
        $requete->execute();
        $utilisateurs = $requete->fetchAll();
        ?>
        <!-- Modal de l'invitations -->
        <div class="modal fade" id="invitations" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Invitez quelqu'un</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="invitation.php" method="POST">
                        <input type="hidden" name="numevenement" value="<?php echo $eveAv['numevenement']; ?>">
                        <div class="modal-body">
                            <p class="lead">Remplissez cette forme pour inviter quelqu'un à cet événement</p>
                            <div class="mb-3">
                                <label class="col-form-label" for="destinataire">
                                    Login destinataire:
                                </label>
                                <select name="destinataire" id="destinataire">
                                    <?php foreach ($utilisateurs as $utilisateur) : ?>
                                        <option><?php echo $utilisateur['login'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Message:</span>
                                <textarea name="message" class="form-control" cols="4" style="resize:none" rows="5"></textarea>
                                <input type="hidden" name="dateinscription" value="<?php echo $eveAv['dateinscription']; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" name="invitation_btn" value="<?php echo $eveAv['numevenement']; ?>">Invitez</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>


<?php include_once('footer.php'); ?>