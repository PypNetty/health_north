<?php
// Démarrage de la session et inclusion des dépendances
session_start();

// Inclusion du header commun qui contient la navigation
require_once __DIR__ . '/../layout/header.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Notez le chemin mis à jour vers le CSS -->
    <link href="/assets/css/styles.css" rel="stylesheet">
    <title>Connexion - Health North</title>
</head>

<body>
    <div class="container">
        <!-- Messages de succès/erreur avec une meilleure présentation -->
        <?php if (isset($_SESSION['message']) || isset($_SESSION['error'])): ?>
            <div class="message-container">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="message success">
                        <?php
                        echo htmlspecialchars($_SESSION['message']);
                        unset($_SESSION['message']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="message error">
                        <?php
                        echo htmlspecialchars($_SESSION['error']);
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="login-form-container">
            <h2>Connexion à Health North</h2>

            <!-- Le formulaire pointe maintenant vers le contrôleur d'authentification -->
            <form action="/auth/login" method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input
                        type="password"
                        id="mdp"
                        name="mdp"
                        required
                        minlength="8"
                        class="form-control">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Se connecter</button>
                </div>
            </form>

            <div class="form-links">
                <a href="/auth/register" class="register-link">Pas encore inscrit ? Créer un compte</a>
                <a href="/auth/reset-password" class="forgot-password-link">Mot de passe oublié ?</a>
            </div>
        </div>
    </div>

    <!-- Inclusion du footer commun -->
    <?php require_once __DIR__ . '/../layout/footer.php'; ?>
</body>

</html>