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
$req_user = "SELECT * FROM users WHERE id = '$id'";
$resultat_user = $connexion->query($req_user);
$user_data = [];

if ($resultat_user->num_rows > 0) {
    $user_data = $resultat_user->fetch_assoc();
}

$nom = valid_donnees($_POST['nom']);
$prenom = valid_donnees($_POST['prenom']);

$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if (isset($nom) && !empty($nom) && isset($prenom) && !empty($prenom) && isset($password) && !empty($password) && isset($confirm_password) && !empty($confirm_password) && $password === $confirm_password) {
    $req_update = "UPDATE users SET nom = '$nom', prenom = '$prenom', mdp = '$password' WHERE id = '$id'";
    $stmt = $connexion->prepare($req_update);
} else if (isset($nom) && !empty($nom) && isset($prenom) && !empty($prenom) && empty($password) && empty($confirm_password)) {
    $req_update = "UPDATE users SET nom = '$nom', prenom = '$prenom' WHERE id = '$id'";
    $stmt = $connexion->prepare($req_update);
} else if (isset($confirm_password) && !empty($confirm_password) && $password === $confirm_password) {
    $req_update = "UPDATE users SET mdp = '$password' WHERE id = '$id'";
    $stmt = $connexion->prepare($req_update);
} else {
    header('Location: ../modifier-profile.php?error=1');
    exit;
}

// Vérification de la préparation de la requête
if ($stmt === false) {
    $connexion->close();
    header('Location: ../modifier-profile.php?error=3');
    exit;
} else {
    // Exécution de la requête
    if ($stmt->execute()) {
        header('Location: ../profile.php');
    } else {
        header('Location: ../modifier-profile.php?error=2');
    }
    // Fermez la connexion lorsque vous avez terminé
    $stmt->close();
    $connexion->close();
    exit;
}
