<?php
require('../server/connexion.php');

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$req_verif_if_exist = "SELECT * FROM users where email = '$email'";

$resultat = $connexion->query($req_verif_if_exist);

if ($resultat->num_rows > 0) {
    // USER N'EXISTE
    $row_password = $resultat->fetch_assoc();

    if ($password === $row_password['mdp']) {
        $_SESSION['id'] = $row_password['id'];
        $connexion->close();
        header('Location: ../index.php');
        exit;
    } else {
        //MOT DE PASSE INCORRECTE
        $connexion->close();
        header('Location: ../login.php?error=2');
        exit;
    }
} else {
    //USER NO EXISTS
    $connexion->close();
    header('Location: ../login.php?error=1');
    exit;
}