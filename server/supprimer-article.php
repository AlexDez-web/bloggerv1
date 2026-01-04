<?php
require('../server/connexion.php');

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
$id_article = intval(valid_donnees($_GET['article']));

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

$req_update = "DELETE FROM articles WHERE id = '$id_article'";
$stmt = $connexion->prepare($req_update);

// Vérification de la préparation de la requête
if ($stmt === false) {
    $connexion->close();
    header('Location: ../article.php?article=' . $id_article);
    exit;
} else {
    // Exécution de la requête
    if ($stmt->execute()) {
        header('Location: ../profile.php');
    } else {
        header('Location: ../article.php?article=' . $id_article);
    }
    // Fermez la connexion lorsque vous avez terminé
    $stmt->close();
    $connexion->close();
    exit;
}
