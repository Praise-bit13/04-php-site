<?php
declare(strict_types=1);

session_start();

$pageTitle = 'Messages';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

if (!isset($_SESSION['messages_csrf_token']) || !is_string($_SESSION['messages_csrf_token'])) {
    $_SESSION['messages_csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['messages_csrf_token'];
$loginError = '';
$isAuthenticated = ($_SESSION['messages_authenticated'] ?? false) === true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($postedToken) || !hash_equals($csrfToken, $postedToken)) {
        $loginError = 'Your session expired. Refresh the page and try again.';
    } elseif (($_POST['action'] ?? '') === 'logout') {
        unset($_SESSION['messages_authenticated']);
        header('Location: messages.php');
        exit;
    } elseif (!$isAuthenticated) {
        $password = $_POST['password'] ?? '';

        if (is_string($password) && hash_equals($messagesPagePassword, $password)) {
            session_regenerate_id(true);
            $_SESSION['messages_authenticated'] = true;
            header('Location: messages.php');
            exit;
        }

        $loginError = 'The password was not correct. Please try again.';
    }
}

$isAuthenticated = ($_SESSION['messages_authenticated'] ?? false) === true;
$messages = [];
$readError = '';

if ($isAuthenticated) {
    $messagesFile = __DIR__ . '/storage/messages.jsonl';

    if (is_file($messagesFile)) {
        $fileContents = file_get_contents($messagesFile);
        if ($fileContents === false) {
            error_log('Messages page could not read storage/messages.jsonl.');
            $readError = 'Messages could not be loaded. Check that the storage file is readable.';
        } else {
            foreach (preg_split('/\R/', $fileContents) as $lineNumber => $line) {
                if (trim($line) === '') {
                    continue;
                }

                try {
                    $message = json_decode($line, true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $exception) {
                    error_log('Messages page skipped invalid JSON on line ' . ($lineNumber + 1) . '.');
                    continue;
                }

                if (is_array($message)) {
                    $messages[] = $message;
                } else {
                    error_log('Messages page skipped a non-object JSON value on line ' . ($lineNumber + 1) . '.');
                }
            }

            usort($messages, static function (array $first, array $second): int {
                $firstTime = strtotime(is_string($first['timestamp'] ?? null) ? $first['timestamp'] : '') ?: 0;
                $secondTime = strtotime(is_string($second['timestamp'] ?? null) ? $second['timestamp'] : '') ?: 0;

                return $secondTime <=> $firstTime;
            });
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Local learning tool</p>
        <h1>Contact submissions</h1>
        <p>Review messages sent through the Prime Cleaners contact form.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!$isAuthenticated): ?>
            <div class="messages-login">
                <h2>Enter the local page password</h2>
                <p>This page is for local learning use. Do not expose it on a public server.</p>
                <?php if ($loginError !== ''): ?>
                    <div class="form-alert form-alert-error" role="alert"><?= e($loginError) ?></div>
                <?php endif; ?>
                <form class="contact-form" method="post" action="messages.php">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    <div class="form-field">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required>
                    </div>
                    <button class="button" type="submit">View messages <span aria-hidden="true">&rarr;</span></button>
                </form>
            </div>
        <?php else: ?>
            <div class="messages-heading">
                <div>
                    <p class="eyebrow">Inbox</p>
                    <h2>Recent submissions <span class="count-badge"><?= count($messages) ?></span></h2>
                </div>
                <form method="post" action="messages.php">
                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                    <input type="hidden" name="action" value="logout">
                    <button class="button button-outline" type="submit">Log out</button>
                </form>
            </div>

            <?php if ($readError !== ''): ?>
                <div class="form-alert form-alert-error" role="alert"><?= e($readError) ?></div>
            <?php elseif ($messages === []): ?>
                <p class="empty-state">There are no contact submissions yet.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="messages-table">
                        <thead>
                            <tr>
                                <th scope="col">Received</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Service</th>
                                <th scope="col">Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?= e(is_string($message['timestamp'] ?? null) ? $message['timestamp'] : 'Unknown') ?></td>
                                    <td><?= e(is_string($message['name'] ?? null) ? $message['name'] : '—') ?></td>
                                    <td><?= e(is_string($message['email'] ?? null) ? $message['email'] : '—') ?></td>
                                    <td><?= e(is_string($message['phone'] ?? null) && $message['phone'] !== '' ? $message['phone'] : '—') ?></td>
                                    <td><?= e(is_string($message['service'] ?? null) ? $message['service'] : '—') ?></td>
                                    <td class="message-cell"><?= e(is_string($message['message'] ?? null) ? $message['message'] : '—') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
