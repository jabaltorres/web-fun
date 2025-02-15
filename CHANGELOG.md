# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


# [Unreleased]

## [0.1.1] - 2025-02-15

### Added
- Implemented MVC architecture:
  - Created RecordService class for business logic
  - Added proper model methods and type hints
  - Implemented service container pattern
- Added new record management endpoints:
  - /records/add.php for creating records
  - /records/edit.php for updating records
  - /records/delete.php for removing records
  - /records/details.php for viewing records
- Added comprehensive error handling in services
- Implemented proper file upload management
- Added type declarations and return types
- New SessionHelper methods:
  - `set()` for setting session variables
  - `get()` for retrieving session values
  - `has()` for checking session variable existence
  - `remove()` for removing session variables
  - `clear()` for clearing all session data
- Proper error handling and logging across all files
- Consistent service usage through dependency injection
- Bootstrap integration across all files

### Changed
- Migrated from initialize.php to bootstrap.php for better dependency management
- Refactored database operations into service layer
- Moved record-related files to dedicated /records directory
- Updated file paths to use __DIR__ for reliability
- Improved form handling with proper validation
- Enhanced image file management with cleanup
- Updated URL generation for new file structure
- Refactored multiple PHP files to use new service architecture:
  - public/admin/index.php
  - public/users/login.php
  - public/users/logout.php
  - public/records/add.php
  - public/records/edit.php
  - public/records/delete.php
  - public/records/details.php
  - public/sandbox/index.php

- Updated service usage:
  - Replaced static helper calls with service instances
  - Moved from direct class instantiation to container-based dependency injection
  - Switched to proper URL generation with urlHelper->urlFor()
  - Implemented consistent HTML escaping with htmlHelper
  - Used sessionHelper for session management
  - Used requestHelper for form handling

- Code Style Improvements:
  - Converted snake_case to camelCase for variable names
  - Added proper type hints and return types
  - Improved code organization and readability
  - Added consistent error handling patterns
  - Implemented proper path handling using ROOT_PATH constant

### Removed
- Deprecated record-add.php, record-edit.php, record-delete.php, and record-details.php
- Removed direct database operations from view files
- Static helper method calls
- Direct file inclusions in favor of bootstrap
- Direct class instantiations
- Legacy initialization files

### Security
- Added login state verification for sensitive operations
- Improved input validation and sanitization
- Enhanced error handling and logging
- Added proper parameter binding for database operations
- Added proper HTML escaping throughout
- Improved session handling security
- Added CSRF protection through bootstrap
- Improved form validation and sanitization
- Better error handling and logging

## [0.1.0] - 2024-02-13

### Added
- Integrated Twig templating engine
- Created new directory structure for templates
- Added base template layout (`templates/layouts/base.twig`)
- Created test page as template example (`public/test.php`)
- Added error handling template (`templates/errors/500.twig`)
- Added common components:
  - Header (`templates/components/header.twig`)
  - Footer (`templates/components/footer.twig`)
  - CSRF token (`templates/components/csrf_token.twig`)
- Implemented initialization file (`src/initialize.php`) with:
  - Twig configuration
  - CSRF protection
  - Database connection handling
  - Session management

### Changed
- Restructured project directories to accommodate Twig templates
- Updated WWW_ROOT definition to handle edge cases

### Security
- Added CSRF protection for forms
- Implemented proper error handling and logging
- Added secure session management 