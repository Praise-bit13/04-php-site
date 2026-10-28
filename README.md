# Prime Cleaners Ltd

A responsive, multi-page website for a fictional cleaning business, built as a PHP 8 learning project. It includes shared page templates, data-driven services and team members, a validated contact form, and a password-protected local page for reviewing submissions.

## Features

- Shared configuration, header, footer, and navigation across pages
- Responsive Home, About, Services, Service Detail, and Contact pages
- Services and team content stored in PHP arrays and rendered dynamically
- Contact form with server-side validation, sticky values, CSRF token, and JSON Lines storage
- Local messages viewer with newest-first sorting, escaped table output, and a count badge
- Responsive CSS styling and accessible navigation/form labels

## Tech stack

- PHP 8
- HTML5
- CSS3
- Apache via XAMPP
- JSON Lines (`.jsonl`) for local contact form submissions

## Run with XAMPP

1. Install and start **Apache** in the XAMPP Control Panel.
2. Make sure the project folder is located at:

   ```text
   C:\xampp\htdocs\swd\04-php-site
   ```

3. Open the site at:

   ```text
   http://localhost/swd/04-php-site/
   ```

4. Visit the contact page to submit a message:

   ```text
   http://localhost/swd/04-php-site/contact.php
   ```

5. To view locally stored submissions, open:

   ```text
   http://localhost/swd/04-php-site/messages.php
   ```

   The local learning password is set in `includes/config.php` as `$messagesPagePassword`. Change the example value before using the page, even locally.

## Project structure

```text
04-php-site/
├── about.php
├── contact.php
├── index.php
├── messages.php
├── service.php
├── services.php
├── README.md
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
    └── messages.jsonl  (created when the first contact form message is saved)
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
- **One thing I would improve next:** [Your idea]
