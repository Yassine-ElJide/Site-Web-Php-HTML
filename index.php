<?php
session_start();
session_regenerate_id();
include_once "db.php";
include_once "header.php";
$dateApres = Date('Y-m-d', strtotime('+30 days'));
$dateMtn = Date('Y-m-d');
$requete1 = $db->prepare("SELECT numevenement, titre FROM evenement WHERE datefin > '{$dateMtn}'");
$requete1->execute();
$resultat = $requete1->fetchAll();


// Les photos des évenements récemment terminés
$requete2 = $db->prepare("SELECT login FROM utilisateur");
$requete2->execute();
$utilisateurs = $requete2->fetchAll();

foreach ($utilisateurs as $utilisateur) {
    $requete3 = $db->prepare("SELECT lienphoto, numevenement FROM photo NATURAL JOIN Evenement NATURAL JOIN inscrit WHERE login = '{$utilisateur['login']}' AND dateinscription < '{$dateMtn}' ORDER BY dateinscription DESC LIMIT 5");
    $requete3->execute();
    $events = $requete3->fetchAll();
}
?>
<section class="text-light text-dark text-center p-5 m-4 rounded">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-5">
                <h3 class="text-md-center fw-normal">Evenements Proches:</h3>
                <?php foreach ($resultat as $evenement) : ?>
                    <div class="row bg-dark m-4 rounded p-2">
                        <p class="lead text-center text-light"><?php echo $evenement['titre']; ?></p>
                        <form action="eventDetails.php" method="POST">
                            <button type="submit" name="btn_id" value="<?php echo $evenement['numevenement'] ?>" class="btn btn-primary">Voir détails</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Evenements recents -->
            <div class="col-md-7 justify-content-center align-items-center">
                <h2 class="text-md-center">Evenements Recents:</h2>
                <div class="container g-2">
                    <div class="row justify-content-center align-items-center">

                        <?php 
                            foreach ($utilisateurs as $utilisateur) {
                                $requete3 = $db->prepare("SELECT lienphoto, numevenement FROM photo NATURAL JOIN Evenement NATURAL JOIN inscrit WHERE login = '{$utilisateur['login']}' AND dateinscription < '{$dateMtn}' ORDER BY dateinscription DESC LIMIT 5");
                                $requete3->execute();
                                $events = $requete3->fetchAll();

                                foreach ($events as $event) : ?>
                                    <div class="col-md-10">
                                        <img class="card-img-right w-50 vertical-align" style="width: 100%;" src="<?php echo $event['lienphoto']; ?>" alt="Card image cap">
                                        <form action="eventDetails.php" method="POST">
                                            <button type="submit" name="btn_id" value="<?php echo $event['numevenement'] ?>" class="btn btn-primary btn-sm m-2">Voir détails</button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                        <?php    } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once('footer.php') ?>