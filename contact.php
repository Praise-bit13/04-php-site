<?php
declare(strict_types=1);

$pageTitle = 'Contact';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">We'd love to hear from you</p>
        <h1>Let's make your space shine.</h1>
        <p>Tell us what you have in mind and we'll get back to you to talk through the next steps.</p>
    </div>
</section>

<section class="section">
    <div class="container contact-layout">
        <div>
            <p class="eyebrow">Get in touch</p>
            <h2>There's no such thing as a silly question.</h2>
            <p>Whether you know exactly what you need or just want to explore your options, drop us a line. We're happy to help.</p>
            <div class="contact-detail">
                <span class="detail-label">Email</span>
                <a href="mailto:<?= e($contactEmail) ?>"><?= e($contactEmail) ?></a>
            </div>
            <div class="contact-detail">
                <span class="detail-label">When we're available</span>
                <p>Monday to Friday, 9:00 am – 5:00 pm</p>
            </div>
        </div>
        <aside class="contact-note">
            <span class="note-mark" aria-hidden="true">“</span>
            <h3>A clean start begins with a conversation.</h3>
            <p>Email us with a few details about your space, the service you're interested in and a good time to reach you.</p>
            <a class="button" href="mailto:<?= e($contactEmail) ?>">Email Prime Cleaners <span aria-hidden="true">&rarr;</span></a>
        </aside>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
