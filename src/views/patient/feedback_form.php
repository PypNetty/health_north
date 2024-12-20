<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <title>Formulaire avec Avis</title>
</head>
<body>
    <form action="traitement.php" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="avis">Votre avis:</label><br>
        <textarea id="avis" name="avis" rows="5" cols="30" required></textarea><br><br>

        <input type="submit" value="Envoyer">
    </form>
</body>
</html>

