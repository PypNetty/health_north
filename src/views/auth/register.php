<?php
$title = 'Inscription | Health North';
$meta_description = 'Inscription à Health North - Accédez à nos services médicaux';
$page = 'register';

ob_start(); ?>

<h1>Créez votre compte</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form action="/auth/register" method="POST" class="registration-form" id="registerForm">
    <div class="form-group">
        <label for="nom">Nom</label>
        <input 
            type="text" 
            id="nom" 
            name="nom" 
            required 
            minlength="2"
            maxlength="50"
            pattern="[A-Za-zÀ-ÿ\s-]+"
            title="Lettres, espaces et tirets uniquement"
            value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>"
        >
    </div>

    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input 
            type="text" 
            id="prenom" 
            name="prenom" 
            required
            minlength="2"
            maxlength="50"
            pattern="[A-Za-zÀ-ÿ\s-]+"
            title="Lettres, espaces et tirets uniquement"
            value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>"
        >
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            required
            maxlength="100"
            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
        >
    </div>

    <div class="form-group">
        <label for="secu">Numéro de sécurité sociale</label>
        <input 
            type="text" 
            id="secu" 
            name="secu" 
            required
            maxlength="21"
            placeholder="1 23 45 34 678 901 23"
            value="<?= isset($_SESSION['form_data']['secu']) ? htmlspecialchars($_SESSION['form_data']['secu']) : '' ?>"
        >
        <small class="form-help">Format : X XX XX XX XXX XXX XX (avec ou sans espaces)</small>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required
            minlength="8"
            pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$"
            title="8 caractères minimum, incluant lettres et chiffres"
        >
        <small class="form-help">8 caractères minimum, avec au moins une lettre et un chiffre</small>
    </div>

    <div class="form-group">
        <label for="password_confirm">Confirmez le mot de passe</label>
        <input 
            type="password" 
            id="password_confirm" 
            name="password_confirm" 
            required
        >
    </div>

    <button type="submit" class="submit-button">Créer mon compte</button>
</form>

<div class="form-footer">
    <p>Déjà inscrit ? <a href="/login">Connectez-vous</a></p>
</div>

<script src="/assets/js/register.js"></script>

<?php 
$content = ob_get_clean();
require_once VIEW_PATH . '/layout/auth_layout.php';
?>