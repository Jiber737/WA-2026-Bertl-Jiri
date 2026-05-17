<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futurflix - Přihlášení</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">
</head>
<body>

    <?php require_once __DIR__ . '/../layout/header.php'; ?>

    <main class="auth-main">
        <div class="auth-container">
            <h1 class="auth-title">Přihlášení</h1>

            <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="POST">
                
                <div class="form-group">
                    <label for="email">E-mailová adresa</label>
                    <input type="email" id="email" name="email" required placeholder="name@example.com" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Heslo</label>
                    <input type="password" id="password" name="password" required placeholder="Zadejte heslo" class="form-control">
                </div>

                <button type="submit" class="btn-auth">Přihlásit se</button>

            </form>

            <div class="auth-switch">
                Na Futurflixu poprvé? <a href="<?= BASE_URL ?>/index.php?url=auth/register">Zaregistruj se hned.</a>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>

</body>
</html>