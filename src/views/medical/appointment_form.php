<?php
// Activation du mode débug pour le développement
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session - crucial pour gérer les messages entre les pages
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulaire d'inscription Health North - Créez votre compte patient">
    <title>Inscription | Health North</title>
    <link href="/assets/css/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php $page = 'register'; ?>
    <?php require_once VIEW_PATH . '/layout/nav.php'; ?>

    <div class="form-container">
        <div class="form-box">
            <h1>Créez votre compte</h1>
            
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert">
                    <?= htmlspecialchars($_SESSION['message']) ?>
                    <?php unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="registration-form">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required 
                           value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required
                           value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required
                           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="numerodesecuritesociale">Numéro de sécurité sociale</label>
                    <input type="text" id="numerodesecuritesociale" name="numerodesecuritesociale" 
                           pattern="[12][0-9]{14}" required
                           title="Le numéro doit commencer par 1 ou 2 et contenir 15 chiffres"
                           value="<?= isset($_POST['numerodesecuritesociale']) ? htmlspecialchars($_POST['numerodesecuritesociale']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" required minlength="8"
                           title="Le mot de passe doit contenir au moins 8 caractères">
                </div>

                <button type="submit" class="submit-button">S'inscrire</button>
            </form>

            <div class="form-footer">
                <p>Déjà inscrit ? <a href="/login">Connectez-vous</a></p>
            </div>
        </div>
    </div>

    <?php require_once VIEW_PATH . '/layout/footer.php'; ?>
</body>
</html>