# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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