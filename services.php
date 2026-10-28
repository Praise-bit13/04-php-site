<?php
declare(strict_types=1);

$pageTitle = 'Services';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">How we can help</p>
        <h1>A little help goes a long way.</h1>
        <p>Choose the service that suits your space. We'll work with you to make a plan that feels just right.</p>
    </div>
</section>

<section class="section">
    <div class="container service-card-grid">
        <?php foreach ($services as $service): ?>
            <?= renderServiceCard($service) ?>
        <?php endforeach; ?>
    </div>
</section>

<section class="callout">
    <div class="container callout-inner">
        <div><p class="eyebrow">Not sure what you need?</p><h2>Tell us about your space.</h2></div>
        <a class="button" href="contact.php">Ask for a free quote <span aria-hidden="true">&rarr;</span></a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
