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

$article = [];

if (isset($_GET['article']) && !empty($_GET['article'])) {
    $id_article = intval($_GET['article']);

    $query_article = "SELECT * FROM articles WHERE id = '$id_article'";
    $resultat_query_article = $connexion->query($query_article);

    if (!($resultat_query_article->num_rows > 0)) {
        header("Location: index.php");
        exit;
    } else {
        $article = $resultat_query_article->fetch_assoc();
    }
} else {
    header("Location: index.php");
    exit;
}

$id_user_article = $article["id_user"];

if (intval($id_user_article) !== intval($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$user_article = "SELECT * FROM users WHERE id = '$id_user_article'";
$resultat_user_article = $connexion->query($user_article);
$user_data = [];

if ($resultat_user_article->num_rows > 0) {
    $user_data = $resultat_user_article->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/icon.png" type="image/png">
    <title>Modifier mon article</title>
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
                <form action="server/update-article.php" method="post">
                    <div>
                        <h2>Modifier mon article</h2>
                        <div class="col-input">
                            <div class="form-control">
                                <label for="titre">Titre<span class="required">*</span></label> <br>
                                <input type="text" name="titre" placeholder="Titre" value="<?php echo $article['titre']; ?>" required> <br>
                            </div>

                            <div class="form-control">
                                <label for="url">Image de couverture</label> <br>
                                <input type="text" name="url" placeholder="Url" value="<?php echo $article['couverture']; ?>"> <br>
                            </div>
                        </div>

                        <div class="editor-article">
                            <div class="form-control">
                                <label for="description">Description<span class="required">*</span></label> <br>
                                <textarea name="description" id="markdown-editor"><?php echo $article['description']; ?></textarea> <br>
                            </div>
                        </div>

                        <div>
                            <div class="form-control">
                                <label for="keyword">Mot-clés (séparé par des virgules)</label> <br>
                                <input type="text" name="keyword" placeholder="Ex: voyage, été, destinations, vacances" value="<?php echo $article['tag']; ?>" required> <br>
                            </div>
                        </div>

                        <input type="hidden" name="id_article" value="<?php echo $article['id']; ?>">

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