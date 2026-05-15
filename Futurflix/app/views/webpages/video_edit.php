<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Futurflix - Upravit video</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">
</head>
<body>

    <?php require_once '../app/views/layout/header.php'; ?>

    <main class="form-container">
        
        <h1 class="form-title">UPRAVIT VIDEO</h1>
        <p class="form-subtitle">Tady můžeš změnit detaily svého díla.</p>

        <form action="<?= BASE_URL ?>/index.php?url=video/update/<?= $video['id'] ?>" method="POST" enctype="multipart/form-data" class="futurflix-form">
            
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($video['image'] ?? '') ?>">

            <div class="form-group">
                <label for="title">Název videa <span class="required-star">*</span></label>
                <input type="text" id="title" name="title" required value="<?= htmlspecialchars($video['title'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="youtube_url">YouTube URL adresa <span class="required-star">*</span></label>
                <input type="url" id="youtube_url" name="youtube_url" required value="<?= htmlspecialchars($video['youtube_url'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Tvůj komentář k videu:</label>
                <textarea id="description" name="description" rows="4" class="form-control"><?= htmlspecialchars($video['description'] ?? '') ?></textarea>
            </div>

            <div class="form-row-3">
                
                <div class="form-group">
                    <label for="genre">Žánr:</label>
                    <select id="genre" name="genre" class="form-control">
                        <?php 
                        $genres = ['Zábava', 'Sci-Fi', 'Horor', 'Akční', 'Komedie', 'Dokument', 'Herní video', 'Podcast'];
                        foreach ($genres as $g): 
                            // Podmínka, která vybere ten žánr, který je uložený v databázi
                            $selected = ($video['genre'] === $g) ? 'selected' : '';
                        ?>
                            <option value="<?= $g ?>" <?= $selected ?>><?= $g ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="release_year">Rok vydání:</label>
                    <select id="release_year" name="release_year" class="form-control">
                        <?php 
                        $currentYear = date("Y");
                        for ($i = $currentYear; $i >= 1923; $i--) {
                            $selected = ($video['release_year'] == $i) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="age_rating">Věkový rating:</label>
                    <select id="age_rating" name="age_rating" class="form-control">
                        <?php 
                        $ratings = ['3+', '7+', '12+', '16+', '18+'];
                        foreach ($ratings as $r):
                            $selected = ($video['age_rating'] === $r) ? 'selected' : '';
                        ?>
                            <option value="<?= $r ?>" <?= $selected ?>><?= $r ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="form-group" style="margin-top: 10px; border-top: 1px solid #333; padding-top: 15px;">
                <label for="image">Změnit náhledový obrázek:</label>
                <?php if(!empty($video['image'])): ?>
                    <p style="font-size: 0.85rem; color: var(--text-grey); margin-top: 5px; margin-bottom: 5px;">
                        Aktuální obrázek: <strong style="color: white;"><?= htmlspecialchars($video['image']) ?></strong>
                    </p>
                <?php endif; ?>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small style="color: var(--text-grey);">Pokud nevybereš nový soubor, zůstane ten původní.</small>
            </div>

            <button type="submit" class="btn-contest btn-submit-form">
                ULOŽIT ZMĚNY
            </button>

            <a href="<?= BASE_URL ?>/index.php" class="form-cancel-link">Zrušit a jít zpět na hlavní stránku</a>

        </form>
    </main>

    <?php require_once '../app/views/layout/footer.php'; ?>

</body>
</html>