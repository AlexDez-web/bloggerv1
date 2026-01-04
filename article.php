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
$user_article = "SELECT * FROM users WHERE id = '$id_user_article'";
$resultat_user_article = $connexion->query($user_article);
$user_data = [];

if ($resultat_user_article->num_rows > 0) {
    $user_data = $resultat_user_article->fetch_assoc();
}

$id_connected = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;

$req_verif_if_liste_exist = "SELECT * FROM listes where id_user = '$id_connected' AND id_article = '$id_article'";
$resultat = $connexion->query($req_verif_if_liste_exist);

if ($resultat->num_rows > 0) {
    $is_listed = true;
} else {
    $is_listed = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/icon.png" type="image/png">
    <title>Article</title>
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
                <div class="cover-image-blog">
                    <div class="image-blog-article">
                        <img src="<?php echo (!empty($article['couverture'])) ? $article['couverture'] : "./assets/blog.jpg"; ?>"
                            alt="Image du Blog">
                        <div class="title">
                            <h2><?php echo $article['titre']; ?></h2>
                        </div>
                    </div>
                </div>

                <div class="container-blog">
                    <div class="container-blog-child">
                        <div class="metadata">Publié par <span><a
                                    href="profile.php?user=<?php echo $user_data['id']; ?>"><?php echo $user_data['nom'] . " " . $user_data['prenom']; ?></a></span>
                            le
                            <span><?php echo $article['created_at']; ?></span>
                        </div>
                        <hr>

                        <div class="container-article">
                            <p id="article-content">
                                <?php echo $article['description_html']; ?>
                            </p>
                        </div>

                        <?php
                        if ($is_logged && intval($_SESSION['id']) === intval($article['id_user'])) {
                        ?>
                        <hr>
                        <div class="action">
                            <a href="modifier-article.php?article=<?php echo $article['id']; ?>">Modifier l'article</a>
                            <a>.</a>
                            <a href="server/supprimer-article.php?article=<?php echo $article['id']; ?>">Supprimer
                                l'article</a>
                            <a>.</a>
                            <a href="server/add-reading-list.php?article=<?php echo $article['id']; ?>">
                                <?php echo ($is_listed) ? "Retirer de ma liste de lecture" : "Ajouter à ma liste de lecture"; ?>
                            </a>
                        </div>
                        <?php
                        } else {
                        ?>
                        <hr>
                        <div class="action">
                            <a href="server/add-reading-list.php?article=<?php echo $article['id']; ?>">
                                <?php echo ($is_listed) ? "Retirer de ma liste de lecture" : "Ajouter à ma liste de lecture"; ?>
                            </a>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
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