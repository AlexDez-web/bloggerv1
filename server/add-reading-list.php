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

$id = intval($_SESSION['id']);
$id_article = valid_donnees($_GET['article']);

$req_verif_if_exist = "SELECT * FROM listes where id_user = '$id' AND id_article = '$id_article'";
$resultat = $connexion->query($req_verif_if_exist);

if (isset($_SERVER['HTTP_REFERER'])) {
    $urlPagePrecedente = $_SERVER['HTTP_REFERER'];
} else {
    $urlPagePrecedente = "../article.php?article=" . $id_article;
}

if ($resultat->num_rows > 0) {
    // EXIST ALORS RETIRER
    $get_row = $resultat->fetch_assoc();
    $id_liste_item = $get_row['id'];

    $req_delete = "DELETE FROM listes WHERE id = '$id_liste_item'";
    $stmt = $connexion->prepare($req_delete);

    // Vérification de la préparation de la requête
    if ($stmt === false) {
        $connexion->close();
        header('Location: ' . $urlPagePrecedente);
        exit;
    } else {
        // Exécution de la requête
        if ($stmt->execute()) {
            header('Location: ' . $urlPagePrecedente);
        } else {
            header('Location: ' . $urlPagePrecedente);
        }
        // Fermez la connexion lorsque vous avez terminé
        $stmt->close();
        $connexion->close();
        exit;
    }
} else {
    // N'EXISTE PAS ALORS AJOUTER
    $req_save = "INSERT INTO listes (id_user, id_article) VALUES ('$id', '$id_article')";
    $stmt = $connexion->prepare($req_save);

    // Vérification de la préparation de la requête
    if ($stmt === false) {
        $connexion->close();
        header('Location: ' . $urlPagePrecedente);
        exit;
    } else {
        // Exécution de la requête
        if ($stmt->execute()) {
            header('Location: ' . $urlPagePrecedente);
        } else {
            header('Location: ' . $urlPagePrecedente);
        }
        // Fermez la connexion lorsque vous avez terminé
        $stmt->close();
        $connexion->close();
        exit;
    }
}
