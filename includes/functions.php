<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function formatPrice(float $amount): string
{
    return '₦' . number_format($amount, 2);
}

function renderServiceCard(array $service): string
{
    $slug = e((string) $service['slug']);
    $title = e((string) $service['title']);
    $description = e((string) $service['description']);
    $price = e(formatPrice((float) $service['price']));
    $icon = e((string) $service['icon']);

    return <<<HTML
        <article class="service-card">
            <span class="service-card-icon" aria-hidden="true">{$icon}</span>
            <h2>{$title}</h2>
            <p>{$description}</p>
            <p class="service-card-price">From {$price}</p>
            <a class="text-link" href="service.php?slug={$slug}">View service <span aria-hidden="true">&rarr;</span></a>
        </article>
        HTML;
}

function sendContactEmail(array $submission): void
{
    global $mailtrapHost, $mailtrapPort, $mailtrapUsername, $mailtrapPassword, $mailFromAddress, $mailToAddress;

    $autoloadFile = __DIR__ . '/../vendor/autoload.php';
    if (!is_file($autoloadFile)) {
        throw new RuntimeException('PHPMailer is not installed. Run composer install in the project folder.');
    }

    require_once $autoloadFile;

    if (
        $mailtrapUsername === ''
        || $mailtrapPassword === ''
        || $mailFromAddress === ''
        || $mailToAddress === ''
    ) {
        throw new RuntimeException('Mailtrap is not configured. Set the required Mailtrap environment variables.');
    }

    $mailer = new \PHPMailer\PHPMailer\PHPMailer(true);
    $mailer->isSMTP();
    $mailer->Host = $mailtrapHost;
    $mailer->SMTPAuth = true;
    $mailer->Username = $mailtrapUsername;
    $mailer->Password = $mailtrapPassword;
    $mailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mailer->Port = $mailtrapPort;
    $mailer->CharSet = 'UTF-8';
    $mailer->setFrom($mailFromAddress, 'Prime Cleaners Ltd');
    $mailer->addAddress($mailToAddress);
    $mailer->addReplyTo((string) $submission['email']);
    $mailer->isHTML(false);
    $mailer->Subject = 'New contact form message';
    $mailer->Body = implode(PHP_EOL, [
        'Name: ' . (string) $submission['name'],
        'Email: ' . (string) $submission['email'],
        'Phone: ' . ((string) $submission['phone'] !== '' ? (string) $submission['phone'] : 'Not provided'),
        'Service: ' . (string) $submission['service'],
        '',
        'Message:',
        (string) $submission['message'],
    ]);

    $mailer->send();
}

function incrementPageView(string $page, string $storageDirectory): int
{
    if (
        !is_dir($storageDirectory)
        && !mkdir($storageDirectory, 0755, true)
        && !is_dir($storageDirectory)
    ) {
        throw new RuntimeException('Could not create the page-view storage directory.');
    }

    $counterFile = $storageDirectory . '/page-views.json';
    $handle = fopen($counterFile, 'c+');
    if ($handle === false) {
        throw new RuntimeException('Could not open the page-view counter file.');
    }

    try {
        if (!flock($handle, LOCK_EX)) {
            throw new RuntimeException('Could not lock the page-view counter file.');
        }

        rewind($handle);
        $contents = stream_get_contents($handle);
        if ($contents === false) {
            throw new RuntimeException('Could not read the page-view counter file.');
        }

        $counters = $contents === '' ? [] : json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($counters)) {
            throw new RuntimeException('The page-view counter file does not contain a JSON object.');
        }

        $currentCount = $counters[$page] ?? 0;
        if (!is_int($currentCount) || $currentCount < 0) {
            throw new RuntimeException('The page-view count is invalid.');
        }

        $counters[$page] = $currentCount + 1;
        $encodedCounters = json_encode($counters, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);

        if (!ftruncate($handle, 0) || rewind($handle) === false) {
            throw new RuntimeException('Could not update the page-view counter file.');
        }

        $bytesWritten = fwrite($handle, $encodedCounters);
        if ($bytesWritten !== strlen($encodedCounters) || !fflush($handle)) {
            throw new RuntimeException('Could not save the page-view counter.');
        }

        return $counters[$page];
    } finally {
        flock($handle, LOCK_UN);
        fclose($handle);
    }
}
