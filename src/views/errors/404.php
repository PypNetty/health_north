<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée | Health North</title>
    <link href="/assets/css/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php $page = '404'; ?>
    <?php require_once VIEW_PATH . '/layout/nav.php'; ?>

    <div class="error-container">
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Page non trouvée</h2>
        <p class="error-description">
            Désolé, la page que vous recherchez semble avoir disparu.<br>
            Peut-être a-t-elle été déplacée ou supprimée.
        </p>
        <a href="/" class="home-button">Retour à l'accueil</a>
    </div>

    <?php require_once VIEW_PATH . '/layout/footer.php'; ?>
</body>

</html>