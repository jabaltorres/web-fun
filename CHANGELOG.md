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

### Changed
- Migrated from initialize.php to bootstrap.php for better dependency management
- Refactored database operations into service layer
- Moved record-related files to dedicated /records directory
- Updated file paths to use __DIR__ for reliability
- Improved form handling with proper validation
- Enhanced image file management with cleanup
- Updated URL generation for new file structure

### Removed
- Deprecated record-add.php, record-edit.php, record-delete.php, and record-details.php
- Removed direct database operations from view files

### Security
- Added login state verification for sensitive operations
- Improved input validation and sanitization
- Enhanced error handling and logging
- Added proper parameter binding for database operations

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