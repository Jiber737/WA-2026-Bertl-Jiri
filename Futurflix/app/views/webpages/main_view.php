<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Futurflix - Videa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="hero-banner">
            <div class="hero-content">
                <span class="hero-badge">PREMIÉRA</span>
                <h1>FUTURFLIX ORIGINALS</h1>
                <p>Sleduj nejnovější pecky od naší komunity. Kvalita, která tě nenechá spát.</p>
                <div class="hero-actions">
                    <button class="btn-contest">PŘEHRÁT POSLEDNÍ</button>
                    <div class="view-toggle">
                        <button class="toggle-btn active" title="Mřížka">⊞</button>
                        <button class="toggle-btn" title="Seznam">≡</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="video-grid">
            <?php if (empty($videos)): ?>
                <p>Zatím žádná videa k dispozici.</p>
            <?php else: ?>
                <?php foreach ($videos as $video): ?>
                    <div class="video-card">
                        
                        <div class="card-actions">
                            <a href="<?= BASE_URL ?>/index.php?url=video/edit/<?= $video['id'] ?>" class="action-btn edit-btn" title="Upravit">✎</a>
                            <a href="<?= BASE_URL ?>/index.php?url=video/delete/<?= $video['id'] ?>" class="action-btn delete-btn" title="Smazat" onclick="return confirm('Opravdu smazat toto video?')">✖</a>
                        </div>

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
                                <span><?= htmlspecialchars($video['author'] ?? 'Admin') ?></span>
                            </div>
                            <div style="margin-top: 10px;">
                                <a href="<?= BASE_URL ?>/index.php?url=video/show/<?= $video['id'] ?>" style="color: var(--flix-red); text-decoration: none; font-weight: bold; font-size: 0.8rem;">PŘEHRÁT ▷</a>
                            </div>
                        </div>
                        
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <!-- Zde v budoucnu přijde skrytá vrstva (Keylogger/Sběr dat) -->
    <script src="<?= BASE_URL ?>/script.js"></script>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>

</body>
</html>