# Prime Cleaners Ltd

A responsive, multi-page website for a fictional cleaning business, built as a PHP 8 learning project. It includes shared page templates, data-driven services and team members, a validated contact form, and a password-protected local page for reviewing submissions.

## Features

- Shared configuration, header, footer, and navigation across pages
- Responsive Home, About, Services, Service Detail, and Contact pages
- Services and team content stored in PHP arrays and rendered dynamically
- Contact form with server-side validation, sticky values, CSRF token, and JSON Lines storage
- Contact email notifications using PHPMailer and Mailtrap SMTP
- Local messages viewer with newest-first sorting, escaped table output, and a count badge
- File-based per-page view counter
- Responsive CSS styling and accessible navigation/form labels

## Tech stack

- PHP 8
- HTML5
- CSS3
- Apache via XAMPP
- Composer and PHPMailer
- Mailtrap SMTP sandbox
- JSON Lines (`.jsonl`) for local contact form submissions
- JSON file for page-view counts

## Run with XAMPP

1. Install and start **Apache** in the XAMPP Control Panel.
2. Install Composer if it is not already installed.
3. Make sure the project folder is located at:

   ```text
   C:\xampp\htdocs\swd\04-php-site
   ```

4. Open a terminal in the project folder and install the PHP dependencies:

   ```text
   cd C:\xampp\htdocs\swd\04-php-site
   composer install
   ```

   If Composer reports that the Zip extension is missing, open `C:\xampp\php\php.ini`, uncomment `extension=zip`, save the file, restart Apache, and run `composer install` again.

5. Open the site at:

   ```text
   http://localhost/swd/04-php-site/
   ```

6. Visit the contact page to submit a message:

   ```text
   http://localhost/swd/04-php-site/contact.php
   ```

7. To view locally stored submissions, open:

   ```text
   http://localhost/swd/04-php-site/messages.php
   ```

   The local learning password is set in `includes/config.php` as `$messagesPagePassword`. Change the example value before using the page, even locally.

## Configure Mailtrap email

1. Create a Mailtrap account and open an **Email Sandbox** inbox. Use the SMTP host and credentials shown in that inbox.
2. Configure these environment variables for the Apache process, replacing the example values with your Mailtrap details:

   ```text
   MAILTRAP_HOST=sandbox.smtp.mailtrap.io
   MAILTRAP_PORT=2525
   MAILTRAP_USERNAME=your-mailtrap-username
   MAILTRAP_PASSWORD=your-mailtrap-password
   MAIL_FROM_ADDRESS=sender@example.com
   MAIL_TO_ADDRESS=your-inbox@example.com
   ```

   In a local XAMPP setup, you can add `SetEnv NAME "value"` lines for these settings to Apache's configuration, then restart Apache. Keep real credentials out of this project and out of version control. `MAIL_TO_ADDRESS` is the notification recipient; check the Mailtrap inbox to view sandbox emails.
3. Submit the contact form. The message is saved to `storage/messages.jsonl` and the email notification is sent through Mailtrap. If Mailtrap is missing or unavailable, the page reports that the message was saved but the notification could not be sent.

The footer counter records views separately for each PHP page in `storage/page-views.json`. These local files are ignored by Git and blocked from direct HTTP access by `storage/.htaccess`.

## Project structure

```text
04-php-site/
├── .gitignore
├── about.php
├── composer.json
├── composer.lock  (created by Composer when dependencies are installed)
├── contact.php
├── index.php
├── messages.php
├── README.md
├── service.php
├── services.php
├── assets/
│   └── css/
│       └── style.css
├── includes/
│   ├── config.php
│   ├── data.php
│   ├── footer.php
│   ├── functions.php
│   └── header.php
└── storage/
    ├── .htaccess
    ├── messages.jsonl  (created when the first contact form message is saved)
    └── page-views.json  (created when a PHP page is viewed)
```

## Local submissions password warning

The password-protected messages page is a small learning example, **not production authentication**. Its password is hard-coded in a PHP configuration file, has no rate limiting, and does not provide user accounts, password hashing/rotation workflows, or an audit trail. The `.htaccess` file helps prevent Apache from serving the JSONL file directly, but it does not replace proper access controls or secure server configuration. Do not deploy this password gate or store real customer data on a public server. A production system should use proper authentication, hashed credentials stored outside the web root, HTTPS, rate limiting, and appropriately protected database/file storage.

## What I learned

Fill in these reflections as you work through the project:

- **PHP includes and reusable layouts:** [What did you learn?]
- **Arrays, loops, and dynamic pages:** [What did you learn?]
- **Form handling and server-side validation:** [What did you learn?]
- **Sessions and CSRF tokens:** [What did you learn?]
- **Safe output and escaping:** [What did you learn?]
- **Reading and writing JSON Lines files:** [What did you learn?]
- **Sending email with PHPMailer and Mailtrap:** [What did you learn?]
- **Tracking page views with a file:** [What did you learn?]
- **Using Composer to install a library:** [What did you learn?]
- **One thing I would improve next:** [Your idea]
