<?php

namespace App\Models;

class Patient
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function emailExists($email)
    {
        $stmt = $this->db->prepare("SELECT idpatient FROM patient WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->rowCount() > 0;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO patient (nom, `prénom`, login, mdp, email, numerodesecuritesociale)
             VALUES (:nom, :prenom, :login, :mdp, :email, :numero_securite)"
        );

        return $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':login' => $data['login'],
            ':mdp' => $data['mdp'],
            ':email' => $data['email'],
            ':numero_securite' => $data['numero_securite']
        ]);
    }
}
