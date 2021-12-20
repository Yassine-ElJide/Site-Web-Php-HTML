<?php
session_start();
session_regenerate_id();
include_once('isConnected.php');
include_once('header.php');
include_once('db.php');
//verifier l'age de l'uilisateur pour bien afficher les evenements correspondants
$now = date('Y-m-d');
$requete = $db->prepare("SELECT DISTINCT numevenement, titre
FROM (
    SELECT numevenement, description 
    FROM appartient NATURAL JOIN inscrit NATURAL JOIN evenement
    WHERE nomcategorie IN (
        SELECT nomcategorie 
        FROM appartient NATURAL JOIN inscrit  
        WHERE inscrit.login = '{$_SESSION['login']}' 
        AND avis >= 4
        AND dateinscription < '{$now}'
    )
) AS P1 UNION (
    SELECT numevenement, description 
    FROM tag NATURAL JOIN inscrit NATURAL JOIN tagger NATURAL JOIN evenement
    WHERE tag IN (
        SELECT tag 
        FROM tagger NATURAL JOIN tag NATURAL JOIN inscrit 
        WHERE inscrit.login = '{$_SESSION['login']}' 
        AND avis >= 4 
        AND dateinscription < '{$now}'
    )
)
");
$requete->execute();
$suggestions = $requete->fetchAll();
?>

<section class="text-dark p-5 m-3 rounded">
    <h3 class="text-center p-4">Suggestions Pour vous!</h3>
    <div class="container">
        <div class="row justify-content-center">
            <?php foreach ($suggestions as $sugg) : ?>
                <div class="col-md-3 m-1 bg-secondary p-4 rounded text-center">
                    <p><?php echo $sugg['titre']; ?></p>
                    <form action="eventDetails.php" method="POST" class="d-inline-block col m-2">
                        <button type="submit" name="btn_id" value="<?php echo $sugg['numevenement'] ?>" class="btn btn-primary">Voir détails</button>
                    </form>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>

<?php include_once "footer.php" ?>