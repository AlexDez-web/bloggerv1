<?php
require('../server/connexion.php');
require('../vendor/autoload.php');

use Michelf\Markdown;

session_start();

function valid_donnees($data)
{
    $donnees = trim(htmlspecialchars($data));
    return $donnees;
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

if (!$is_logged) {
    header("Location: ../login.php");
    exit;
}

$id_user = intval($_SESSION['id']);
$id_article = intval(valid_donnees($_POST['id_article']));
$titre = valid_donnees($_POST['titre']);
$description_brut = valid_donnees($_POST['description']);
$description_html = Markdown::defaultTransform($description_brut);
$url = valid_donnees($_POST['url']);
$keyword = valid_donnees($_POST['keyword']);

$query_article = "SELECT * FROM articles WHERE id = '$id_article'";
$resultat_query_article = $connexion->query($query_article);

if (!($resultat_query_article->num_rows > 0)) {
    header("Location: ../index.php");
    exit;
} else {
    $article = $resultat_query_article->fetch_assoc();

    $id_user_article = $article["id_user"];

    if (intval($id_user_article) !== intval($_SESSION['id'])) {
        header("Location: ../index.php");
        exit;
    }
}

if (
    isset($titre) && !empty($titre) && isset($description_brut) && !empty($description_brut)
) {
    $req_update = "UPDATE articles SET titre = '$titre', description = '$description_brut', description_html = '$description_html', couverture = '$url', tag = '$keyword'  WHERE id = '$id_article'";
    $stmt = $connexion->prepare($req_update);

    // Vérification de la préparation de la requête
    if ($stmt === false) {
        $connexion->close();
        header('Location: ../modifier-article.php?error=3');
        exit;
    } else {
        // Exécution de la requête
        if ($stmt->execute()) {
            header('Location: ../article.php?article=' . $id_article);
        } else {
            header('Location: ../modifier-article.php?error=2');
        }
        // Fermez la connexion lorsque vous avez terminé
        $stmt->close();
        $connexion->close();
        exit;
    }
} else {
    $connexion->close();
    header('Location: ../modifier-article.php?error=1');
    exit;
}
