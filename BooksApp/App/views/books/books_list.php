<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovna 2026 | Seznam</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="background-glow"></div>
    
    <?php require_once '../App/views/layout/header.php'; ?>

    <main>
        

        <div class="glass-container" style="margin-bottom: 30px; padding: 25px;">
            <h2 style="border-left: none; padding-left: 0; margin-bottom: 15px;">Katalog: LIB 2026</h2>
            <p style="color: #a0aec0; line-height: 1.6; font-size: 0.95rem;">
                Procházejte dostupné tituly v naší databázi. Kliknutím na detail knihy zobrazíte kompletní informace a obrazovou přílohu.
            </p>
        </div>

        <div>
            <?php if (!empty($books)): ?>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 25px;">
                
                <?php foreach ($books as $book): ?>
                    <?php 
                        // Zpracování obrázků - najdeme první obrázek, který bude fungovat jako obálka
                        $coverImage = null;
                        if (!empty($book['images'])) {
                            $images = json_decode($book['images'], true);
                            if (is_array($images) && !empty($images)) {
                                $coverImage = $images[0]; // Vezmeme první fotku
                            }
                        }
                    ?>
                    
                    <div class="glass-container" style="padding: 15px; display: flex; flex-direction: column; height: 100%; transition: transform 0.3s; border: 1px solid rgba(255,255,255,0.05);">
                        
                        <div style="height: 320px; background: rgba(0,0,0,0.4); border-radius: 8px; margin-bottom: 15px; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
                            <?php if($coverImage): ?>
                                <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($coverImage) ?>" alt="Obálka knihy" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <span style="color: #555; font-family: 'Orbitron', sans-serif; font-size: 0.8rem; text-transform: uppercase;">Bez obálky</span>
                            <?php endif; ?>
                            
                            <div style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: var(--primary); padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-family: 'Orbitron', sans-serif;">
                                #<?= htmlspecialchars($book['id']); ?>
                            </div>
                        </div>

                        <div style="flex-grow: 1;">
                            <h3 style="margin: 0 0 5px 0; font-size: 1.1rem; color: #fff; line-height: 1.3;"><?= htmlspecialchars($book['title']); ?></h3>
                            <p style="margin: 0 0 10px 0; color: #8892b0; font-size: 0.9rem;"><?= htmlspecialchars($book['author']); ?></p>
                            
                            <p style="margin: 0 0 15px 0; color: var(--accent); font-weight: 600; font-size: 1.3rem;">
                                <?= number_format($book['price'] ?? 0, 2); ?> Kč
                            </p>
                        </div>

                        <div style="display: flex; gap: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
    <a href="index.php?url=book/show/<?= $book['id']; ?>" class="submit-btn" style="margin-top: 0; padding: 10px; text-align: center; flex: 2; font-size: 0.85rem;">Detail</a>
    
    <a href="index.php?url=book/edit/<?= $book['id']; ?>" class="submit-btn" style="margin-top: 0; padding: 10px; text-align: center; flex: 1; font-size: 0.85rem; border-color: rgba(255,255,255,0.2); color: #a0aec0; background: transparent;" title="Upravit">✎</a>
    
    <a href="index.php?url=book/delete/<?= $book['id']; ?>" class="submit-btn btn-delete" style="margin-top: 0; padding: 10px; text-align: center; flex: 1; font-size: 0.85rem; border-color: rgba(255,75,75,0.4); color: #ff4b4b; background: transparent;" title="Smazat" onclick="return confirm('Opravdu chcete tento záznam smazat?')">✖</a>
</div>
                        
                    </div>
                <?php endforeach; ?>
                
            </div>
            
            <?php else: ?>
                <div class="glass-container no-data" style="text-align: center; padding: 40px;">
                    <p style="color: #8892b0;">Katalog je momentálně prázdný.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php require_once '../App/views/layout/footer.php'; ?>

</body>
</html>



