<?php
// Paramètre de connexion
$server = "localhost";
$username = "root";
$password = "";
$database = "blogger";

// Connexion à la base de donnée
$connexion = new mysqli($server, $username, $password, $database);

// Verification de la connexion
if ($connexion->connect_error) {
    die("Echec de connexion : " . $connexion->connect_error);
}