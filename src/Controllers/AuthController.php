<?php
// src/Controllers/AuthController.php

require_once __DIR__ . '/../Models/User.php';

class AuthController
{
    private $user;

    public function __construct(PDO $pdo)
    {
        $this->user = new User($pdo);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            // Utilisation du modèle User pour trouver l'utilisateur
            $user = $this->user->findByEmail($email);

            if ($user && $this->user->validatePassword($password, $user['mdp'])) {
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
            $_SESSION['form_data'] = ['email' => $email];
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
            // Nettoyage et validation des données
            $data = [
                'nom' => htmlspecialchars(trim($_POST['nom'])),
                'prenom' => htmlspecialchars(trim($_POST['prenom'])),
                'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
                'secu' => preg_replace('/\s+/', '', $_POST['secu']),
                'password' => $_POST['password'],
                'password_confirm' => $_POST['password_confirm']
            ];

            $this->validateRegistrationData($data);

            // Formatage du numéro de sécu
            $data['secu'] = preg_replace(
                '/(\d{1})(\d{2})(\d{2})(\d{2})(\d{3})(\d{3})(\d{2})/',
                '$1 $2 $3 $4 $5 $6 $7',
                $data['secu']
            );

            // Hashage du mot de passe
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Création de l'utilisateur
            if ($this->user->create($data)) {
                $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header("Location: /login");
                exit;
            }

            throw new Exception("Erreur lors de l'inscription");

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $_SESSION['form_data'] = $_POST;
            header("Location: /register");
            exit;
        }
    }

    private function validateRegistrationData(array $data)
    {
        // Validation du numéro de sécu
        if (!preg_match('/^[12]\d{14}$/', $data['secu'])) {
            throw new Exception("Format du numéro de sécurité sociale invalide");
        }

        // Validation du mot de passe
        if ($data['password'] !== $data['password_confirm']) {
            throw new Exception("Les mots de passe ne correspondent pas");
        }

        if (strlen($data['password']) < 8) {
            throw new Exception("Le mot de passe doit contenir au moins 8 caractères");
        }

        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/', $data['password'])) {
            throw new Exception("Le mot de passe doit contenir au moins une lettre et un chiffre");
        }

        // Validation de l'email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide");
        }

        // Vérification de l'unicité de l'email
        if ($this->user->findByEmail($data['email'])) {
            throw new Exception("Cette adresse email est déjà utilisée");
        }
    }
}
