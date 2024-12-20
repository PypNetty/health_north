<?php
$title = 'Tableau de bord | Health North';
$meta_description = 'Votre espace patient Health North';
$page = 'dashboard';

ob_start(); ?>

<h1>Bienvenue <?= htmlspecialchars($_SESSION['user_name']) ?></h1>

<div class="dashboard-container">
    <div class="dashboard-section">
        <h2>Vos prochains rendez-vous</h2>
        <?php if (empty($appointments)): ?>
            <p>Aucun rendez-vous prévu.</p>
            <a href="/appointment" class="btn-primary">Prendre un rendez-vous</a>
        <?php else: ?>
            <!-- Liste des rendez-vous à implémenter -->
        <?php endif; ?>
    </div>

    <div class="dashboard-section">
        <h2>Actions rapides</h2>
        <div class="quick-actions">
            <a href="/appointment" class="action-card">
                <h3>Nouveau rendez-vous</h3>
                <p>Prenez rendez-vous avec un professionnel</p>
            </a>
            <a href="/profile" class="action-card">
                <h3>Mon profil</h3>
                <p>Gérez vos informations personnelles</p>
            </a>
            <a href="/history" class="action-card">
                <h3>Historique</h3>
                <p>Consultez vos rendez-vous passés</p>
            </a>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
require_once VIEW_PATH . '/layout/auth_layout.php';
?> 