<?php
// src/Controllers/AuthController.php

class AuthController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['mdp'];

            // Vérification des identifiants
            $stmt = $this->pdo->prepare(
                "SELECT idpatient, mdp, nom, prénom 
                 FROM patient 
                 WHERE email = ?"
            );
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['mdp'])) {
                // Création de la session utilisateur
                $_SESSION['user_id'] = $user['idpatient'];
                $_SESSION['user_name'] = $user['nom'] . ' ' . $user['prénom'];
                $_SESSION['message'] = "Connexion réussie !";

                header('Location: /dashboard');
                exit;
            } else {
                throw new Exception("Identifiants incorrects");
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /login');
            exit;
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            // Validation et nettoyage des données
            $data = $this->validateRegistrationData($_POST);

            // Vérification de l'unicité de l'email
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM patient WHERE email = ?");
            $stmt->execute([$data['email']]);

            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Cette adresse email est déjà utilisée");
            }

            // Insertion du nouvel utilisateur
            $sql = "INSERT INTO patient (nom, prénom, email, mdp, numerodesecuritesociale) 
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute([
                $data['nom'],
                $data['prenom'],
                $data['email'],
                password_hash($data['mdp'], PASSWORD_DEFAULT),
                $data['numero_securite']
            ]);

            if ($success) {
                $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header('Location: /login');
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /register');
            exit;
        }
    }

    private function validateRegistrationData($data)
    {
        $validated = [];

        // Validation du nom
        if (empty($data['nom'])) {
            throw new Exception("Le nom est requis");
        }
        $validated['nom'] = htmlspecialchars(trim($data['nom']));

        // Validation du prénom
        if (empty($data['prenom'])) {
            throw new Exception("Le prénom est requis");
        }
        $validated['prenom'] = htmlspecialchars(trim($data['prenom']));

        // Validation de l'email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide");
        }
        $validated['email'] = $data['email'];

        // Validation du numéro de sécurité sociale
        if (!preg_match('/^[12][0-9]{14}$/', $data['numero_securite'])) {
            throw new Exception("Format de numéro de sécurité sociale invalide");
        }
        $validated['numero_securite'] = $data['numero_securite'];

        // Validation du mot de passe
        if (strlen($data['mdp']) < 8) {
            throw new Exception("Le mot de passe doit contenir au moins 8 caractères");
        }
        $validated['mdp'] = $data['mdp'];

        return $validated;
    }
}
