<!--<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIB 2026 | Detail knihy</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="form-page">
    <div class="background-glow"></div>

    <?php require_once '../App/views/layout/header.php'; ?>


    <main>
        <div class="glass-container form-container" style="color: #e0e6ed;">
            <div class="form-header">
                <h2 style="font-size: 1.5rem; margin-bottom: 10px;"><?= htmlspecialchars($book['title']) ?></h2>
                <p>Katalogové ID záznamu: #<?= htmlspecialchars($book['id']) ?></p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 25px;">
                <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
                <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
                <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">Rok vydání:</strong> <?= htmlspecialchars($book['year']) ?></p>
                
                <p style="margin-bottom: 15px;">
                    <strong style="color: var(--primary);">Kategorie:</strong> 
                    <?= htmlspecialchars($book['category']) ?> 
                    <?php if(!empty($book['subcategory'])) echo " / " . htmlspecialchars($book['subcategory']); ?>
                </p>
                
                <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">Cena:</strong> <span style="color: var(--accent); font-weight: bold;"><?= number_format($book['price'], 2) ?> Kč</span></p>

                <?php if(!empty($book['link'])): ?>
                    <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">Externí odkaz:</strong> <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank" style="color: var(--accent); text-decoration: none;"><?= htmlspecialchars($book['link']) ?></a></p>
                <?php endif; ?>
            </div>

            <?php if(!empty($book['description'])): ?>
            <div style="background: rgba(255,255,255,0.02); padding: 20px; border-radius: 12px; border-left: 3px solid var(--primary);">
                <h3 style="font-family: 'Orbitron', sans-serif; color: var(--primary); font-size: 1rem; margin-top: 0;">Popis záznamu</h3>
                <p style="line-height: 1.6;"><?= nl2br(htmlspecialchars($book['description'])) ?></p>
            </div>
            <?php endif; ?>

            <div class="form-actions" style="margin-top: 30px; display: flex; gap: 15px;">
                <a href="index.php?url=book/edit/<?= $book['id'] ?>" class="submit-btn" style="text-align: center; text-decoration: none; flex: 1;">Upravit záznam</a>
            </div>
        </div>
    </main>

        <?php require_once '../App/views/layout/header.php'; ?>

</body>
</html>
            -->


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIB 2026 | Detail knihy</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="form-page">
    <div class="background-glow"></div>

    <?php require_once '../App/views/layout/header.php'; ?>

    <main>
        <div class="glass-container form-container" style="color: #e0e6ed;">
            <div class="form-header">
                <h2 style="font-size: 1.5rem; margin-bottom: 10px;"><?= htmlspecialchars($book['title']) ?></h2>
                <p>Katalogové ID záznamu: #<?= htmlspecialchars($book['id']) ?></p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 25px;">
                <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
                <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">ISBN:</strong> <?= htmlspecialchars($book['isbn'] ?? '') ?></p>
                <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">Rok vydání:</strong> <?= htmlspecialchars($book['year']) ?></p>
                
                <p style="margin-bottom: 15px;">
                    <strong style="color: var(--primary);">Kategorie:</strong> 
                    <?= htmlspecialchars($book['category'] ?? '') ?> 
                    <?php if(!empty($book['subcategory'])) echo " / " . htmlspecialchars($book['subcategory']); ?>
                </p>
                
                <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">Cena:</strong> <span style="color: var(--accent); font-weight: bold;"><?= number_format($book['price'] ?? 0, 2) ?> Kč</span></p>

                <?php if(!empty($book['link'])): ?>
                    <p style="margin-bottom: 15px;"><strong style="color: var(--primary);">Externí odkaz:</strong> <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank" style="color: var(--accent); text-decoration: none;"><?= htmlspecialchars($book['link']) ?></a></p>
                <?php endif; ?>
            </div>

            <?php if(!empty($book['description'])): ?>
            <div style="background: rgba(255,255,255,0.02); padding: 20px; border-radius: 12px; border-left: 3px solid var(--primary);">
                <h3 style="font-family: 'Orbitron', sans-serif; color: var(--primary); font-size: 1rem; margin-top: 0;">Popis záznamu</h3>
                <p style="line-height: 1.6;"><?= nl2br(htmlspecialchars($book['description'])) ?></p>
            </div>
            <?php endif; ?>

            <?php 
                // 1. Zjistíme, jestli vůbec kniha má nějaké obrázky uložené v databázi
                $images = [];
                if (!empty($book['images'])) {
                    // 2. Dekódujeme JSON text zpět na PHP pole
                    $images = json_decode($book['images'], true);
                    if (!is_array($images)) {
                        $images = [];
                    }
                }
            ?>
            
            <?php if(!empty($images)): ?>
            <div style="margin-top: 30px;">
                <h3 style="font-family: 'Orbitron', sans-serif; color: var(--primary); font-size: 1rem; margin-bottom: 15px;">Obrazová příloha</h3>
                
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <?php foreach($images as $img): ?>
                        <div style="background: rgba(0,0,0,0.3); padding: 10px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); text-align: center;">
                            <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($img) ?>" alt="Obrázek ke knize" style="max-height: 250px; max-width: 100%; border-radius: 4px; object-fit: cover;">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="form-actions" style="margin-top: 30px; display: flex; gap: 15px;">
                <a href="index.php?url=book/edit/<?= $book['id'] ?>" class="submit-btn" style="text-align: center; text-decoration: none; flex: 1;">Upravit záznam</a>
            </div>
        </div>
    </main>

    <?php require_once '../App/views/layout/footer.php'; ?>

</body>
</html>