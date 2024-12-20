<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php'; ?>

    <h2>Contact</h2>

    <form action="action.php" method="post">
        <label for="Nom">Nom:</label>
        <input name="Nom" id="Nom" type="text">

        <label for="date_naissance" aria-label="Date de naissance">Date de naissance:</label>
        <input name="date_naissance" id="date_naissance" type="date" required>

        <label for="email" aria-label="Adresse email">Email:</label>
        <input name="email" id="email" type="email" required>

        <label for="sujet" aria-label="Sujet du message">Sujet:</label>
        <input name="sujet" id="sujet" type="text" required>

        <label for="Message" aria-label="Message">Message:</label>
        <textarea name="Message" id="Message" rows="4" required></textarea>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <?php include 'footer.php'; ?>
</body>

</html>