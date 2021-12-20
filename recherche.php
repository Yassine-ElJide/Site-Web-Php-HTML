<?php
session_start();
session_regenerate_id();
include_once "isConnected.php";
include_once "db.php";
include_once "header.php";
?>
    <section class="bg-light text-light p-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="recherche.php" method="POST" class="col">
                        <div class="input-group news-input">
                            <input type="text" class="form-control" name="categorie" placeholder="Recherchez Par catégorie..." />
                            <button class="btn btn-dark btn-lg" name="cat_btn" type="submit" value="1"><i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col">
                    <form action="recherche.php" method="POST" class="col">
                        <div class="input-group news-input">
                            <input type="text" class="form-control" name="tag" placeholder="Recherchez Par tag..." />
                            <button class="btn btn-dark btn-lg" name="tg_btn" type="submit" value="2"><i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php if (!empty($_POST['cat_btn']) && !empty($_POST['categorie'])) :
    $categorie = strtolower(trim($_POST['categorie']));    
    $requete = $db->query("SELECT description, numevenement from appartient natural join evenement where lower(nomcategorie) LIKE '%{$categorie}%'");
    $requete->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($requete as $evenement) : ?>
        <div class="container">
            <div class="row justify-content-center w-30">
                <div class="col-9 mt-2 mb-2"><?php echo $evenement['description']; ?></div>
                <form action="eventDetails.php" method="POST" class="d-inline-block col m-2">
                    <button type="submit" name="btn_id" value="<?php echo $evenement['numevenement'] ?>" class="btn btn-primary">Voir détails</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

<?php elseif (!empty($_POST['tg_btn']) && !empty($_POST['tag'])) :
    $tag = strtolower(trim($_POST['tag']));
    $requete = $db->query("select description, numevenement from tag natural join tagger natural join evenement where lower(nomtag) LIKE '%#{$tag}%'");
    $requete->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($requete as $evenement) : ?>
        <div class="container">
            <div class="row justify-content-center w-30">
                <div class="col-9 mt-2 mb-2"><?php echo $evenement['description']; ?></div>
                <form action="eventDetails.php" method="POST" class="d-inline-block col m-2">
                    <button type="submit" name="btn_id" value="<?php echo $evenement['numevenement'] ?>" class="btn btn-primary">Voir détails</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

<?php endif; ?>


<?php include_once "footer.php" ?>