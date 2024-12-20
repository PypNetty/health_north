<?php
$title = 'Mon profil | Health North';
$meta_description = 'Gérez vos informations personnelles Health North';
$page = 'profile';

ob_start(); ?>

<div class="dashboard-container">
    <div class="dashboard-section">
        <h1>Mon Dossier Patient</h1>

        <div class="profile-grid">
            <div class="profile-info">
                <h2>Informations personnelles</h2>
                <div class="info-group">
                    <label>Nom</label>
                    <p><?= htmlspecialchars($user['nom']) ?></p>
                </div>
                <div class="info-group">
                    <label>Prénom</label>
                    <p><?= htmlspecialchars($user['prénom']) ?></p>
                </div>
                <div class="info-group">
                    <label>Date de naissance</label>
                    <p><?= htmlspecialchars($user['date_naissance'] ?? 'Non renseigné') ?></p>
                </div>
                <div class="info-group">
                    <label>Sexe</label>
                    <p><?= htmlspecialchars($user['sexe'] ?? 'Non renseigné') ?></p>
                </div>
            </div>

            <div class="profile-info">
                <h2>Coordonnées</h2>
                <div class="info-group">
                    <label>Adresse</label>
                    <p><?= htmlspecialchars($user['adresse'] ?? 'Non renseigné') ?></p>
                </div>
                <div class="info-group">
                    <label>Email</label>
                    <p><?= htmlspecialchars($user['email']) ?></p>
                </div>
                <div class="info-group">
                    <label>Téléphone</label>
                    <p><?= htmlspecialchars($user['telephone'] ?? 'Non renseigné') ?></p>
                </div>
                <div class="info-group">
                    <label>Numéro de sécurité sociale</label>
                    <p><?= htmlspecialchars($user['numerodesecuritesociale']) ?></p>
                </div>
            </div>

            <div class="profile-info">
                <h2>Informations médicales</h2>
                <div class="info-group">
                    <label>Médecin traitant</label>
                    <p><?= htmlspecialchars($user['medecin_traitant'] ?? 'Non renseigné') ?></p>
                </div>
                <div class="info-group">
                    <label>Personne à contacter</label>
                    <p><?= htmlspecialchars($user['contact_urgence'] ?? 'Non renseigné') ?></p>
                </div>
                <div class="info-group">
                    <label>Observations (Allergies, etc.)</label>
                    <p><?= htmlspecialchars($user['observations'] ?? 'Aucune observation') ?></p>
                </div>
            </div>
        </div>

        <div class="profile-actions">
            <a href="/profile/edit" class="btn-primary">Modifier mes informations</a>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
require_once VIEW_PATH . '/layout/auth_layout.php';
?> 