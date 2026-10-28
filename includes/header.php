<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e($tagline) ?>">
    <title><?= e($pageTitle) ?> | <?= e($siteName) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="index.php">
                <span class="brand-mark" aria-hidden="true">P</span>
                <span>
                    <strong><?= e($siteName) ?></strong>
                    <small><?= e($tagline) ?></small>
                </span>
            </a>
            <nav aria-label="Main navigation">
                <ul class="nav-list">
                    <?php foreach ($navItems as $label => $fileName): ?>
                        <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
                        <?php $isCurrentPage = $currentPage === $fileName || ($currentPage === 'service.php' && $fileName === 'services.php'); ?>
                        <li>
                            <a href="<?= e($fileName) ?>"
                               class="<?= $isCurrentPage ? 'active' : '' ?>"
                               <?= $isCurrentPage ? 'aria-current="page"' : '' ?>>
                                <?= e($label) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
