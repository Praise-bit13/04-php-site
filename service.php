<?php
declare(strict_types=1);

$pageTitle = 'Service';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';

$slug = filter_input(INPUT_GET, 'slug', FILTER_UNSAFE_RAW);
$service = null;

if (is_string($slug)) {
    foreach ($services as $serviceItem) {
        if ($serviceItem['slug'] === $slug) {
            $service = $serviceItem;
            $pageTitle = $serviceItem['title'];
            break;
        }
    }
}

if ($service === null) {
    http_response_code(404);
    $pageTitle = 'Service not found';
}

require_once __DIR__ . '/includes/header.php';
?>

<?php if ($service === null): ?>
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">A little detour</p>
            <h1>We couldn't find that service.</h1>
            <p>It may have moved or the link may be incorrect. Browse our services to see how we can help.</p>
            <a class="button" href="services.php">Browse services <span aria-hidden="true">&rarr;</span></a>
        </div>
    </section>
<?php else: ?>
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">Prime Cleaners service</p>
            <h1><?= e($service['title']) ?></h1>
            <p><?= e($service['description']) ?></p>
        </div>
    </section>
    <section class="section">
        <div class="container service-detail">
            <span class="service-detail-icon" aria-hidden="true"><?= e($service['icon']) ?></span>
            <div>
                <p class="eyebrow">A fresh start for your space</p>
                <h2><?= e($service['title']) ?></h2>
                <p><?= e($service['description']) ?></p>
                <p class="service-detail-price">From <?= e(formatPrice((float) $service['price'])) ?></p>
                <a class="button" href="contact.php">Ask us for a quote <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
