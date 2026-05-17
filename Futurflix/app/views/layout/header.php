<header>
    <div class="logo">
        <a href="<?= BASE_URL ?>/index.php" style="color: inherit; text-decoration: none;">FUTURFLIX</a>
    </div>
    <nav>
        <a href="<?= BASE_URL ?>/index.php">Domů</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?= BASE_URL ?>/index.php?url=video/create" class="btn-add">+ Přidat video</a>
            <a href="<?= BASE_URL ?>/index.php?url=auth/profile" class="welcome-link">
                Ahoj, <?= htmlspecialchars($_SESSION['user_name']); ?> 👤
            </a>
            <a href="<?= BASE_URL ?>/index.php?url=auth/logout" class="btn-logout">Odhlásit</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="btn-add">Přihlásit se</a>
        <?php endif; ?>
    </nav>
</header>