<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIB 2026 | Nový záznam</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>


<?php require_once '../App/views/layout/header.php'; ?>

<main>
    <div class="glass-container form-container" style="max-width: 450px; margin: 40px auto;">
        <div class="form-header">
            <h2 style="font-family: 'Orbitron', sans-serif;">Přihlášení</h2>
            <p>Vítejte zpět v naší Knihovně.</p>
        </div>
        
        <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post" class="cyber-form">
            
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required autofocus placeholder="vas@email.cz">
            </div>

            <div class="input-group">
                <label for="password">Heslo</label>
                <input type="password" id="password" name="password" required placeholder="******">
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="submit-btn">Přihlásit se</button>
                
                <p style="text-align: center; font-size: 0.8rem; color: #8892b0; margin-top: 20px; border-top: 1px solid var(--border); pt-4;">
                    Nemáte ještě účet? <a href="<?= BASE_URL ?>/index.php?url=auth/register" style="color: var(--primary); text-decoration: none;">Zaregistrujte se</a>.
                </p>
            </div>
        </form>
    </div>
</main>

<?php require_once '../App/views/layout/footer.php'; ?>