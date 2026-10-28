<?php
declare(strict_types=1);

$siteName = 'Prime Cleaners Ltd';
$tagline = 'A brighter, fresher space — without the hassle.';
$contactEmail = 'hello@primecleaners.example';
$messagesPagePassword = 'change-this-local-password';
$mailtrapHost = getenv('MAILTRAP_HOST') ?: 'sandbox.smtp.mailtrap.io';
$mailtrapPort = (int) (getenv('MAILTRAP_PORT') ?: 2525);
$mailtrapUsername = getenv('MAILTRAP_USERNAME') ?: '';
$mailtrapPassword = getenv('MAILTRAP_PASSWORD') ?: '';
$mailFromAddress = getenv('MAIL_FROM_ADDRESS') ?: '';
$mailToAddress = getenv('MAIL_TO_ADDRESS') ?: $contactEmail;

$navItems = [
    'Home' => 'index.php',
    'About' => 'about.php',
    'Services' => 'services.php',
    'Contact' => 'contact.php',
];
