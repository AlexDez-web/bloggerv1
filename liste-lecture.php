<?php
require('./server/connexion.php');

session_start();

function formatterDate($date)
{
    // Créer un objet DateTime à partir de la date donnée
    $dateObj = new DateTime($date);

    // Formater la date comme "jour Mois Année" et la retourner
    return $dateObj->format('d F Y');
}

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $id = intval($_SESSION['id']);

    $req_verif = "SELECT * FROM users where id = '$id'";
    $resultat_verif = $connexion->query($req_verif);

    if ($resultat_verif->num_rows > 0) {
        $is_logged = true;
        $fetch_user = $resultat_verif->fetch_assoc();
    } else {
        $is_logged = false;
    }
} else {
    $is_logged = false;
}

if ($is_logged) {
    $id_connected = intval($_SESSION['id']);
} else {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM users where id = '$id_connected'";
$resultat_query = $connexion->query($query);

if ($resultat_query->num_rows > 0) {
    $fetch_user = $resultat_query->fetch_assoc();
} else {
    header("Location: login.php");
    exit;
}

$req_verif_if_liste_exist = "SELECT * FROM listes where id_user = '$id_connected'";
$resultat_liste = $connexion->query($req_verif_if_liste_exist);

?>
<!DOCTYPE php>
<php lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="./assets/icon.png" type="image/png">
        <title>Liste de lecture</title>
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
                <div class="container-blog">
                    <div class="container-blog-child">
                        <div class="profil-info">
                            <div class="description-liste">
                                <span>La liste de Lecture est votre espace personnel dédié à la gestion de tous les
                                    contenus
                                    que vous souhaitez explorer, lire et découvrir. Que vous soyez un amateur de livres,
                                    un mélomane passionné, ou un cinéphile en herbe, cette page est conçue pour vous
                                    aider à
                                    organiser et à suivre vos prochaines lectures.</span>
                            </div>
                        </div>
                        <hr>

                        <div style="margin-top: 1rem;">
                            <h1>Ma liste de lecture</h1>
                        </div>

                        <div class="container-list-blog">

                            <div class="list-blog">
                                <?php

                                if ($resultat_liste->num_rows > 0) {
                                    while ($liste = $resultat_liste->fetch_assoc()) {
                                        $get_id_article = $liste['id_article'];

                                        $query_articles = "SELECT * FROM articles where id = '$get_id_article'";
                                        $resultat_query_articles = $connexion->query($query_articles);

                                        if ($resultat_query_articles->num_rows > 0) {
                                            while ($article = $resultat_query_articles->fetch_assoc()) {
                                                $id_user_article = $article["id_user"];
                                                $user_article = "SELECT * FROM users WHERE id = '$id_user_article'";
                                                $resultat_user_article = $connexion->query($user_article);
                                                $user_data = [];

                                                if ($resultat_user_article->num_rows > 0) {
                                                    $user_data = $resultat_user_article->fetch_assoc();
                                                }
                                ?>
                                <div>
                                    <div style="overflow:hidden;border-radius:1rem;">
                                        <a href="article.php?article=<?php echo $article['id']; ?>" class="blog">
                                            <div class="container-image-blog">
                                                <div class="image-blog">
                                                    <img src="<?php echo (!empty($article['couverture'])) ? $article['couverture'] : "./assets/blog.jpg"; ?>"
                                                        alt="Couverture du Blog">
                                                </div>
                                            </div>

                                            <div class="blog-title">
                                                <span><?php echo (strlen($article['titre']) >= 60) ? substr($article['titre'], 0, 60) . "..." : $article['titre']; ?></span>
                                            </div>
                                        </a>
                                    </div>

                                    <div style="padding: 1rem 0;">
                                        <?php echo $user_data['nom'] . " " . $user_data['prenom']; ?> -
                                        <span><?php echo formatterDate($article['created_at']); ?></span>
                                        <div>
                                            <a href="server/add-reading-list.php?article=<?php echo $article['id']; ?>">Retirer
                                                de ma liste</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                            }
                                        } else {
                                            ?>
                                <div>
                                    <div style="overflow:hidden;border-radius:1rem;">
                                        <a href="" class="blog">
                                            <div class="container-image-blog">
                                                <div class="image-blog">
                                                    <img src="./assets/blog.jpg" alt="Image du Blog">
                                                </div>
                                            </div>

                                            <div class="blog-title" id="deleted">
                                                <span>ARTICLE SUPPRIMER</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div style="padding: 1rem 0;">
                                        <div style="color: silver;;">L'article à été supprimé </div>
                                        <div>
                                            <a
                                                href="server/add-reading-list.php?article=<?php echo $get_id_article; ?>">Retirer
                                                de ma liste</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                } else {
                                    ?>
                                <div>
                                    Aucun article n'a été ajouté pour le moment!
                                </div>
                                <?php
                                }
                                ?>
                            </div>
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

</php>