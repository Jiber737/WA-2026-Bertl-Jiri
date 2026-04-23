<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIB 2026 | Nový záznam</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<?php require_once '../app/views/layout/header.php'; ?>

<main>
    <div class="glass-container form-container">
        <div class="form-header">
            <h2>Nová registrace</h2>
            <p>Vytvořte si účet pro správu vašeho knižního katalogu.</p>
        </div>
        
        <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post" class="cyber-form">
            
            <h3 style="color: var(--primary); font-family: 'Orbitron', sans-serif; font-size: 0.8rem; border-bottom: 1px solid var(--border); padding-bottom: 5px; margin-bottom: 20px;">Přihlašovací údaje</h3>

            <div class="input-row">
                <div class="input-group">
                    <label for="username">Uživatelské jméno <span>*</span></label>
                    <input type="text" id="username" name="username" required placeholder="Vaše login jméno">
                </div>

                <div class="input-group">
                    <label for="email">E-mail <span>*</span></label>
                    <input type="email" id="email" name="email" required placeholder="email@priklad.cz">
                </div>
            </div>

            <div class="input-row">
                <div class="input-group">
                    <label for="password">Heslo <span>*</span></label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="input-group">
                    <label for="password_confirm">Potvrzení hesla <span>*</span></label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>
            </div>

            <h3 style="color: var(--accent); font-family: 'Orbitron', sans-serif; font-size: 0.8rem; border-bottom: 1px solid var(--border); padding-bottom: 5px; margin-top: 20px; margin-bottom: 20px;">Osobní údaje (Volitelné)</h3>

            <div class="input-row">
                <div class="input-group">
                    <label for="first_name">Křestní jméno</label>
                    <input type="text" id="first_name" name="first_name">
                </div>

                <div class="input-group">
                    <label for="last_name">Příjmení</label>
                    <input type="text" id="last_name" name="last_name">
                </div>
            </div>

            <div class="input-group">
                <label for="nickname">Zobrazovaná přezdívka</label>
                <input type="text" id="nickname" name="nickname" placeholder="Jak vám máme v aplikaci říkat?">
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="submit-btn">Vytvořit účet</button>
                
                <p style="text-align: center; font-size: 0.8rem; color: #8892b0; margin-top: 20px;">
                    Už máte účet? <a href="<?= BASE_URL ?>/index.php?url=auth/login" style="color: var(--accent); text-decoration: none;">Přihlaste se zde</a>.
                </p>
            </div>
        </form>
    </div>
</main>


<?php require_once '../app/views/layout/footer.php'; ?>