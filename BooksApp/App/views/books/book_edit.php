<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIB 2026 | Editace záznamu</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="form-page">
    <div class="background-glow"></div>

    <?php require_once '../App/views/layout/header.php'; ?>


    <main>
        <div class="glass-container form-container">
            <div class="form-header">
                <h2>Editace systému</h2>
                <p>Aktualizujete data pro knihu: <span style="color: var(--primary);">#<?= htmlspecialchars($book['id']) ?></span></p>
            </div>

            <form action="index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data" class="cyber-form">
                <div class="form-grid">
                    
                    <div class="input-group">
                        <label for="id_display">Systémové ID</label>
                        <input type="text" id="id_display" value="<?= htmlspecialchars($book['id']) ?>" readonly style="opacity: 0.6; cursor: not-allowed;">
                    </div>

                    <div class="input-group">
                        <label for="title">Název titulu<span>*</span></label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="author">Autor<span>*</span></label>
                        <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="isbn">ISBN (Kód)<span>*</span></label>
                        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" required>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="year">Rok vydání<span>*</span></label>
                            <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required>
                        </div>
                        <div class="input-group">
                            <label for="price">Cena (Kredit)</label>
                            <input type="number" id="price" name="price" step="0.1" value="<?= htmlspecialchars($book['price']) ?>">
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="category">Sektor (Kategorie)</label>
                            <input type="text" id="category" name="category" value="<?= htmlspecialchars($book['category']) ?>">
                        </div>
                        <div class="input-group">
                            <label for="subcategory">Sub-sektor</label>
                            <input type="text" id="subcategory" name="subcategory" value="<?= htmlspecialchars($book['subcategory']) ?>">
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="description">Datový popis</label>
                        <textarea id="description" name="description" rows="4"><?= htmlspecialchars($book['description']) ?></textarea>
                    </div>

                    <div class="input-group">
                        <label for="link">Externí odkaz</label>
                        <input type="text" id="link" name="link" value="<?= htmlspecialchars($book['link']) ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Aktualizovat databázi</button>
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

        <?php require_once '../App/views/layout/header.php'; ?>

</body>
</html>

<!--<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Upravit knihu</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <p>
            <a href="<?= BASE_URL ?>/index.php">&larr; Zpět na seznam knih</a>
        </p>

        <div>
            <h2>Upravit knihu (ID záznamu: <?= htmlspecialchars($book['id']) ?>)</h2>
            <p>Upravujete data pro knihu: <strong><?= htmlspecialchars($book['title']) ?></strong></p>
            <p>Změňte požadované údaje a uložte formulář.</p>
        </div>
        
        <div>
            <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data">
                <div>
                    <div>
                        <label for="id_display">ID v databázi</label>
                        <input type="text" id="id_display" value="<?= htmlspecialchars($book['id']) ?>" readonly>
                    </div>
                    <div>
                        <label for="title">Název knihy <span>*</span></label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                    </div>
                    <div>
                        <label for="author">Autor <span>*</span></label>
                        <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                    </div>
                    <div>
                        <label for="isbn">ISBN <span>*</span></label>
                        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>">
                    </div>
                    <div>
                        <label for="category">Kategorie </label>
                        <input type="text" id="category" name="category" value="<?= htmlspecialchars($book['category']) ?>">
                    </div>
                    <div>
                        <label for="subcategory">Podkategorie </label>
                        <input type="text" id="subcategory" name="subcategory" value="<?= htmlspecialchars($book['subcategory']) ?>">
                    </div>
                    <div>
                        <label for="year">Rok vydání  <span>*</span></label>
                        <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required>
                    </div>
                    <div>
                        <label for="price">Cena knihy</label>
                        <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price']) ?>">
                    </div>
                    <div>
                        <label for="link">Odkaz</label>
                        <input type="text" id="link" name="link" value="<?= htmlspecialchars($book['link']) ?>">
                    </div>
                    <div>
                        <label for="description">Popis knihy</label>
                        <textarea id="description" name="description" rows="5"><?= htmlspecialchars($book['description']) ?></textarea>
                    </div>    
                    <div>
                        <label>Obrázky (zatím neřešíme, můžete ignorovat)</label>
                        <label>
                            <input type="file" id="images" name="images[]" multiple accept="image/*">
                        </label>
                    </div>
                    <div>
                        <button type="submit">Uložit změny do DB</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>