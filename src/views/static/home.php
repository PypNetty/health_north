<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Health North - Plateforme de prise de rendez-vous médicaux dans les Hauts-de-France">
    <title>Health North - Votre santé, notre priorité</title>
    
    <!-- Préchargement des ressources critiques pour de meilleures performances -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <link href="/assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php $page = 'home'; ?>
    <?php require_once VIEW_PATH . '/layout/nav.php'; ?>

    <!-- En-tête avec image de fond -->
    <header class="header-container">
        <picture>
            <source srcset="/assets/images/clinique_exterieur.jpeg" media="(min-width: 1200px)">
            <
            <img 
                src="/assets/images/clinique_exterieur.jpeg" 
                class="header-image" 
                alt="Accueil de la clinique Health North"
                width="1920"
                height="1080"
                loading="eager"
            >
        </picture>
        <div class="header-overlay"></div>
        <h1 class="main-title">Bienvenue à Health North</h1>
    </header>

    <main class="container">
        <!-- Section présentation -->
        <section class="section introduction">
            <p class="lead-text">
                Depuis 1920, Health North révolutionne la prise de rendez-vous dans toute la région Hauts-de-France.
                Notre plateforme innovante connecte les patients avec plus de 500 professionnels de santé et 75 centres médicaux.
            </p>

            <!-- Caractéristiques principales -->
            <div class="features-grid">
                <div class="feature-item">
                    <h2>Prise de RDV simplifiée</h2>
                    <p>Réservez en quelques clics 24h/24 7j/7. Plus d'attente téléphonique.</p>
                </div>
                <div class="feature-item">
                    <h2>Large réseau médical</h2>
                    <p>Un réseau complet de professionnels pour des soins optimaux.</p>
                </div>
                <div class="feature-item">
                    <h2>Rappels automatiques</h2>
                    <p>Ne manquez plus jamais un rendez-vous grâce à nos notifications.</p>
                </div>
            </div>
        </section>

        <!-- Section statistiques -->
        <section class="section statistics">
            <h2>HEALTH NORTH EN CHIFFRES</h2>
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div>professionnels de santé</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">75</div>
                    <div>centres médicaux</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100k+</div>
                    <div>patients satisfaits</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1M+</div>
                    <div>rendez-vous pris</div>
                </div>
            </div>
        </section>

        <!-- Section centres partenaires -->
        <section class="section partners">
            <h2>Nos centres partenaires</h2>
            <div class="centers-grid">
                <div class="center-card">
                    <h3>Centre Médical St Jean</h3>
                    <p>Lille - Centre ville</p>
                </div>
                <div class="center-card">
                    <h3>Clinique du Parc</h3>
                    <p>Roubaix</p>
                </div>
                <div class="center-card">
                    <h3>Hôpital central</h3>
                    <p>Valenciennes</p>
                </div>
                <div class="center-card">
                    <h3>Cabinet d'imagerie</h3>
                    <p>Dunkerque</p>
                </div>
            </div>
        </section>
    </main>

    <?php require_once VIEW_PATH . '/layout/footer.php'; ?>
</body>
</html>