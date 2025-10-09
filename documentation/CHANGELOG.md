# CHANGELOG

## [Unreleased] - 2025-10-10

### Fixed - Login Attempts Issues
- **CRITICAL**: Fixed PostgreSQL check constraint violation on logout
  - Added 'logout' to enum values in login_attempts.status field
  - Migration updated: `enum('status', ['success', 'failed', 'logout'])`
- **CRITICAL**: Fixed double login attempts records
  - Added deduplication mechanism to prevent duplicate entries
  - Tracks recent attempts within 5-second windows
  - Prevents multiple event firings from creating duplicate records

### Changed - Log Archival System
- **BREAKING**: Changed from log deletion to log archival
- Command renamed: `logs:cleanup` → `logs:archive`
- Logs are now exported to JSON files before removal from database
- Archives stored in `storage/app/logs/archives/YYYY/MM/` directory structure

### Added
- JSON archival system for activity logs and login attempts
- `.gitignore` in archives directory
- `README.md` in archives directory with usage guide
- `ARCHIVAL_SYSTEM.md` - Complete documentation of archival system
- Archive viewing examples using jq, grep, and less
- Restoration instructions for archived logs

### Benefits
- ✅ **Compliance**: All logs preserved indefinitely
- ✅ **Performance**: Database stays lean with only recent logs
- ✅ **Analysis**: JSON format easy to parse and analyze
- ✅ **Audit Trail**: Complete history maintained in files
- ✅ **Flexibility**: Archives can be backed up, moved, or restored

### Migration Guide
If you were using the old `logs:cleanup` command:

**Before:**
```bash
php artisan logs:cleanup --months=3
```

**After:**
```bash
php artisan logs:archive --months=3
```

The scheduled task has been automatically updated in `routes/console.php`.

### Files Modified
- `app/Console/Commands/CleanupOldLogs.php` - Updated to archive instead of delete
- `routes/console.php` - Updated scheduled task
- `ACTIVITY_LOGGING.md` - Updated documentation
- `ACTIVITY_LOGGING_SUMMARY.md` - Updated summary
- `README.md` - Added project features section

### Files Added
- `storage/app/logs/archives/.gitignore`
- `storage/app/logs/archives/README.md`
- `ARCHIVAL_SYSTEM.md`

---

## [Previous] - Activity Logging System

### Added
- Spatie Laravel ActivityLog integration
- User and Role model activity tracking
- Login attempt tracking (success, failed, logout)
- Filament resources for viewing logs (superadmin only)
- Event listeners for authentication events
- IP address and user agent tracking
- Location detection for login attempts
- Read-only log resources
- Policy-based access control

### Features
- Activity Logs resource at `/admin/activity-logs`
- Login Attempts resource at `/admin/login-attempts`
- Automatic tracking of model changes
- Separate authentication event tracking
- Superadmin-only access to logs
- Monthly scheduled archival

---

## [Initial] - User Management System

### Added
- Filament admin panel
- User CRUD with simple resources
- Role CRUD with simple resources
- spatie/laravel-permission integration
- Role-based access control (RBAC)
- UserPolicy and RolePolicy
- Superadmin role protection
- Role seeder (superadmin, admin, editor, viewer)
- SuperAdminSeeder

### Features
- Simple/single-page resources with modal forms
- Superadmin excluded from UI selection
- Protected superadmin role (cannot edit/delete)
- Email verification removed from UI
- Policies enforce role hierarchy
