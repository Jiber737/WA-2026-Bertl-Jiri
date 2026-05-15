<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Futurflix - Přidat nové video</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">
</head>
<body style="background-color: var(--bg-dark-grey); color: white;">

    <?php require_once '../app/views/layout/header.php'; ?>

    <main style="max-width: 700px; margin: 40px auto; padding: 30px; background: #1a1a1a; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border: 1px solid #333;">
        
        <h1 style="font-family: 'BurbankBigCity', sans-serif; color: var(--flix-red); font-size: 3rem; margin-bottom: 10px; text-align: center;">PŘIDAT VIDEO</h1>
        <p style="text-align: center; color: var(--text-grey); margin-bottom: 30px;">Vyplň údaje o svém díle a ukaž ho světu.</p>

        <form action="<?= BASE_URL ?>/index.php?url=video/store" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
            
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="title" style="font-weight: bold; color: var(--text-white);">Název videa <span style="color: var(--flix-red);">*</span></label>
                <input type="text" id="title" name="title" required placeholder="Např. Můj první krátký film" 
                       style="padding: 12px; background: #222; border: 1px solid #444; color: white; border-radius: 4px;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="youtube_url" style="font-weight: bold; color: var(--text-white);">YouTube URL adresa <span style="color: var(--flix-red);">*</span></label>
                <input type="url" id="youtube_url" name="youtube_url" required placeholder="https://www.youtube.com/watch?v=..."
                       style="padding: 12px; background: #222; border: 1px solid #444; color: white; border-radius: 4px;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="description" style="font-weight: bold; color: var(--text-white);">Tvůj komentář k videu:</label>
                <textarea id="description" name="description" rows="4" placeholder="O čem to je? Jak to vzniklo?"
                          style="padding: 12px; background: #222; border: 1px solid #444; color: white; border-radius: 4px; resize: vertical;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="genre" style="font-weight: bold; color: var(--text-white);">Žánr:</label>
                    <select id="genre" name="genre" style="padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 4px;">
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

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="release_year" style="font-weight: bold; color: var(--text-white);">Rok vydání:</label>
                    <select id="release_year" name="release_year" style="padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 4px;">
                        <?php 
                        $currentYear = date("Y");
                        for ($i = $currentYear; $i >= 1923; $i--) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="age_rating" style="font-weight: bold; color: var(--text-white);">Věkový rating:</label>
                    <select id="age_rating" name="age_rating" style="padding: 10px; background: #222; border: 1px solid #444; color: white; border-radius: 4px;">
                        <option value="3+">3+ (G)</option>
                        <option value="7+">7+ (PG)</option>
                        <option value="12+">12+ (PG-13)</option>
                        <option value="16+">16+ (TV-MA)</option>
                        <option value="18+">18+ (R / NC-17)</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="btn-contest" style="padding: 15px; margin-top: 20px; font-size: 1.5rem; letter-spacing: 1px;">
                ULOŽIT DO KNIHOVNY
            </button>

            <a href="<?= BASE_URL ?>/index.php" style="text-align: center; color: var(--text-grey); text-decoration: none; font-size: 0.9rem;">Zrušit a jít zpět</a>

        </form>
    </main>

    <?php require_once '../app/views/layout/footer.php'; ?>

</body>
</html>