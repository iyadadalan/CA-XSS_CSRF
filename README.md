# CA-XSS_CSRF

# Project Security Enhancements

This document outlines the security enhancements implemented in the project to comply with the best practices for web application security. The requirements are for this assignment are:

1. Your web application must comply to same origin policy with content security policy (CSP) implementation.
2. Implement XSS defense for your web application. Please refer to your handout on XSS Defense.
3. Implement Better CSRF defenses for your web application. Refer to your handout on CSRF defenses.  

## Content Security Policy (CSP)

To comply with the Same Origin Policy and enhance security, a strict Content Security Policy (CSP) has been implemented across all pages of the web application.

**Example from `login_stud.php` and other files:**
```php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://ajax.googleapis.com https://maxcdn.bootstrapcdn.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://maxcdn.bootstrapcdn.com; img-src 'self' data:; object-src 'none';");
```
This CSP ensures that only scripts, styles, and other resources from the same origin or defined trusted sources are allowed to load, thereby mitigating potential XSS attacks.

## XSS Defense

Input sanitization has been implemented to defend against XSS attacks. All inputs from users are sanitized before being rendered on the browser.

**Example from `stud_details.js`:**
```javascript
function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
```
The `escapeHtml` function prevents malicious script execution by escaping HTML special characters from user inputs.

## CSRF Defense

CSRF protection has been enhanced to secure form submissions across the application. A CSRF token is generated, stored in the session, and verified on each form submission.

**Example from `edit_student.php`:**
```php
// Generate CSRF token if not already set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Verify CSRF token on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed.');
    }
}
```
Each form includes a hidden CSRF token that is verified against the session-stored token upon submission.

**Form inclusion example from `edit_student.php`:**
```php
<form action="edit_student.php" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <!-- Form fields -->
</form>
```
These enhancements ensure that the application is secure against common web vulnerabilities such as XSS and CSRF, complying with modern web security standards.
