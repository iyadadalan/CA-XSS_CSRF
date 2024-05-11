# CA-XSS_CSRF

## Overview
This project implements a secure student management system that allows users to login, sign up, view, and edit student details. The system is designed to be secure against common web vulnerabilities such as XSS and CSRF.

## Security Features

### 1. Content Security Policy (CSP)
The application enforces a strict Content Security Policy (CSP) to mitigate the risk of XSS attacks by restricting the sources from which content can be loaded. The CSP is configured as follows:

- **Default Source**: Only allow content from the same origin.
- **Script Source**: Scripts are allowed from the same origin and trusted sources such as Google APIs and Bootstrap CDN.
- **Style Source**: Styles are allowed from the same origin, with unsafe inline styles enabled for trusted sources.
- **Image Source**: Only allow images from the same origin.
- **Object Source**: All object sources are blocked.

### 2. XSS Defense
All output to HTML (e.g., user inputs that are displayed on pages like view and edit student details) are sanitized using PHP's `htmlspecialchars()` function to prevent XSS attacks. Additionally, all form inputs are validated using custom JavaScript functions to ensure that only valid data is processed.

### 3. CSRF Defense
Cross-Site Request Forgery (CSRF) protections are implemented by using a token-based verification system. Each form submission includes a unique CSRF token that must match a token stored in the user's session. This token is verified on the server side before any form processing is allowed.

## File Specific Details

### login_stud.php
- Implements user login functionality.
- Validates the user session for CSRF protection.
- Redirects to the student details page upon successful login.

### signup_stud.php
- Handles new user registrations.
- Incorporates CSRF tokens to secure form submissions against CSRF attacks.

### stud_details.php
- Displays form for entering and modifying student details.
- Includes server-side and client-side validations to prevent XSS and ensure data integrity.

### stud_process.php
- Processes the student details submitted from `stud_details.php`.
- Validates CSRF tokens and sanitizes inputs to prevent CSRF and XSS.

### view_stud_details.php
- Displays all registered student details.
- Links to `edit_student.php` with CSRF tokens embedded in requests to ensure secure data modification operations.

### stud_details.js
- Provides client-side validation functions (`validate_stud()`) to check form inputs against specified patterns.
- Sanitizes inputs to prevent XSS attacks in real-time before submission.

## Conclusion
This student management system is built with security as a priority, employing robust measures to protect against XSS and CSRF, and enforcing policies that comply with the same origin policy. The implementation of these security features aligns with current best practices for web application security.
