<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futurflix - Registrace</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">
</head>
<body>

    <?php require_once __DIR__ . '/../layout/header.php'; ?>

    <main class="auth-main">
        <div class="auth-container register">
            <h1 class="auth-title">Registrace</h1>

            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="POST">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Uživatelské jméno <span class="required-star">*</span></label>
                        <input type="text" id="username" name="username" required placeholder="Např. jiber73" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="nickname">Zobrazovaná přezdívka</label>
                        <input type="text" id="nickname" name="nickname" placeholder="Např. Jarda" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">E-mailová adresa <span class="required-star">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="jmeno@domena.cz" class="form-control">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">Jméno</label>
                        <input type="text" id="first_name" name="first_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Příjmení</label>
                        <input type="text" id="last_name" name="last_name" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Heslo <span class="required-star">*</span></label>
                        <input type="password" id="password" name="password" required placeholder="Minimálně 6 znaků" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Potvrzení hesla <span class="required-star">*</span></label>
                        <input type="password" id="password_confirm" name="password_confirm" required placeholder="Heslo znovu" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn-auth">Vytvořit účet</button>

            </form>

            <div class="auth-switch">
                Už máš účet? <a href="<?= BASE_URL ?>/index.php?url=auth/login">Přihlas se zde.</a>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>

</body>
</html>