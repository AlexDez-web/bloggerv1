<!DOCTYPE php>
<php lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="./assets/icon.png" type="image/png">
        <title>Se connecter</title>
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
                    <form action="server/login.php" method="post">
                        <div>
                            <h2>Se connecter</h2>

                            <div>
                                <div class="form-control">
                                    <label for="email">Email <span class="required">*</span></label> <br>
                                    <input type="email" name="email" placeholder="Email" required> <br>
                                </div>

                                <div class="form-control">
                                    <label for="password">Mot de passe <span class="required">*</span></label> <br>
                                    <input type="password" name="password" placeholder="Mot de passe" required>
                                    <br>
                                </div>
                            </div>

                            <div class="submit">
                                <div class="form-control">
                                    <button type="submit">Soumettre</button>
                                </div>
                            </div>

                            <div class="auth">
                                <span>Vous n'avez pas de compte? <a href="inscription.php">S'enregistrer</a></span>
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
                    Copyright © 2023 My blog M.B Tous droits réservés.
                </div>
            </footer>
        </main>
    </body>

</php>