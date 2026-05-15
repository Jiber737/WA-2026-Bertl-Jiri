<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Futurflix - Přidat nové video</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">
</head>
<body>

    <?php require_once '../app/views/layout/header.php'; ?>

    <main class="form-container">
        
        <h1 class="form-title">PŘIDAT VIDEO</h1>
        <p class="form-subtitle">Vyplň údaje o svém díle a ukaž ho světu.</p>

        <form action="<?= BASE_URL ?>/index.php?url=video/store" method="POST" class="futurflix-form">
            
            <div class="form-group">
                <label for="title">Název videa <span class="required-star">*</span></label>
                <input type="text" id="title" name="title" required placeholder="Např. Můj první krátký film" class="form-control">
            </div>

            <div class="form-group">
                <label for="youtube_url">YouTube URL adresa <span class="required-star">*</span></label>
                <input type="url" id="youtube_url" name="youtube_url" required placeholder="https://www.youtube.com/watch?v=..." class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Tvůj komentář k videu:</label>
                <textarea id="description" name="description" rows="4" placeholder="O čem to je? Jak to vzniklo?" class="form-control"></textarea>
            </div>

            <div class="form-row-3">
                
                <div class="form-group">
                    <label for="genre">Žánr:</label>
                    <select id="genre" name="genre" class="form-control">
                        <option value="Zábava">Zábava</option>
                        <option value="Sci-Fi">Sci-Fi</option>
                        <option value="Horor">Horor</option>
                        <option value="Akční">Akční</option>
                        <option value="Komedie">Komedie</option>
                        <option value="Dokument">Dokument</option>
                        <option value="Herní">Herní video</option>
                        <option value="Podcast">Podcast</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="release_year">Rok vydání:</label>
                    <select id="release_year" name="release_year" class="form-control">
                        <?php 
                        $currentYear = date("Y");
                        for ($i = $currentYear; $i >= 1923; $i--) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="age_rating">Věkový rating:</label>
                    <select id="age_rating" name="age_rating" class="form-control">
                        <option value="3+">3+ (G)</option>
                        <option value="7+">7+ (PG)</option>
                        <option value="12+">12+ (PG-13)</option>
                        <option value="16+">16+ (TV-MA)</option>
                        <option value="18+">18+ (R / NC-17)</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="btn-contest btn-submit-form">
                ULOŽIT DO KNIHOVNY
            </button>

            <a href="<?= BASE_URL ?>/index.php" class="form-cancel-link">Zrušit a jít zpět</a>

        </form>
    </main>

    <?php require_once '../app/views/layout/footer.php'; ?>

</body>
</html>