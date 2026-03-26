<!DOCTYPE html>
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
                <li><a href="index.php?url=book/index">Seznam knih (Domů)</a></li>
                <li><a href="index.php?url=book/create">Přidat novou knihu</a></li>

            </ul>
        </nav>
    </header>


<main>
    <h2>Dostupné knihy</h2>
    <p>zde se brzy objeví seznam z databáze</p>

    <h2>Dostupné knihy</h2>
    <?php if (!empty($books)): ?>
        <ul>
            <?php foreach ($books as $book): ?>
                <li>
                    <strong><?php echo htmlspecialchars($book['title']); ?></strong> 
                    (<?php echo htmlspecialchars($book['author']); ?>) - 
                    <?php echo htmlspecialchars($book['year']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>V knihovně zatím nejsou žádné knihy.</p>
    <?php endif; ?>
</main>



<footer>
    <p>&copy; WA 2026 - Výukový projekt</p>
</footer>


</body>
</html>