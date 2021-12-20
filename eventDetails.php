<?php
session_start();
session_regenerate_id();
include_once "isConnected.php";
include_once "db.php";
include_once "header.php";
$id = $_POST['btn_id'];
$insc_possible = 0; // la variable qui va contenir 0 si inscription impossible, et 1 sinon
$dateMtn = Date('Y-m-d');

$requete = $db->prepare("SELECT numevenement, titre, description, debutage, limiteage, lieu, datedebut, datefin FROM evenement WHERE numevenement= $id");
$requete->execute();
$response = $requete->fetch();

$requete2 = $db->prepare("SELECT datenaissance FROM utilisateur WHERE login = '{$_SESSION['login']}'");
$requete2->execute();
$datenaissance = $requete2->fetch();

$age = $dateMtn - $datenaissance['datenaissance']; // age de l'utilisateur

if (!empty($_POST['insere_tag']) && !empty($_POST['tag'])) {
    $tagpresent = $db->prepare("SELECT idtag, nomtag FROM tag WHERE nomtag=:tag;");
    $tagpresent->bindParam(':tag', $_POST['tag']);
    $tagpresent->execute();
    $tag = $tagpresent->fetch();
    if(!$tag) {
        $requeteTg = "INSERT INTO tag (nomtag) VALUES (:nomtag)";
        $insert = $db->prepare($requeteTg);
        $success = $insert->execute(array(
            ":nomtag" => $_POST['tag'],
        ));
        $num = $db->lastInsertId();
    } else {
        $num = $tag['idtag'];
    }
    $statement = $db->prepare("INSERT INTO tagger (numevenement, idtag, login) VALUES (:numevenement, :idtag, :login)");
    $statement->bindValue(':numevenement', $id);
    $statement->bindValue(':idtag', $num);
    $statement->bindValue(':login', $_SESSION['login']);
    $statement->execute();
} else if (!empty($_POST['insere_tag'])){
    echo "<div class=\"alert alert-danger\">Nom de la tag manquant</div>";
}
?>

    <?php if ($_POST['btn_id']) : ?>
        <section class="container p-5 ">
            <div class="row">
                <div class="col">
                    <h1 class="display-4 font-italic fw-normal text-center text-dark"><?php echo $response['titre']; ?></h1>
                    <p class="lead my-2 text-center p-4 text-dark"><?php echo $response['description']; ?></p>
                </div>
                <div class="col">
                    <h4 class="text-center fw-normal p-3">Informations sur l'événement</h4>
                    <ul class="list-group">
                        <li class="list-group-item mb-2 rounded">Cet évenement aura lieu à:<?php echo $response['lieu']; ?></li>
                        <?php if ($response['debutage'] == NULL && $response['limiteage'] == NULL): ?>
                            <li class="list-group-item mb-2 rounded">L'evenement est accessible pour tous les gens quelque soit leurs age</li>
                        <?php elseif ($response['debutage'] != NULL && $response['limiteage'] == NULL): ?>
                            <li class="list-group-item mb-2 rounded">L'evenement est accessible pour les gens +<?php echo $response['debutage'] ?> ans</li>
                        <?php elseif ($response['debutage'] == NULL && $response['limiteage'] != NULL): ?>
                            <li class="list-group-item mb-2 rounded">L'evenement est accessible pour les gens -<?php echo $response['limiteage'] ?> ans</li>
                        <?php elseif ($response['debutage'] != NULL && $response['limiteage'] != NULL): ?>
                            <li class="list-group-item mb-2 rounded">L'evenement est accessible pour +<?php echo $response['debutage'] ?> ans de et -<?php echo $response['limiteage'] ?> ans</li>
                        <?php endif; ?>
                        <li class="list-group-item mb-2 rounded">On va commencer le <?php echo $response['datedebut']; ?></li>
                        <li class="list-group-item mb-2 rounded">On finit <?php echo $response['datefin']; ?></li>
                    </ul>
                </div>
            </div>

            <!-- ce bloc de code juste pour detecter si l'inscription est possible ou pas, il es long car on doit savoir s'il y a des valeurs null -->
            <?php if ($response['debutage'] != NULL && $response['limiteage'] != NULL) {
                if ($age >= $response['debutage'] && $age <= $response['limiteage']) {
                    $insc_possible = 1;
                } else {
                    $insc_possible = 0;
                }
            } elseif ($response['debutage'] != NULL && $response['limiteage'] == NULL) {
                if ($age >= $response['debutage']) {
                    $insc_possible = 1;
                } else {
                    $insc_possible = 0;
                }
            } elseif ($response['debutage'] == NULL && $response['limiteage'] != NULL) {
                if ($age <= $response['limiteage']) {
                    $insc_possible = 1;
                } else {
                    $insc_possible = 0;
                }
            } elseif ($response['debutage'] == NULL && $response['limiteage'] == NULL) {
                $insc_possible = 1;
            } ?>

            <!-- ce bloc de code juste pour detecter si l'inscription est possible ou pas, en se basant sur les dates de debut et fin -->
            <?php
                if ($dateMtn > $response['datefin']) {
                    $insc_possible = 0;
                }
            ?>


            <!-- en fonction de la valeur de la variable $insc_possible le boutton d'inscription s'affiche si inscription possible et disparait sinon -->
            <?php if ($insc_possible == 1) : ?>
            <form action="inscriptionEvent.php" method="POST" class="d-inline-block">
                <button class="btn btn-warning btn-sm" name="btn_id" value="<?php echo $response['numevenement'] ?>">S'inscrire</button>
            </form>
            <?php else : ?>
                <p class="btn btn-warning btn-sm" name="btn_id" value="<?php echo $response['numevenement'] ?>">Impossible de s'inscrire</p>
            <?php endif; ?>
        
            <button class="btn btn-primary btn-sm"><a href="./index.php" class="text-decoration-none text-dark">Retour à la page des évenements</a></button>


            </div>  
                <?php
                    $requete3 = $db->query("SELECT commentaire, avis, lienphoto, inscrit.login FROM photo NATURAL JOIN utilisateur NATURAL JOIN inscrit WHERE inscrit.numevenement = '{$id}'");
                    $infoparticipants = $requete3->fetchAll();
                ?>
                    <div class="row mb-2">
                        <form action="eventDetails.php" method="POST">
                            <div class="mb-2">
                                <input type="text" name="tag" placeholder="Ajoutez un tag ..." class="form-control">
                                <input type="hidden" value="<?php echo $_POST['btn_id'] ?>" name="btn_id" />
                                <button type="submit" name="insere_tag" value="1" class="btn btn-primary">Ajoutez</button>
                            </div>
                        </form>
                        <?php foreach ($infoparticipants as $infoparticipant) : ?>
                            <div class="col-md">
                                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                                    <div class="card-body d-flex flex-column align-items-start">
                                        <strong class="d-inline-block mb-2 text-primary"><?php echo  $infoparticipant['login']; ?></strong>
                                        <div class="mb-1 text-muted">Note: <?php echo $infoparticipant['avis']; ?>/5</div>
                                        <p class="card-text mb-auto"><?php echo $infoparticipant['commentaire']; ?></p>
                                    </div>
                                    <img class="card-img-right" src="<?php echo $infoparticipant['lienphoto']; ?>" alt="Card image cap">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
        </section>
    <?php endif; ?>
    
<?php include_once "footer.php" ?>

