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
                        <div class="input-group">
                            <label for="category">Kategorie</label>
                            <input type="text" name="category" id="category">
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
    <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Obrázky knihy</label>
    <div class="w-full">
        <label for="images" class="flex flex-col items-center justify-center w-full h-24 border-2 border-slate-600 border-dashed rounded-lg cursor-pointer bg-slate-800/30 hover:bg-slate-700/50 hover:border-blue-400 transition-colors">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <span id="file-title" class="text-sm text-slate-400 font-semibold">Klikni pro výběr souborů</span>
                <span id="file-info" class="text-xs text-slate-500 mt-1 text-center px-4">Žádné soubory nebyly vybrány</span>
            </div>
            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
        </label>
    </div>
</div>

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

<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div>
        <div>
            <h2>přidat novou knihu</h2>
            <p>vyplňte údaje a uložte knihu do databaze</p>
        </div>
        <div>
            <form action="<?= BASE_URL ?>/index.php?url=book/store" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="title">název knihy<span>*</span></label>
                        <input type="text" name="title" id="title" required>
                    </div>

                    <div>
                        <label for="author">autor<span>*</span></label>
                        <input type="text" name="author" id="author" placeholder="Příjmení a jméno" required>

                    </div>

                    <div>
                        <label for="category">Kategorie</label>
                        <input type="text" name="category" id="category">
                    </div>

                    <div>
                        <label for="subcategory">Podkategorie</label>
                        <input type="text" name="subcategory" id="subcategory">
                    </div>

                    <div>
                        <label for="isbn">ISBN<span>*</span></label>
                        <input type="text" name="isbn" id="isbn" placeholder="000-000-000-000">

                    </div>

                    <div>
                        <label for="year">Rok vydání<span>*</span></label>
                        <input type="number" name="year" id="year" required>

                    </div>

                    <div>
                        <label for="price">Cena knihy</label>
                        <input type="number" name="price" id="price" step="0.5">

                    </div>

                  

                    <div>
                        <label for="link">Odkaz</label>
                        <input type="text" name="link" id="link">

                    </div>

                    <div>
                        <label for="description">popis knihy</label>
                        <textarea type="text" name="description" id="description" rows="5"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Obrázky (můžete nahrát více)</label>
                        <label class="flex flex-col items-center justify-center w-full p-6 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition">
                            <span class="text-gray-600 font-medium">Klikni pro výběr souborů</span>
                            <span class="text-sm text-gray-400 mt-1">JPG / PNG / WebP – více souborů najednou</span>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                        </label>
                    </div>

                    <div>
                        <button type="submit">Uložit knihu do DB</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

