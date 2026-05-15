<footer class="site-footer">
        <div class="footer-container">
            <div class="footer-logo">
                <h2>Futurflix</h2>
            </div>
            <div class="footer-links">
                <ul>
                    <li><a href="#">Časté dotazy (FAQ)</a></li>
                    <li><a href="#">Centrum nápovědy</a></li>
                    <li><a href="#">Účet</a></li>
                </ul>
                <ul>
                    <li><a href="#">Podmínky použití</a></li>
                    <li><a href="#">Ochrana soukromí</a></li>
                    <li><a href="#">Předvolby cookies</a></li>
                </ul>
                <ul>
                    <li><a href="#">Kontaktujte nás</a></li>
                    <li><a href="#">O projektu</a></li>
                    <li><a href="#">Soutěž</a></li>
                </ul>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date("Y") ?> Futurflix - Všechna práva vyhrazena.</p>
            </div>
        </div>
    </footer>
    
    <script src="<?= BASE_URL ?>/script.js"></script>

</body>

<?php if (isset($_SESSION['messages'])): ?>
    <div id="futurflix-modal" class="modal-overlay">
        <div class="modal-content">
            
            <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                <?php foreach ($messages as $message): ?>
                    
                    <h2 class="<?= $type === 'error' ? 'text-red' : 'text-green' ?>">
                        <?= $type === 'error' ? '⚠️ CHYBA' : '✅ ÚSPĚCH' ?>
                    </h2>
                    
                    <p class="modal-text"><?= htmlspecialchars($message) ?></p>
                    
                <?php endforeach; ?>
            <?php endforeach; ?>

            <div class="modal-buttons">
                <button onclick="document.getElementById('futurflix-modal').style.display='none'" class="btn-contest" style="padding: 12px 20px; font-size: 1rem; width: 100%;">
                    Rozumím / Pokračovat
                </button>
                
                <a href="<?= BASE_URL ?>/index.php" class="btn-cancel">
                    Zrušit a zpět na hlavní stránku
                </a>
            </div>

        </div>
    </div>
    
    <?php 
        // DŮLEŽITÉ: Po vykreslení okna zprávy smažeme, aby nevyskakovaly pořád dokola při každém obnovení stránky
        unset($_SESSION['messages']); 
    ?>
<?php endif; ?>

</html>