<?php
// src/Controllers/MedicalController.php

class MedicalController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Affiche le formulaire de prise de rendez-vous
     * avec la liste des médecins et centres disponibles
     */
    public function showAppointmentForm()
    {
        try {
            // Récupération des centres médicaux
            $stmt = $this->pdo->query(
                "SELECT id_CabinetMedical, nom, adresse 
                 FROM cabinet_medical 
                 ORDER BY nom"
            );
            $centers = $stmt->fetchAll();

            // Récupération des médecins
            $stmt = $this->pdo->query(
                "SELECT id_personnel, nom, prénom, specialite 
                 FROM personnelmedical 
                 ORDER BY nom"
            );
            $doctors = $stmt->fetchAll();

            require ROOT_PATH . '/src/views/medical/appointment-form.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors du chargement du formulaire";
            header('Location: /dashboard');
            exit;
        }
    }

    /**
     * Traite la création d'un nouveau rendez-vous
     */
    public function createAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header('Location: /appointments');
            exit;
        }

        try {
            $data = $this->validateAppointmentData($_POST);

            // Vérification de la disponibilité du créneau
            if (!$this->isTimeSlotAvailable($data['date'], $data['doctor_id'])) {
                throw new Exception("Ce créneau n'est plus disponible");
            }

            $sql = "INSERT INTO rdv (id_patient, id_personnel, id_CabinetMedical, date, motif) 
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute([
                $_SESSION['user_id'],
                $data['doctor_id'],
                $data['center_id'],
                $data['date'],
                $data['motif']
            ]);

            if ($success) {
                $_SESSION['message'] = "Rendez-vous créé avec succès";
                header('Location: /dashboard');
            } else {
                throw new Exception("Erreur lors de la création du rendez-vous");
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /appointments');
        }
        exit;
    }

    /**
     * Affiche la liste des centres médicaux
     */
    public function listCenters()
    {
        try {
            $stmt = $this->pdo->query(
                "SELECT cm.*, 
                        COUNT(DISTINCT pm.id_personnel) as nombre_medecins,
                        GROUP_CONCAT(DISTINCT s.nom) as specialites
                 FROM cabinet_medical cm
                 LEFT JOIN personnelmedical pm ON pm.id_CabinetMedical = cm.id_CabinetMedical
                 LEFT JOIN specialite s ON s.id_specialite = pm.id_specialite
                 GROUP BY cm.id_CabinetMedical
                 ORDER BY cm.nom"
            );
            $centers = $stmt->fetchAll();

            require ROOT_PATH . '/src/views/medical/centers-list.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors du chargement des centres";
            header('Location: /dashboard');
            exit;
        }
    }

    /**
     * Vérifie si un créneau horaire est disponible
     */
    private function isTimeSlotAvailable($date, $doctorId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM rdv 
             WHERE id_personnel = ? 
             AND date = ? 
             AND statut != 'annulé'"
        );
        $stmt->execute([$doctorId, $date]);
        return $stmt->fetchColumn() === 0;
    }

    private function validateAppointmentData($data)
    {
        $validated = [];

        // Validation de la date
        $appointmentDate = strtotime($data['date']);
        $now = time();

        if ($appointmentDate < $now) {
            throw new Exception("La date doit être dans le futur");
        }
        $validated['date'] = $data['date'];

        // Validation des IDs
        foreach (['doctor_id', 'center_id'] as $field) {
            if (!isset($data[$field]) || !is_numeric($data[$field])) {
                throw new Exception("Données invalides");
            }
            $validated[$field] = (int)$data[$field];
        }

        // Validation du motif
        if (empty($data['motif'])) {
            throw new Exception("Le motif est obligatoire");
        }
        $validated['motif'] = htmlspecialchars(trim($data['motif']));

        return $validated;
    }
}
