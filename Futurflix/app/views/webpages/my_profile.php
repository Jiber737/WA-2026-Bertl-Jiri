<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Futurflix - Můj profil</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="hero-banner profile-banner">
            <div class="hero-content profile-content">
                <span class="hero-badge profile-badge">
                    <?= (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) ? 'ADMINISTRÁTOR' : 'UŽIVATELSKÝ PROFIL' ?>
                </span>
                
                <h1>Ahoj, <?= htmlspecialchars($user['nickname'] ?: $user['username']) ?>!</h1>
                
                <div class="profile-info-box">
                    <p><strong>Uživatelské jméno:</strong> <span class="profile-info-val"><?= htmlspecialchars($user['username']) ?></span></p>
                    <p><strong>Registrační E-mail:</strong> <span class="profile-info-val"><?= htmlspecialchars($user['email']) ?></span></p>
                    <?php if (!empty($user['first_name']) || !empty($user['last_name'])): ?>
                        <p><strong>Celé jméno:</strong> <span class="profile-info-val"><?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></span></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <h2 class="section-title">
            Moje nahraná videa (<?= count($videos) ?>)
        </h2>

        <section class="video-grid">
            <?php if (empty($videos)): ?>
                <p class="profile-empty-text">
                    Zatím jsi nenahrál žádné video. 
                    <a href="<?= BASE_URL ?>/index.php?url=video/create" class="profile-empty-link">Přidej své první video zde ▷</a>
                </p>
            <?php else: ?>
                <?php foreach ($videos as $video): ?>
                    <div class="video-card">
                        
                        <div class="card-actions">
                            <a href="<?= BASE_URL ?>/index.php?url=video/edit/<?= $video['id'] ?>" class="action-btn edit-btn" title="Upravit">✎</a>
                            <a href="<?= BASE_URL ?>/index.php?url=video/delete/<?= $video['id'] ?>" class="action-btn delete-btn" title="Smazat" onclick="return confirm('Opravdu smazat toto video?')">✖</a>
                        </div>

                        <a href="<?= BASE_URL ?>/index.php?url=video/show/<?= $video['id'] ?>" style="text-decoration: none; color: inherit;">
                            <div class="video-thumbnail">
                                <?php if(!empty($video['image'])): ?>
                                    <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($video['image']) ?>" alt="Thumbnail">
                                <?php else: ?>
                                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: #444; font-family: 'BurbankBigCity';">FUTURFLIX</div>
                                <?php endif; ?>
                            </div>

                            <div class="video-info">
                                <h3><?= htmlspecialchars($video['title']) ?></h3>
                                <div class="video-details">
                                    <span class="age-tag"><?= htmlspecialchars($video['age_rating'] ?? '12+') ?></span>
                                    <span><?= htmlspecialchars($video['genre'] ?? 'Film') ?></span>
                                    <span>•</span>
                                    <span><?= htmlspecialchars($video['release_year']) ?></span>
                                </div>
                                <div style="margin-top: 10px; color: var(--flix-red); font-weight: bold; font-size: 0.8rem;">
                                    PŘEHRÁT ▷
                                </div>
                            </div>
                        </a>
                        
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>