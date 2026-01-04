<?php
require('./server/connexion.php');

session_start();

function valid_donnees($data)
{
    $donnees = trim(htmlspecialchars($data));
    return $donnees;
}

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
    } else {
        $is_logged = false;
    }
} else {
    $is_logged = false;
}

$query_articles = "SELECT * FROM articles ORDER BY id DESC";
$resultat_query_articles = $connexion->query($query_articles);

$recherche = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($recherche)) {
    $query_articles = "SELECT * FROM articles WHERE titre LIKE '%$recherche%' OR FIND_IN_SET('$recherche', tag) > 0 OR description LIKE '%$recherche%' ORDER BY id DESC";
    $resultat_query_articles = $connexion->query($query_articles);
}
?>
<!DOCTYPE php>
<php lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="./assets/icon.png" type="image/png">
        <title>Accueil</title>
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
                        <div class="search-content">
                            <form class="search">
                                <input type="search" name="search" placeholder="Recherche un terme"
                                    value="<?php echo (!empty($recherche)) ? valid_donnees($recherche) : "" ?>">
                                <div class="btn">
                                    <!-- ICON RECUPERER SUR BOOTSTRAP EN BRUT -->
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="container-blog-header">
                            <h1>Article que vous pourriez aimer</h1>
                        </div>

                        <div class="container-list-blog">
                            <div class="list-blog">
                                <?php
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
                                        <span
                                            style="color: gray;"><?php echo formatterDate($article['created_at']); ?></span>
                                    </div>
                                </div>
                                <?php
                                    }
                                } else {
                                    ?>
                                <div>
                                    <span><?php echo (!empty($recherche)) ? "Aucun articles n'a éte trouvé" : "Aucun articles n'a éte publié" ?></span>
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