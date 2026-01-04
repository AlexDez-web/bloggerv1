<?php
session_start(); // Démarrez la session si elle n'est pas déjà démarrée

// Détruisez la session (déconnexion de l'utilisateur)
session_destroy();

// Redirigez l'utilisateur vers une page de connexion ou une autre page de votre choix
header("Location: ../login.php");
exit; // Assurez-vous de quitter le script après la redirection