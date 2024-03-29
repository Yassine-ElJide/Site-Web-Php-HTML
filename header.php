<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <title>SGG City</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SGG City</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./recherche.php">Rechercher</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./suggestions.php">Suggestions</a>
                    </li>
                    <?php if (!empty($_SESSION['login'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./profil.php">Mon Profil</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if (!empty($_SESSION['login'])) : ?>
                    <div>
                        <button class="btn btn-info"><a href="./creeEvenement.php" class="text-decoration-none fw-normal text-dark">Créer événement</a></button>
                        <button class="btn btn-danger"><a href="./logout.php" class="text-decoration-none fw-normal text-dark">Se déconnecter</a></button>
                    </div>
                <?php else : ?>
                    <form class="d-inline-block ">
                        <button class="btn btn-primary col"><a href="login.php" class="text-decoration-none text-dark fw-normal text-center">Se connecter</a></button>
                        <button class="btn btn-warning col"><a href="register.php" class="text-decoration-none text-dark fw-normal text-center">S'inscrire</a></button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>