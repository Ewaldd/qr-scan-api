# Example Laravel API Project

## Features

- **User Authentication**: Includes registration and login with token-based authentication using **Laravel Sanctum**.
- **QR Scan Management**: Users can create, view, update, and delete their QR code scans.
- **Testing**: Includes feature tests for registration, login, and QR scan management using **Pest**.

## Routes
### Authentication Routes
-  POST /api/auth/register - Registers a new user.
- POST /api/auth/login - Logs in a user and returns an API token.
### QR Scan Routes (Authenticated)
- GET /api/v1/qr-scan - Retrieves a list of QR scans associated with the logged-in user.
- POST /api/v1/qr-scan - Creates a new QR scan.
- GET /api/v1/qr-scan/{id} - Retrieves a specific QR scan by its ID.
- PUT /api/v1/qr-scan/{id} - Updates a QR scan.
- DELETE /api/v1/qr-scan/{id} - Deletes a QR scan.

## Libraries Used
- Laravel Sanctum: Lightweight authentication system for SPAs and simple API token usage.
- SimpleQRCode: Package for generating QR codes in Laravel.
- Pest: A testing framework for PHP that provides a simpler and more expressive syntax compared to PHPUnit.
