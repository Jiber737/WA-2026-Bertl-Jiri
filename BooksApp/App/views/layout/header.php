<header>
    <div class="header-content">
        <h1><span>LIB</span> 2026</h1>
        <nav>
            <ul>
                <li>
                    <a href="<?= BASE_URL ?>/index.php" class="nav-link">Seznam knih</a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=book/create" class="nav-link add-btn">
                            + Přidat knihu
                        </a>
                    </li>
                    <li class="nav-link" style="text-transform: none; opacity: 0.8;">
                        Ahoj, <span style="color: var(--primary); font-weight: 600;"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/logout" class="nav-link" style="color: #ff4b4b;">
                            Odhlásit
                        </a>
                    </li>

                <?php else: ?>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="nav-link">Přihlásit</a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="nav-link add-btn">
                            Registrace
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
    <div class="notifications-container" style="max-width: 1100px; margin: 20px auto 0 auto; padding: 0 20px;">
        <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
            <?php 
                $color = 'black';
                if ($type === 'success') $color = 'var(--primary)';
                if ($type === 'error') $color = '#ff4b4b';
                if ($type === 'notice') $color = 'orange';
            ?>
            <?php foreach ($messages as $message): ?>
                <div style="color: <?= $color ?>; border: 1px solid <?= $color ?>; padding: 10px; margin-bottom: 10px; border-radius: 8px; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px);">
                    <strong><?= htmlspecialchars($message) ?></strong>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['messages']); // Vymazání zprávy po zobrazení ?>
<?php endif; ?>