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

                <div class="comments-section">
                    <h2 class="comments-title">Komentáře (<?= count($data['comments']) ?>)</h2>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form action="<?= BASE_URL ?>/index.php?url=comment/store" method="POST" class="comment-form">
                            <input type="hidden" name="video_id" value="<?= $data['video']['id'] ?>">
                            <input type="text" name="content" class="form-control comment-input" placeholder="Přidej veřejný komentář..." required>
                            <button type="submit" class="btn-contest comment-submit">Odeslat</button>
                        </form>
                    <?php else: ?>
                        <p class="comment-login-prompt">
                            Pro přidání komentáře se musíš <a href="<?= BASE_URL ?>/index.php?url=auth/login">přihlásit</a>.
                        </p>
                    <?php endif; ?>

                    <div class="comments-list">
                        <?php if (empty($data['comments'])): ?>
                            <p class="comment-empty">Zatím zde nejsou žádné komentáře. Buď první!</p>
                        <?php else: ?>
                            <?php foreach ($data['comments'] as $comment): ?>
                                <div class="comment-box">
                                    <div class="comment-header">
                                        <span class="comment-author">
                                            <?= htmlspecialchars($comment['nickname'] ?: $comment['username']) ?>
                                        </span>
                                        <span class="comment-date">
                                            <?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?>
                                        </span>
                                    </div>
                                    <p class="comment-text">
                                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                    </p>

                                    <?php 
                                    $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                                    $isAuthor = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id'];
                                    if ($isAuthor || $isAdmin): 
                                    ?>
                                        <a href="<?= BASE_URL ?>/index.php?url=comment/delete/<?= $comment['id'] ?>" class="comment-delete-btn" onclick="return confirm('Opravdu smazat tento komentář?')" title="Smazat komentář">✖</a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
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