<?php
declare(strict_types=1);
?>
    </main>
    <footer class="site-footer">
        <div class="container footer-inner">
            <p>&copy; <?= date('Y') ?> <?= e($siteName) ?>. All rights reserved.</p>
            <p class="page-view-count">This page has been viewed <?= e((string) $pageViewCount) ?> times.</p>
            <a href="mailto:<?= e($contactEmail) ?>">
                <?= e($contactEmail) ?>
            </a>
        </div>
    </footer>
</body>
</html>
