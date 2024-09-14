
# KrateCMS Wiki

## Overview
**KrateCMS** is a custom-built content management system (CMS) that allows users to manage and organize their data, such as contacts and a vinyl records collection. Inspired by the idea of a crate storing music records, KrateCMS is built with a focus on simplicity, flexibility, and customization, using PHP for the backend.

## Table of Contents
1. [Getting Started](#getting-started)
2. [Features](#features)
3. [Architecture](#architecture)
4. [Development Guidelines](#development-guidelines)
5. [Modules](#modules)
6. [Contributing](#contributing)
7. [Future Roadmap](#future-roadmap)
8. [Support](#support)

## Getting Started
To get started with KrateCMS, you'll need to have the following prerequisites installed on your local or server environment:
- **PHP 7.4 or higher**
- **MySQL 8.0**
- **Composer** (for dependency management)
- **Postmark** (for sending email notifications)

### Installation Steps:
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/your-username/KrateCMS.git
   cd KrateCMS
   ```
2. **Install Dependencies**:
   Run Composer to install the required dependencies:
   ```bash
   composer install
   ```
3. **Set Up Database**:
   - Create a MySQL database.
   - Import the provided `kratecms.sql` file to create the necessary tables.
   - Update the `.env` file with your database credentials.

4. **Run Locally**:
   Use a tool like [Local by Flywheel](https://localwp.com) or DDEV to run the project locally:
   ```bash
   php -S localhost:8000 -t public
   ```

5. **Access the CMS**:
   Navigate to `http://localhost:8000` in your browser.

## Features
- **User Management**: Add, edit, delete, and view users with role-based access control.
- **Vinyl Records Collection**: Manage a custom collection of vinyl records, including features like BPM counting and external link references.
- **Contact Management**: Store and manage contact information, including a feature for favoriting specific contacts.
- **Email Notifications**: Send email notifications using Postmark.
- **Customizable Content**: Add pages such as "History" and "About" with placeholder content.

## Architecture
KrateCMS follows a custom-built architecture, currently being refactored into an MVC pattern for improved maintainability.

### MVC Structure (Work in Progress):
- **Model**: Manages database interactions (e.g., `User.php`, `VinylRecord.php`).
- **View**: Twig templates for rendering the front-end (e.g., `user_form.twig`, `records_list.twig`).
- **Controller**: Handles the logic for processing requests and interacting with models (e.g., `UserController.php`, `VinylController.php`).

### File Structure:
```
/src
  /models
    User.php
    VinylRecord.php
  /controllers
    UserController.php
    VinylController.php
  /views
    user_form.twig
    records_list.twig
/public
  /css
  /js
  index.php
```

## Development Guidelines

### Coding Standards:
- Use **PSR-4** autoloading and follow best practices for PHP development.
- Always use **namespaces** for your classes.
- Follow **MVC** principles when developing new features.

### Branching Strategy:
- Use **Git** for version control.
- **Main Branch**: Stable releases.
- **Develop Branch**: Active development, feature branches should branch off from here.
- **Feature Branches**: Create separate branches for each feature, prefixed with `feature/`.

### Setting Up Postmark for Emails:
- You’ll need to set up your Postmark API key in the `.env` file:
   ```bash
   POSTMARK_API_KEY=your-api-key
   ```
- Use the `EmailManager` class in the `/src/classes/EmailManager.php` to send transactional emails.

## Modules

### 1. User Management
The **User Management** module allows administrators to manage users of KrateCMS. Features include:
- Adding new users
- Editing user information
- Deleting users
- Role-based permissions: Administrator, Manager, Standard User, Guest

### 2. Vinyl Records Collection
The **Vinyl Records Collection** module provides a way to manage vinyl records. Features include:
- Adding, updating, and deleting records
- Uploading images for the front and back covers of records
- Linking to external sites (e.g., purchase sites, audio files)

### 3. Contact Management
The **Contact Management** module allows users to store contact information and favorite important contacts for easy access.

## Contributing
KrateCMS is a work in progress, and contributions are welcome! To contribute:
1. Fork the repository.
2. Create a new branch: `git checkout -b feature/your-feature`.
3. Make your changes and test thoroughly.
4. Submit a pull request.

## Future Roadmap

Here’s what’s planned for the future of KrateCMS:
1. **Complete MVC Refactor**: Continue refactoring the entire app to follow the MVC pattern for scalability and maintainability.
2. **Add Laravel Integration**: Begin migrating to Laravel, starting with user management.
3. **React Integration**: Build a React front-end for improved user interactivity and experience.
4. **API Development**: Develop a REST API to allow external services to integrate with KrateCMS.
5. **Improved Vinyl Management**: Add support for more vinyl metadata and detailed analytics on record collections.
6. **Multi-Language Support**: Add internationalization features for a global audience.

## Support
For any issues or questions, feel free to open a GitHub issue or reach out to the admin via email:
- **Admin Email**: jabal@fivetwofive.com
