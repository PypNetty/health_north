<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $meta_description ?? 'Health North - Votre santé, notre priorité' ?>">
    <title><?= $title ?? 'Health North' ?></title>
    <link href="/assets/css/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php require_once VIEW_PATH . '/layout/nav.php'; ?>

    <div class="form-container">
        <div class="form-box">
            <?= $content ?>
        </div>
    </div>

    <?php require_once VIEW_PATH . '/layout/footer.php'; ?>
</body>
</html> 