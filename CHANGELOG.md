# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

# [Unreleased]

## [0.1.5] - 2025-02-16

### Added
- Implemented comprehensive contact management system:
  - Added ContactController for handling contact-related requests
  - Created ContactManager service for contact operations
  - Added new contact views and templates:
    - Contact listing page
    - Contact details view
    - Contact message interface
    - Contact removal confirmation
- Enhanced SASS styling structure for contact pages
- Added proper header template integration for contact section

### Changed
- Refactored contact-related operations into dedicated service layer
- Improved contact form handling and validation
- Updated header template to include contact navigation items

### Security
- Implemented proper input validation for contact forms
- Added CSRF protection for contact operations
- Enhanced access control for contact management

## [0.1.4] - 2025-02-15

### Changed
- Integrated a new SubjectService to manage subject-related operations.
  - Refactored code to utilize the SubjectService for fetching subjects in the edit and show pages.
  - Updated methods to ensure proper dependency injection for the SubjectService.
  - Improved error handling and validation when retrieving subjects.

### Fixed
- Resolved issues with subject retrieval that caused incorrect data to be displayed.
- Ensured that subject IDs are properly encoded and escaped in URLs.

### Added
- Added unit tests for the SubjectService to ensure reliability and correctness of subject-related operations.

## [0.1.3] - 2025-02-15

### Changed
- Consolidated header and footer templates
  - Merged layouts/header.php into shared/header.php
  - Merged layouts/footer.php into shared/footer.php
  - Updated styling for consistent look
- Enhanced template dependency management
  - Added proper service checks in templates
  - Improved error handling for missing services
- Updated navigation structure
  - Moved main navigation to component
  - Improved admin and auth button styling
  - Fixed login/logout URL paths

### Added
- GitHub repository links in footer
- Conditional audio player component
- Service availability checks in templates

### Fixed
- Missing dependencies in RecordController
  - Added userManager and config dependencies
  - Updated constructor and view variables
- Improved template organization
  - Proper closing HTML tags
  - Better component separation
  - Consistent styling classes

## [0.1.2] - 2025-02-14

### Changed
- Refactored application to use MVC architecture
  - Moved business logic from `public/index.php` to dedicated controllers and services
  - Implemented `RecordController` to handle record-related requests
  - Created `RecordService` for database operations and business logic
  - Introduced proper `Record` model with type-safe properties and methods
  - Separated views into organized template structure:
    - `/templates/records/` for record-related views
    - `/templates/shared/` for common layouts
- Enhanced dependency management
  - Implemented proper dependency injection in controllers
  - Added service container in `bootstrap.php`
  - Improved helper class organization
- Added type hints and return types throughout codebase
- Improved error handling in database operations

### Removed
- Removed inline PHP from `public/index.php`
- Removed debug logging statements across all files
- Removed redundant comments and documentation

### Fixed
- Fixed missing `urlHelper` dependency in record templates
- Fixed table display issues by properly passing dependencies to views
- Fixed database connection handling in service layer

### Architecture
- Implemented proper MVC separation:
  - Models: Handle data structure and validation
  - Views: Handle presentation logic in templates
  - Controllers: Coordinate between models and views
- Improved application bootstrapping process
- Added service layer for business logic

## [0.1.1] - 2025-02-14

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

## [0.1.0] - 2025-02-13

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