<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['video']['title']) ?> | Futurflix</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">
</head>
<body class="video-detail-body">

    <?php require_once '../app/views/layout/header.php'; ?>

    <main class="video-view-main">
        <div class="video-view-container">
            
            <section class="video-player-section">
                <div class="video-player-wrapper">
                    <iframe 
                        src="https://www.youtube.com/embed/<?= $data['video']['youtube_id'] ?>?autoplay=1&rel=0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </section>

            <section class="video-details-section">
                <h1 class="video-main-title"><?= htmlspecialchars($data['video']['title']) ?></h1>
                
                <div class="video-info-bar">
                    <span class="age-badge"><?= htmlspecialchars($data['video']['age_rating'] ?? '12+') ?></span>
                    <span class="info-item"><?= htmlspecialchars($data['video']['release_year']) ?></span>
                    <span class="info-separator">|</span>
                    <span class="info-item"><?= htmlspecialchars($data['video']['genre']) ?></span>
                </div>

                <div class="video-description-container">
                    <h2 class="description-title">O čem to je?</h2>
                    <p class="description-text">
                        <?= nl2br(htmlspecialchars($data['video']['description'])) ?>
                    </p>
                </div>

                <div class="video-actions-footer">
                    <a href="<?= BASE_URL ?>/index.php" class="btn-back">
                        <span class="arrow">←</span> ZPĚT DO KNIHOVNY
                    </a>
                </div>
            </section>

        </div>
    </main>

    <?php require_once '../app/views/layout/footer.php'; ?>

</body>
</html>