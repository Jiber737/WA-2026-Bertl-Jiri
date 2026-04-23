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