# Dans Attendance Management - Patch v3.2

## Release Date
2024-12-07

## Overview
Patch 3.2 introduces significant improvements to the Dans Attendance Management system, including a comprehensive Leave Management feature, migration from Carbon to Chronos for better date handling, and enhanced table designs for improved user experience.

## 🔨 Major Changes

### 📅 Date Handling Migration
- Migrated from Carbon to Chronos for improved date management
- Updated all date-related functions and methods across the system
- Enhanced timezone handling and date calculations
- Optimized date formatting and parsing operations

### 🌟 New Leave Management System
#### Features
- Complete CRUD operations for leave requests
- Automated leave balance synchronization
- Leave types supported:
  - Annual Leave
  - Sick Leave
  - Important Leave
  - Other Leave
- Real-time balance checking and validation
- Approval workflow with manager designation

#### Leave Balance Integration
- Automatic balance calculation and updates
- Year-based leave quota management
- Visual indicators for remaining balance
- Historical leave record tracking

### 🎨 UI/UX Improvements
- Redesigned all data tables for better readability
- Implemented responsive table layouts
- Added new filtering and sorting capabilities
- Enhanced dark mode compatibility

## 📋 Installation Instructions

1. Backup your database
```bash
php artisan backup:run
```

2. Update dependencies in composer.json
```json
{
    "require": {
        "cakephp/chronos": "^2.4",
        "laravel/framework": "^10.0"
    }
}
```

3. Install new dependencies
```bash
composer update
```

4. Run migrations
```bash
php artisan migrate
```

5. Publish new assets
```bash
php artisan vendor:publish --tag="dans-attendance-assets"
php artisan view:clear
php artisan cache:clear
```

## ⚠️ Breaking Changes
1. Carbon to Chronos Migration
   - All Carbon::now() calls need to be replaced with Chronos::now()
   - Date formatting methods may have slightly different syntax
   - Custom date macros need to be updated

2. Database Schema Updates
   - New tables for leave management
   - Modified attendance tables structure
   - Added foreign key constraints

## 🔍 Testing Instructions
1. Leave Management Testing
   - Create new leave request
   - Verify balance calculation
   - Test approval workflow
   - Check email notifications
   - Verify balance updates

2. Date Handling Testing
   - Verify attendance records
   - Check leave duration calculations
   - Test timezone conversions
   - Validate date displays

## 🔄 Rollback Procedure
If you need to rollback this patch:

1. Restore database from backup
```bash
php artisan backup:restore
```

2. Revert composer.json changes and update
```bash
composer update
```

## 📝 Additional Notes
- Leave balance is calculated based on the fiscal year
- Managers must be designated in the system for leave approval
- QA Team - Testing and verification

## 📄 License
Copyright © 2024 Dans Digital. All rights reserved.
