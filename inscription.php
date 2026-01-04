<!DOCTYPE php>
<php lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="./assets/icon.png" type="image/png">
        <title>S'enregistrer</title>
        <link rel="stylesheet" href="./assets/styles.css">
    </head>

    <body>
        <main>
            <header>
                <div class="logo">
                    <a href="index.php">BLOGGER</a>
                </div>
                <nav>
                    <ul>
                        <li><a href="login.php">Connexion</a></li>
                        <li><a href="inscription.php">Inscription</a></li>
                    </ul>
                </nav>
            </header>

            <section class="container">
                <div>
                    <form action="server/register.php" method="post">
                        <div>
                            <h2>S'enregistrer</h2>

                            <div class="col-input">
                                <div class="form-control">
                                    <label for="nom">Nom</label> <br>
                                    <input type="text" name="nom" placeholder="Nom"> <br>
                                </div>

                                <div class="form-control">
                                    <label for="prenom">Prénom</label> <br>
                                    <input type="text" name="prenom" placeholder="Prenom"> <br>
                                </div>
                            </div>

                            <div>
                                <div class="form-control">
                                    <label for="email">Email <span class="required">*</span></label> <br>
                                    <input type="email" name="email" placeholder="Email" required> <br>
                                </div>
                            </div>

                            <div class="col-input">
                                <div class="form-control">
                                    <label for="password">Mot de passe <span class="required">*</span></label> <br>
                                    <input type="password" name="password" placeholder="Mot de passe" required> <br>
                                </div>

                                <div class="form-control">
                                    <label for="confirm_password">Confirmation du mot de passe <span
                                            class="required">*</span></label> <br>
                                    <input type="password" name="confirm_password" placeholder="Mot de passe" required>
                                    <br>
                                </div>
                            </div>

                            <div class="submit">
                                <div class="form-control">
                                    <button type="submit">Soumettre</button>
                                </div>
                            </div>

                            <div class="auth">
                                <span>Vous avez déjà un compte? <a href="login.php">Se connecter</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <hr>
            <footer>
                <div class="logo">
                    <a href="index.php">BLOGGER</a>
                </div>

                <div>
                    &nbsp;Copyright © 2023 My blog M.B Tous droits réservés.
                </div>
            </footer>
        </main>
    </body>

</php>