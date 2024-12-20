<?php
session_start();



try {
    // Connexion à la base de données avec des options de sécurité renforcées
    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = $_POST['mdp'] ?? '';

        // Validation plus stricte de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide.");
        }

        if (empty($email) || empty($password)) {
            throw new Exception("L'email et le mot de passe sont obligatoires.");
        }

        // Ajout d'un délai pour prévenir les attaques par force brute
        usleep(random_int(100000, 300000)); // Délai aléatoire entre 0.1 et 0.3 secondes

        $stmt = $conn->prepare("SELECT idpatient, email, mdp FROM patient WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mdp'])) {
            // Régénération de l'ID de session pour prévenir la fixation de session
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user['idpatient'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['last_login'] = time();
            
            // Journal de connexion réussie
            error_log("Connexion réussie pour l'utilisateur: " . $email);
            
            header("Location: lien.php");
            exit();
        } else {
            // Journal de tentative échouée
            error_log("Tentative de connexion échouée pour l'email: " . $email);
            throw new Exception("Email ou mot de passe incorrect.");
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: login.php");
    exit();
}

// Redirection par défaut
header("Location: login.php");
exit();
?>