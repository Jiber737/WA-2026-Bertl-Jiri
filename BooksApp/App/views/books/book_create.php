<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIB 2026 | Nový záznam</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="form-page">
    <div class="background-glow"></div>

<?php require_once '../App/views/layout/header.php'; ?>

    <main>
        <div class="glass-container form-container">
            <div class="form-header">
                <h2>Nový záznam</h2>
                <p>Vložte parametry knihy do centrální databáze</p>
            </div>

            <form action="index.php?url=book/store" method="post" enctype="multipart/form-data" class="cyber-form">
                <div class="form-grid">
                    <div class="input-group">
                        <label for="title">Název knihy<span>*</span></label>
                        <input type="text" name="title" id="title" placeholder="Např. Digitální pevnost" required>
                    </div>

                    <div class="input-group">
                        <label for="author">Autor<span>*</span></label>
                        <input type="text" name="author" id="author" placeholder="Příjmení a jméno" required>
                    </div>

                    <div class="input-group">
                        <label for="isbn">ISBN<span>*</span></label>
                        <input type="text" name="isbn" id="isbn" placeholder="000-000-000-000" required>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="year">Rok vydání<span>*</span></label>
                            <input type="number" name="year" id="year" placeholder="2026" required>
                        </div>
                        <div class="input-group">
                            <label for="price">Cena (Kč)</label>
                            <input type="number" name="price" id="price" step="0.1" placeholder="0.00">
                        </div>
                    </div>

                    <div class="input-row">

                        <div>
                            <label for="category">Kategorie *</label>
                            <!-- ZMĚNA: Použití select místo input a iterace přes $categories -->
                            <select id="category" name="category" required>
                                <option value="">-- Vyberte kategorii --</option>
                                
                                <?php foreach ($categories as $cat): ?>
                                    <!-- Do value ukládáme ID kategorie (to se odešle do DB), ale uživateli zobrazíme název -->
                                    <option value="<?= htmlspecialchars($cat['id']) ?>">
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                                
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="subcategory">Podkategorie</label>
                            <input type="text" name="subcategory" id="subcategory">
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="description">Popis knihy</label>
                        <textarea name="description" id="description" rows="4" placeholder="Stručný obsah knihy..."></textarea>
                    </div>

                    <div class="input-group">
                        <label class="file-label">
                            <span class="label-text">Obrázek obálky</span>
                            <div class="file-drop-zone">
                                <span class="icon">📁</span>
                                <span class="text-gray">Klikněte pro nahrání souborů (JPG/PNG)</span>
                                <input type="file" id="images" name="images[]" multiple accept="image/*">
                            </div>
                        </label>
                    </div>

                    <div class="md:col-span-2">
   

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Inicializovat uložení</button>
                    </div>
                </div>
            </form>
        </div>

<script>
    // Najdeme naše HTML prvky podle ID
    const fileInput = document.getElementById('images');
    const fileTitle = document.getElementById('file-title');
    const fileInfo = document.getElementById('file-info');

    // Posloucháme událost 'change' (změna hodnoty v inputu)
    fileInput.addEventListener('change', function(event) {
        const files = event.target.files;
        
        if (files.length === 0) {
            // Uživatel výběr zrušil
            fileTitle.textContent = 'Klikněte pro výběr souborů';
            fileTitle.className = 'text-sm text-slate-400 font-semibold';
            fileInfo.textContent = 'Žádné soubory nebyly vybrány';
        } else if (files.length === 1) {
            // Vybrán 1 soubor - ukážeme jeho název
            fileTitle.textContent = 'Soubor připraven';
            fileTitle.className = 'text-sm text-blue-400 font-bold';
            fileInfo.textContent = files[0].name;
        } else {
            // Vybráno více souborů - ukážeme počet
            fileTitle.textContent = 'Soubory připraveny';
            fileTitle.className = 'text-sm text-blue-400 font-bold';
            fileInfo.textContent = 'Vybráno celkem: ' + files.length + ' souborů';
        }
    });
</script>

    </main>

    <?php require_once '../App/views/layout/footer.php'; ?>
</body>
</html>
