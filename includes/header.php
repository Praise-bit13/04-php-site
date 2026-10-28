<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= htmlspecialchars($tagline, ENT_QUOTES, 'UTF-8') ?>">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> | <?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="index.php">
                <span class="brand-mark" aria-hidden="true">P</span>
                <span>
                    <strong><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></strong>
                    <small><?= htmlspecialchars($tagline, ENT_QUOTES, 'UTF-8') ?></small>
                </span>
            </a>
            <nav aria-label="Main navigation">
                <ul class="nav-list">
                    <?php foreach ($navItems as $label => $fileName): ?>
                        <?php $isCurrentPage = basename($_SERVER['PHP_SELF']) === $fileName; ?>
                        <li>
                            <a href="<?= htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8') ?>"
                               class="<?= $isCurrentPage ? 'active' : '' ?>"
                               <?= $isCurrentPage ? 'aria-current="page"' : '' ?>>
                                <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
