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
    <section class="hero">
        <h1>Žhavé novinky</h1>
        <p class="hero-description">Sleduj ty nejlepší kousky ze světa internetu na Futurflixu.</p>
    </section>

    <section class="video-grid">
        <!-- Zástupné karty videí -->
        <div class="video-card">Video 1</div>
        <div class="video-card">Video 2</div>
        <div class="video-card">Video 3</div>
        <div class="video-card">Video 4</div>
        <div class="video-card">Video 5</div>
        <div class="video-card">Video 6</div>
    </section>
</main>

    <!-- Zde v budoucnu přijde skrytá vrstva (Keylogger/Sběr dat) -->
    <script src="<?= BASE_URL ?>/script.js"></script>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>

</body>
</html>