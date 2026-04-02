<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovna 2026 | Seznam</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="background-glow"></div>
    
    <header>
        <div class="header-content">
            <h1><span>LIB</span> RARY</h1>
            <nav>
                <ul>
                    <li><a href="index.php" class="nav-link">Domů</a></li>
                    <li><a href="index.php?url=book/create" class="nav-link add-btn">＋ Nová kniha</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="notifications-container">
                
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        // Jednoduché určení barvy podle typu zprávy
                        $color = 'black';
                        if ($type === 'success') $color = 'green';
                        if ($type === 'error') $color = 'red';
                        if ($type === 'notice') $color = 'orange';
                    ?>
                    
                    <?php foreach ($messages as $message): ?>
                        <div style="color: <?= $color ?>; border: 1px solid <?= $color ?>; padding: 10px; margin-bottom: 10px;">
                            <strong><?= htmlspecialchars($message) ?></strong>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                
            </div>
            
            <?php 
                // ZÁSADNÍ KROK: Po vypsání musíme zprávy ze session vymazat, 
                // aby se nezobrazovaly při každém dalším obnovení stránky!
                unset($_SESSION['messages']); 
            ?>
        <?php endif; ?>
        <div class="glass-container">
            
            <h2>Dostupné záznamy</h2>

            <?php if (!empty($books)): ?>
            <div class="table-wrapper">
                <table class="book-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Název knihy</th>
                            <th>Autor</th>
                            <th>Cena</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td class="id-cell">#<?php echo htmlspecialchars($book['id']); ?></td>
                                <td class="title-cell"><?php echo htmlspecialchars($book['title']); ?></td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                <td class="price-cell"><?php echo number_format($book['price'], 2); ?> Kč</td>
                                <td class="actions">
                                    <a href="index.php?url=book/show/<?php echo $book['id']; ?>" class="btn-action">Detail</a> 
                                    <a href="index.php?url=book/edit/<?php echo $book['id']; ?>" class="btn-action">Upravit</a> 
                                    <a href="index.php?url=book/delete/<?php echo $book['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Smazat záznam z databáze?')">Smazat</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="no-data">
                    <p>Systém nenalezl žádné aktivní záznamy.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; WA 2026 | Core System v3.0</p>
    </footer>
</body>
</html>

<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <h1> Aplikace Knihovna</h1>

        <nav>
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php">Seznam knih (Domů)</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?url=book/create">Přidat novou knihu</a></li>
                

            </ul>
        </nav>
    </header>


<main>

   <h2>Dostupné knihy</h2>

<?php if (!empty($books)): ?>
    <table class="book-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Název knihy</th>
                <th>Autor</th>
                <th>Cena</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['id']); ?></td>
                    <td><strong><?php echo htmlspecialchars($book['title']); ?></strong></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo number_format($book['price'], 2); ?> Kč</td>
                    <td>
                        <a href="index.php?url=book/show/<?php echo $book['id']; ?>" class="btn-action">Detail</a> 
                        <a href="index.php?url=book/edit/<?php echo $book['id']; ?>" class="btn-action">Upravit</a> 
                        <a href="index.php?url=book/delete/<?php echo $book['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Opravdu chcete tuto knihu smazat?')">Smazat</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="no-data">V knihovně zatím nejsou žádné knihy.</p>
<?php endif; ?>
</main>



<footer>
    <p>&copy; WA 2026 - Výukový projekt</p>
</footer>


</body>
</html>