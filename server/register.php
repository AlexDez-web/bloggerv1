<?php
require('../server/connexion.php');

function valid_donnees($data)
{
    $supprimer_espace_donnees = trim($data);
    $supprimer_code_dans_donnees = htmlspecialchars($supprimer_espace_donnees);
    return $supprimer_code_dans_donnees;
}

$nom = valid_donnees($_POST['nom']);
$prenom = valid_donnees($_POST['prenom']);
$email = valid_donnees($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$req_verif_if_exist = "SELECT * FROM users where email = '$email'";

$resultat = $connexion->query($req_verif_if_exist);

if (!($resultat->num_rows > 0)) {
    // AUCUN USER N'EXISTE
    if (
        isset($email) && !empty($email) &&
        isset($password) && !empty($password) &&
        isset($confirm_password) && !empty($confirm_password) &&
        $password === $confirm_password
    ) {
        $req_insert = "INSERT INTO users (nom, prenom, email, mdp) VALUES ('$nom', '$prenom', '$email', '$password')";
        $stmt = $connexion->prepare($req_insert);

        // Vérification de la préparation de la requête
        if ($stmt === false) {
            $connexion->close();
            header('Location: ../inscription.php?error=3');
            exit;
        } else {
            // Exécution de la requête
            if ($stmt->execute()) {
                header('Location: ../login.php');
            } else {
                header('Location: ../inscription.php?error=4');
            }
            // Fermez la connexion lorsque vous avez terminé
            $stmt->close();
            $connexion->close();
            exit;
        }
    } else {
        //USER EXISTS
        $connexion->close();
        header('Location: ../inscription.php?error=2');
        exit;
    }
} else {
    //USER EXISTS
    $connexion->close();
    header('Location: ../inscription.php?error=1');
    exit;
}