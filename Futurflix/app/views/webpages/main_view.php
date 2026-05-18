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
        <?php 
        // Vytáhneme nejnovější video
        if (!empty($videos)): 
            $featured = $videos[0]; 
        ?>
        <section class="hero-banner">
            
            <?php if(!empty($featured['image'])): ?>
                <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($featured['image']) ?>" alt="Žhavá novinka" class="hero-bg-img">
            <?php else: ?>
                <div class="hero-bg-placeholder"></div>
            <?php endif; ?>
            
            <div class="hero-fade-overlay"></div>

            <div class="hero-content">
                <div class="hero-badges-row">
                    <span class="hero-badge">ŽHAVÁ NOVINKA</span>
                    <span class="hero-clickbait">🔥 OD OSCAROVÉHO REŽISÉRA</span>
                </div>
                
                <h1 class="hero-featured-title"><?= htmlspecialchars($featured['title']) ?></h1>
                
                <div class="hero-video-info-bar">
                    <span class="age-tag"><?= htmlspecialchars($featured['age_rating'] ?? '12+') ?></span>
                    <span class="hero-info-item"><?= htmlspecialchars($featured['genre'] ?? 'Film') ?></span>
                    <span class="hero-info-separator">•</span>
                    <span class="hero-info-item"><?= htmlspecialchars($featured['release_year']) ?></span>
                </div>
                
                <p class="hero-featured-description">
                    <?= htmlspecialchars($featured['description']) ?>
                </p>
            </div>

            <div class="hero-play-bottom-right">
                <a href="<?= BASE_URL ?>/index.php?url=video/show/<?= $featured['id'] ?>" class="btn-contest hero-play-link">
                    PŘEHRÁT NYNÍ ▶
                </a>
            </div>

        </section>
        <?php endif; ?>

        <section class="video-grid">
            <?php if (empty($videos)): ?>
                <p>Zatím žádná videa k dispozici.</p>
            <?php else: ?>
                <?php foreach ($videos as $video): ?>
                    <div class="video-card">
                        
                        <?php 
                        // 💡 ZMĚNA: Zjistíme práva pro zobrazení tlačítek
                        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                        $isAuthor = isset($_SESSION['user_id']) && isset($video['user_id']) && $_SESSION['user_id'] == $video['user_id'];
                        
                        if ($isAuthor || $isAdmin): 
                        ?>
                            <div class="card-actions">
                                <a href="<?= BASE_URL ?>/index.php?url=video/edit/<?= $video['id'] ?>" class="action-btn edit-btn" title="Upravit">✎</a>
                                <a href="<?= BASE_URL ?>/index.php?url=video/delete/<?= $video['id'] ?>" class="action-btn delete-btn" title="Smazat" onclick="return confirm('Opravdu smazat toto video?')">✖</a>
                            </div>
                        <?php endif; ?>

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
                                    <span><?= htmlspecialchars($video['author'] ?? 'Admin') ?></span>
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

    <!-- Zde v budoucnu přijde skrytá vrstva (Keylogger/Sběr dat) -->
    <script src="<?= BASE_URL ?>/script.js"></script>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>

</body>
</html>