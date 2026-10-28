<?php
declare(strict_types=1);

$pageTitle = 'Home';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="container hero-content">
        <p class="eyebrow">Cleaning that feels good</p>
        <h1>A clean space.<br><span>A clearer mind.</span></h1>
        <p class="hero-copy">Reliable, thoughtful cleaning for homes and workplaces. Let us take care of the mess while you get on with what matters.</p>
        <a class="button" href="contact.php">Get a free quote <span aria-hidden="true">&rarr;</span></a>
        <p class="hero-note">Friendly local team <span aria-hidden="true">&bull;</span> Flexible bookings <span aria-hidden="true">&bull;</span> Care in every detail</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">A little more breathing room</p>
            <h2>More time for your kind of clean.</h2>
            <p>From a weekly refresh to a deep seasonal clean, our team makes it easy to enjoy a space that feels cared for.</p>
        </div>
        <div class="card-grid">
            <article class="card">
                <span class="card-number">01</span>
                <h3>For your home</h3>
                <p>Thoughtful regular and one-off cleaning, shaped around your home and routine.</p>
                <a class="text-link" href="services.php">Explore home cleaning <span aria-hidden="true">&rarr;</span></a>
            </article>
            <article class="card">
                <span class="card-number">02</span>
                <h3>For your workplace</h3>
                <p>A fresh, welcoming office helps your team and visitors feel right at home.</p>
                <a class="text-link" href="services.php">Explore office cleaning <span aria-hidden="true">&rarr;</span></a>
            </article>
            <article class="card">
                <span class="card-number">03</span>
                <h3>For the big moments</h3>
                <p>Moving in or out? Our detailed deep cleans help make the transition simpler.</p>
                <a class="text-link" href="services.php">See all services <span aria-hidden="true">&rarr;</span></a>
            </article>
        </div>
    </div>
</section>

<section class="promise">
    <div class="container promise-inner">
        <div>
            <p class="eyebrow">The Prime promise</p>
            <h2>Good people.<br>Great clean.</h2>
        </div>
        <p>We believe a great clean starts with listening. You tell us what matters, we bring the care and consistency, and together we make a space you love coming back to.</p>
        <a class="button button-light" href="about.php">Get to know us <span aria-hidden="true">&rarr;</span></a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
