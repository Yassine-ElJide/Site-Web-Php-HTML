<?php
session_start();
include('db.php');
include_once('header.php');
?>


<?php
$errors = array();
if (!empty($_POST['register_btn']) && !empty($_POST['login']) && !empty($_POST['datedenaissance']) && !empty($_POST['confirmmotdepasse']) && !empty($_POST['adresse']) && !empty($_POST['motdepasse']) && !empty($_POST['prenom'])) {
    $login = $_POST['login'];
    $motdepasse = $_POST['motdepasse'];
    $adresse = $_POST['adresse'];
    $datedenaissance = $_POST['datedenaissance'];
    $prenom = $_POST['prenom'];
    if (!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
        $message = "Le login ne doit contenir que des lettres et des nombres.";
        array_push($errors, $message);
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $motdepasse)) {
        $message = "Le mot de passe ne doit contenir que des lettres et des nombres.";
        array_push($errors, $message);
    } elseif ($motdepasse != $_POST['confirmmotdepasse']) {
        $message = "Les mots de passe doivent être identiques !";
        array_push($errors, $message);
    } elseif (!filter_var($adresse, FILTER_VALIDATE_EMAIL)) {
        $message = "L'email entré est invalide.";
        array_push($errors, $message);
    } else {
        $insertion = $db->prepare("INSERT INTO utilisateur VALUES (:login, :prenom, :motdepasse, :adresse, :datenaissance)");
        $insertion->bindParam(':login', $login);
        $insertion->bindParam(':prenom', $prenom);
        $insertion->bindValue(':motdepasse', $motdepasse);
        $insertion->bindValue(':adresse', $adresse);
        $insertion->bindParam(':datenaissance', $datedenaissance);
        if ($insertion->execute()) {
            header('Location: login.php');
        } 
    }
} else if (!empty(($_POST['register_btn']))) {
    $message = "Informations manquantes.";
    array_push($errors, $message);
}

?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger"><?php echo $errors[0]; ?></div>
<?php endif; ?>

<div class="container" style="margin-top: 20px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Register</h4>
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST">
                        <div class="mb-2">
                            <label for="prenom">Prenom: </label>
                            <input type="text" name="prenom" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label for="login">Login: </label>
                            <input type="text" name="login" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label for="motdepasse">Mot de passe:</label>
                            <input type="password" name="motdepasse" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label for="confirmpassword">Confirmer mot de passe: </label>
                            <input type="password" name="confirmmotdepasse" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label for="adresse">Email: </label>
                            <input type="email" name="adresse" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label for="datedenaissance">Date de naissance: </label>
                            <input type="date" name="datedenaissance" class="form-control">
                        </div>
                        <div class="mb-2">
                            <button type="submit" name="register_btn" value="1" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include_once "footer.php" ?>