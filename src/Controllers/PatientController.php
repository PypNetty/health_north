<?php
// src/Controllers/PatientController.php

class PatientController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Affiche le profil du patient
     * Cette méthode vérifie d'abord l'authentification
     */
    public function showProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Veuillez vous connecter pour accéder à votre profil";
            header('Location: /login');
            exit;
        }

        try {
            // Récupération des informations du patient
            $stmt = $this->pdo->prepare(
                "SELECT nom, prénom, email, numerodesecuritesociale 
                 FROM patient 
                 WHERE idpatient = ?"
            );
            $stmt->execute([$_SESSION['user_id']]);
            $patient = $stmt->fetch();

            // Récupération des rendez-vous du patient
            $stmt = $this->pdo->prepare(
                "SELECT r.date, m.nom as medecin_nom, cm.nom as cabinet_nom
                 FROM rdv r
                 JOIN personnelmedical m ON r.id_personnel = m.id_personnel
                 JOIN cabinet_medical cm ON r.id_CabinetMedical = cm.id_CabinetMedical
                 WHERE r.id_patient = ?
                 ORDER BY r.date DESC"
            );
            $stmt->execute([$_SESSION['user_id']]);
            $appointments = $stmt->fetchAll();

            // Les données seront accessibles dans la vue
            require ROOT_PATH . '/src/views/patient/profile.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors du chargement du profil";
            header('Location: /dashboard');
            exit;
        }
    }

    /**
     * Met à jour les informations du patient
     * Accessible uniquement via POST et pour les utilisateurs authentifiés
     */
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header('Location: /profile');
            exit;
        }

        try {
            $data = $this->validateProfileData($_POST);

            $sql = "UPDATE patient 
                    SET email = ?, nom = ?, prénom = ? 
                    WHERE idpatient = ?";

            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute([
                $data['email'],
                $data['nom'],
                $data['prenom'],
                $_SESSION['user_id']
            ]);

            if ($success) {
                $_SESSION['message'] = "Profil mis à jour avec succès";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /profile');
        exit;
    }

    /**
     * Gère la soumission des retours patients
     */
    public function submitFeedback()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header('Location: /feedback');
            exit;
        }

        try {
            // Validation du feedback
            if (empty($_POST['avis']) || strlen($_POST['avis']) < 10) {
                throw new Exception("Le feedback doit contenir au moins 10 caractères");
            }

            $sql = "INSERT INTO feedback (id_patient, contenu, date_creation) 
                    VALUES (?, ?, NOW())";

            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute([
                $_SESSION['user_id'],
                htmlspecialchars($_POST['avis'])
            ]);

            if ($success) {
                $_SESSION['message'] = "Merci pour votre retour !";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /feedback');
        exit;
    }

    private function validateProfileData($data)
    {
        $validated = [];

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide");
        }
        $validated['email'] = $data['email'];

        foreach (['nom', 'prenom'] as $field) {
            if (empty($data[$field]) || strlen($data[$field]) < 2) {
                throw new Exception("Le $field doit contenir au moins 2 caractères");
            }
            $validated[$field] = htmlspecialchars(trim($data[$field]));
        }

        return $validated;
    }
}
