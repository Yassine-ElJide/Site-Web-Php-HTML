<?php
session_start();
include('db.php');
require_once "header.php";
?>


<?php

if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['login_btn'])) {
    $err = 0;
    $requete = $db->prepare("SELECT * FROM utilisateur WHERE login=:login;");
    $requete->bindParam(':login', $_POST['login']);
    $requete->execute();
    $resultat = $requete->fetch();
    if ($resultat) {
        if ($_POST['password'] == $resultat['motdepasse']) {
            $_SESSION['login'] = $resultat['login'];
            header("Location: index.php");
        } else {
            $message = "Mot de passe incorrect.";
            $err = 1;
        }
    } else {
        $message = "Login inexistant.";
        $err = 1;
    }
} else if (!empty($_POST['login_btn']) && (empty($_POST['login']) || empty($_POST['password']))) {
    $message = "Informations manquantes.";
    $err = 1;
}
?>

<section class="vh-100">
    <?php if (isset($err)) : ?>
        <?php if ($err == 1) : ?>
            <div class="alert alert-danger"><?php echo $message ?></div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-login-form/draw2.svg" class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form action="login.php" method="post">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="login">Login: </label>
                        <input type="text" class="form-control form-control-md" name="login" />
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control form-control-md" name="password" />
                    </div>
                    <div class="d-flex justify-content-around align-items-center mb-4">
                        <a href="./register.php">Vous n'avez pas de compte ? Inscrivez-vous ici!</a>
                    </div>
                    <button type="submit" name="login_btn" value="1" class="btn btn-primary btn-md">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include_once "footer.php" ?>