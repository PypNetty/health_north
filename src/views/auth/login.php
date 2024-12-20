<?php
$title = 'Connexion | Health North';
$meta_description = 'Connexion à Health North - Accédez à votre espace patient';
$page = 'login';

ob_start(); ?>

<h1>Connexion</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form action="/auth/login" method="POST" class="registration-form">
    <div class="form-group">
        <label for="email">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            required
            value="<?= isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : '' ?>"
        >
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required
        >
    </div>

    <button type="submit" class="submit-button">Se connecter</button>
</form>

<div class="form-footer">
    <p>Pas encore de compte ? <a href="/register">Inscrivez-vous</a></p>
    <p><a href="/password-reset">Mot de passe oublié ?</a></p>
</div>

<?php 
$content = ob_get_clean();
require_once VIEW_PATH . '/layout/auth_layout.php';
?>