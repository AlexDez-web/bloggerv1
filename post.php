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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/icon.png" type="image/png">
    <title>Publier un article</title>
    <link rel="stylesheet" href="./simplemde/dist/simplemde.min.css">
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

        <section>
            <div class="post">
                <form action="server/post.php" method="post">
                    <div>
                        <h2>Publier mon article</h2>
                        <div class="col-input">
                            <div class="form-control">
                                <label for="titre">Titre<span class="required">*</span></label> <br>
                                <input type="text" name="titre" placeholder="Titre" required> <br>
                            </div>

                            <div class="form-control">
                                <label for="url">Image de couverture</label> <br>
                                <input type="text" name="url" placeholder="Url"> <br>
                            </div>
                        </div>

                        <div class="editor-article">
                            <div class="form-control">
                                <label for="description">Description<span class="required">*</span></label> <br>
                                <textarea name="description" id="markdown-editor"></textarea> <br>
                            </div>
                        </div>

                        <div>
                            <div class="form-control">
                                <label for="keyword">Mot-clés (séparé par des virgules)</label> <br>
                                <input type="text" name="keyword" placeholder="Ex: voyage, été, destinations, vacances">
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

    <script src="./simplemde/dist/simplemde.min.js"></script>
    <script src="./assets/markdown-parser.js"></script>
</body>

</html>