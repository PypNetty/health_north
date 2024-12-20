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
    <link href="styles.css" rel="stylesheet">
    <title>Formulaire d'inscription Health North</title>
</head>
<body>
    <div class="container">
        <h2>Formulaire d'inscription Health North</h2>
        
        <?php
        // Affichage des messages stockés en session avec nettoyage XSS
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . htmlspecialchars($_SESSION['message']) . "</div>";
            unset($_SESSION['message']); // On nettoie le message après affichage
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required 
                       value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required
                       value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required
                       value="<?php echo isset($_POST['login']) ? htmlspecialchars($_POST['login']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="numerodesecuritesociale">Numéro de sécurité sociale</label>
                <input type="text" id="numerodesecuritesociale" name="numerodesecuritesociale" 
                       pattern="[12][0-9]{14}" required
                       title="Le numéro doit commencer par 1 ou 2 et contenir 15 chiffres"
                       value="<?php echo isset($_POST['numerodesecuritesociale']) ? htmlspecialchars($_POST['numerodesecuritesociale']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp" required minlength="8"
                       title="Le mot de passe doit contenir au moins 8 caractères">
            </div>

            <button type="submit" class="btn-submit">S'inscrire</button>
        </form>
    </div>

<?php
// Traitement du formulaire uniquement lors d'une soumission POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Configuration de la base de données
        $servername = "localhost";
        $username = "root";
        $password = "Lavoisier1";
        $dbname = "health_north";

        // Établissement de la connexion avec gestion des erreurs
        $conn = new PDO(
            "mysql:host=$servername;dbname=$dbname;charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

        // Nettoyage et validation des données avec la méthode moderne (sans FILTER_SANITIZE_STRING)
        $nom = htmlspecialchars(trim($_POST['nom']));
        $prenom = htmlspecialchars(trim($_POST['prenom']));
        $login = htmlspecialchars(trim($_POST['login']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $numerodesecuritesociale = htmlspecialchars(trim($_POST['numerodesecuritesociale']));
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

        // Validation supplémentaire de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide");
        }

        // Vérification de l'unicité de l'email
        $stmt = $conn->prepare("SELECT email FROM patient WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            throw new Exception("Cette adresse email est déjà utilisée");
        }

        // Préparation de la requête avec le nom exact de la colonne (notez le `prénom` avec accent)
        $sql = "INSERT INTO patient (nom, `prénom`, login, mdp, email, numerodesecuritesociale) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Exécution de la requête avec les valeurs nettoyées
        $success = $stmt->execute([
            $nom,
            $prenom,
            $login,
            $mdp,
            $email,
            $numerodesecuritesociale
        ]);

        // Gestion du résultat
        if ($success) {
            $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header("Location: login.php");
            exit();
        } else {
            throw new Exception("Erreur lors de l'insertion dans la base de données");
        }

    } catch (Exception $e) {
        // Gestion des erreurs avec log et affichage sécurisé
        echo "<div class='error'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
        error_log("Erreur d'inscription : " . $e->getMessage());
    }
}
?>
</body>
</html>