<?php
require('./server/connexion.php');

session_start();

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $id = intval($_SESSION['id']);

    $req_verif = "SELECT * FROM users where id = '$id'";
    $resultat_verif = $connexion->query($req_verif);

    if ($resultat_verif->num_rows > 0) {
        $is_logged = true;
    } else {
        $is_logged = false;
    }
} else {
    $is_logged = false;
}

if (!$is_logged) {
    header("Location: login.php");
    exit;
}

$id = intval($_SESSION['id']);
$req_user = "SELECT * FROM users WHERE id = '$id'";
$resultat_user = $connexion->query($req_user);
$user_data = [];

if ($resultat_user->num_rows > 0) {
    $user_data = $resultat_user->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/icon.png" type="image/png">
    <title>Modifier mon profil</title>
    <link rel="stylesheet" href="./assets/styles.css">
</head>

<body>
    <main>
        <header>
            <div class="logo">
                <a href="index.php">BLOGGER</a>
            </div>
            <nav>
                <?php
                if (!$is_logged) {
                ?>
                <ul>
                    <li><a href="login.php">Connexion</a></li>
                    <li><a href="inscription.php">Inscription</a></li>
                </ul>
                <?php
                } else {
                ?>
                <ul>
                    <li><a href="post.php">Nouvel article</a></li>
                    <li><a href="liste-lecture.php">Ma liste de lecture</a></li>
                    <li><a href="profile.php">Mon profil</a></li>
                    <li><a href="server/logout.php">Déconnexion</a></li>
                </ul>
                <?php
                }
                ?>
            </nav>
        </header>
        <section class="container">
            <div>
                <form action="server/update-profile.php" method="post">
                    <div>
                        <h2>Modifier mes informations</h2>
                        <div class="col-input">
                            <div class="form-control">
                                <label for="nom">Nom</label> <br>
                                <input type="text" name="nom" placeholder="Nom"
                                    value="<?php echo $user_data['nom']; ?>"> <br>
                            </div>

                            <div class="form-control">
                                <label for="prenom">Prénom</label> <br>
                                <input type="text" name="prenom" placeholder="Prenom"
                                    value="<?php echo $user_data['prenom']; ?>"> <br>
                            </div>
                        </div>

                        <div class="form-control">
                            <label>Saisissez les champs ci-dessous si vous souhaitez également modifier votre mot de
                                passe, <br> sinon ignorez-les !</span>
                        </div>

                        <div class="col-input">
                            <div class="form-control">
                                <label for="password">Mot de passe <span class="required">*</span></label> <br>
                                <input type="password" name="password" placeholder="Mot de passe"> <br>
                            </div>

                            <div class="form-control">
                                <label for="confirm_password">Confirmation du mot de passe <span
                                        class="required">*</span></label> <br>
                                <input type="password" name="confirm_password" placeholder="Mot de passe">
                                <br>
                            </div>
                        </div>

                        <div class="submit">
                            <div class="form-control">
                                <button type="submit">Soumettre</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <hr>
        <footer>
            <div class="logo">
                <a href="index.php">BLOGGER</a>
            </div>

            <div>
                Copyright © 2023 My blog M.B Tous droits réservés.
            </div>

            <?php $connexion->close(); ?>
        </footer>
    </main>
</body>

</html>