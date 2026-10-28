<?php
declare(strict_types=1);

session_start();

$pageTitle = 'Contact';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';

if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];
$errors = [];
$values = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'service' => '',
    'message' => '',
];
$isSent = isset($_GET['sent']) && $_GET['sent'] === '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $field => $defaultValue) {
        $postedValue = $_POST[$field] ?? '';
        $values[$field] = is_string($postedValue) ? trim($postedValue) : '';
    }

    $postedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($postedToken) || !hash_equals($csrfToken, $postedToken)) {
        $errors['csrf'] = 'Your form session expired. Please check the form and submit it again.';
    }

    if ($values['name'] === '') {
        $errors['name'] = 'Please enter your name.';
    }

    if ($values['email'] === '') {
        $errors['email'] = 'Please enter your email address.';
    } elseif (filter_var($values['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    $selectedService = null;
    foreach ($services as $serviceItem) {
        if ($serviceItem['slug'] === $values['service']) {
            $selectedService = $serviceItem;
            break;
        }
    }

    if ($values['service'] === '') {
        $errors['service'] = 'Please choose a service.';
    } elseif ($selectedService === null) {
        $errors['service'] = 'Please choose a valid service from the list.';
    }

    $messageCharacterCount = preg_match_all('/./us', $values['message'], $messageCharacters);
    if ($messageCharacterCount === false || $messageCharacterCount < 10 || $messageCharacterCount > 1000) {
        $errors['message'] = 'Your message must be between 10 and 1,000 characters.';
    }

    if ($errors === []) {
        $submission = [
            'timestamp' => date(DATE_ATOM),
            'name' => $values['name'],
            'email' => $values['email'],
            'phone' => $values['phone'],
            'service' => $selectedService['slug'],
            'message' => $values['message'],
        ];
        $json = json_encode($submission, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $storageDirectory = __DIR__ . '/storage';
        $storageFile = $storageDirectory . '/messages.jsonl';

        if ($json === false) {
            error_log('Contact form submission could not be encoded as JSON.');
            $errors['form'] = 'We could not save your message right now. Please try again later.';
        } elseif (
            !is_dir($storageDirectory)
            && !mkdir($storageDirectory, 0755, true)
            && !is_dir($storageDirectory)
        ) {
            error_log('Contact form storage directory could not be created.');
            $errors['form'] = 'We could not save your message right now. Please try again later.';
        } else {
            $jsonLine = $json . PHP_EOL;
            $bytesWritten = file_put_contents($storageFile, $jsonLine, FILE_APPEND | LOCK_EX);

            if ($bytesWritten !== strlen($jsonLine)) {
                error_log('Contact form submission could not be fully written to storage.');
                $errors['form'] = 'We could not save your message right now. Please try again later.';
            } else {
                header('Location: contact.php?sent=1');
                exit;
            }
        }
    }
}

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

            <?php if ($isSent): ?>
                <div class="form-alert form-alert-success" role="status">
                    Thanks for getting in touch. Your message has been received.
                </div>
            <?php endif; ?>

            <form class="contact-form" method="post" action="contact.php" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

                <?php if (isset($errors['csrf'])): ?>
                    <div class="form-alert form-alert-error" role="alert"><?= e($errors['csrf']) ?></div>
                <?php endif; ?>
                <?php if (isset($errors['form'])): ?>
                    <div class="form-alert form-alert-error" role="alert"><?= e($errors['form']) ?></div>
                <?php endif; ?>

                <div class="form-field">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                           value="<?= e($values['name']) ?>"
                           <?= isset($errors['name']) ? 'aria-invalid="true" aria-describedby="name-error"' : '' ?>>
                    <?php if (isset($errors['name'])): ?>
                        <p class="field-error" id="name-error"><?= e($errors['name']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           value="<?= e($values['email']) ?>"
                           <?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="email-error"' : '' ?>>
                    <?php if (isset($errors['email'])): ?>
                        <p class="field-error" id="email-error"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="phone">Phone <span class="optional-label">(optional)</span></label>
                    <input id="phone" name="phone" type="tel" autocomplete="tel"
                           value="<?= e($values['phone']) ?>">
                </div>

                <div class="form-field">
                    <label for="service">Service</label>
                    <select id="service" name="service" required
                            <?= isset($errors['service']) ? 'aria-invalid="true" aria-describedby="service-error"' : '' ?>>
                        <option value="">Choose a service</option>
                        <?php foreach ($services as $serviceItem): ?>
                            <option value="<?= e($serviceItem['slug']) ?>" <?= $values['service'] === $serviceItem['slug'] ? 'selected' : '' ?>>
                                <?= e($serviceItem['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['service'])): ?>
                        <p class="field-error" id="service-error"><?= e($errors['service']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" required
                              aria-describedby="<?= isset($errors['message']) ? 'message-hint message-error' : 'message-hint' ?>"
                              <?= isset($errors['message']) ? 'aria-invalid="true"' : '' ?>><?= e($values['message']) ?></textarea>
                    <p class="field-hint" id="message-hint">Please use 10 to 1,000 characters.</p>
                    <?php if (isset($errors['message'])): ?>
                        <p class="field-error" id="message-error"><?= e($errors['message']) ?></p>
                    <?php endif; ?>
                </div>

                <button class="button" type="submit">Send message <span aria-hidden="true">&rarr;</span></button>
            </form>
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
