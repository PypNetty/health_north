<?php

class User
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare("SELECT * FROM patient WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO patient (idpatient, nom, prénom, email, mdp, numerodesecuritesociale, login) 
                VALUES (NULL, ?, ?, ?, ?, ?, ?)";
        
        $login = strtolower($data['prenom'] . '.' . $data['nom']);
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['password'],
            $data['secu'],
            $login
        ]);
    }

    public function validatePassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
