# Activity Logging System

This document describes the comprehensive activity logging system implemented in this Laravel Filament application.

## Overview

The system provides two types of logging:
1. **Activity Logs** - Tracks all changes to User and Role models
2. **Login Attempts** - Tracks authentication events (login, logout, failed attempts)

## Features

- ✅ Automatic activity tracking for User and Role model changes
- ✅ Separate login attempt tracking with detailed information
- ✅ Read-only Filament resources for viewing logs
- ✅ Role-based access control (superadmin only)
- ✅ Automatic cleanup of logs older than 3 months
- ✅ Scheduled monthly cleanup task

## Components

### 1. Activity Logs

**Model**: Uses `Spatie\Activitylog\Models\Activity`

**Tracked Actions**:
- User model changes (name, email)
- Role model changes (name, guard_name)
- Who performed the action (causer)
- What was changed (old and new values)
- When it happened (timestamp)

**Configuration**:
- User model: `app/Models/User.php` - uses `LogsActivity` trait
- Role model: `app/Models/Role.php` - extends Spatie Role with `LogsActivity` trait
- Config: `config/activitylog.php`

**Filament Resource**: `app/Filament/Resources/ActivityLogs/ActivityLogResource.php`
- Navigation: "System" group
- Icon: Document Text
- Features: Read-only, searchable, filterable by log type and model

### 2. Login Attempts

**Model**: `app/Models/LoginAttempt.php`

**Tracked Information**:
- User ID (if authenticated)
- Email address
- Status (success, failed, logout)
- IP Address
- User Agent (browser info)
- Location (if detectable)
- Failure reason (for failed attempts)
- Attempted at timestamp

**Event Listener**: `app/Listeners/LogLoginAttempt.php`

Listens to three Laravel authentication events:
- `Illuminate\Auth\Events\Login` - Successful login
- `Illuminate\Auth\Events\Logout` - User logout
- `Illuminate\Auth\Events\Failed` - Failed login attempt

**Filament Resource**: `app/Filament/Resources/LoginAttempts/LoginAttemptResource.php`
- Navigation: "System" group
- Icon: Shield Check
- Features: Read-only, searchable, filterable by status and user
- Status badges with color coding:
  - Success: Green
  - Failed: Red
  - Logout: Blue

### 3. Automatic Archival

**Command**: `php artisan logs:archive`

**Options**:
- `--months=3` - Number of months to keep logs in database (default: 3)

**Schedule**: Runs automatically on the 1st day of each month at 2:00 AM

**Configuration**: `routes/console.php`

**What it does**:
- Archives logs older than specified months to JSON files
- Stores archives in `storage/app/logs/archives/YYYY/MM/` directory
- Removes archived records from database to keep it lean
- Preserves all data in human-readable JSON format

**Manual Usage**:
```bash
# Archive logs older than 3 months (default)
php artisan logs:archive

# Archive logs older than 6 months
php artisan logs:archive --months=6
```

**Archive Location**:
- Activity logs: `storage/app/logs/archives/YYYY/MM/activity-logs_YYYY-MM-DD_HH-mm-ss.json`
- Login attempts: `storage/app/logs/archives/YYYY/MM/login-attempts_YYYY-MM-DD_HH-mm-ss.json`

## Access Control

Only users with the **superadmin** role can:
- View activity logs
- View login attempts
- Access the System navigation group

The resources implement `canAccess()` method:
```php
public static function canAccess(): bool
{
    return auth()->user()?->hasRole('superadmin');
}
```

## Database Tables

### activity_log
- `id` - Primary key
- `log_name` - Log name (user, role, default)
- `description` - Action description
- `subject_type` - Model type (App\Models\User, App\Models\Role)
- `subject_id` - Model ID
- `causer_type` - User model type
- `causer_id` - User ID who performed the action
- `properties` - JSON field with old/new values
- `event` - Event column (created, updated, deleted)
- `batch_uuid` - Batch identifier
- `created_at`, `updated_at`

### login_attempts
- `id` - Primary key
- `user_id` - Foreign key to users table (nullable)
- `email` - Email used for login attempt
- `status` - Enum (success, failed, logout)
- `ip_address` - IP address
- `user_agent` - Browser/client information
- `location` - Geographic location (if available)
- `failure_reason` - Reason for failure (nullable)
- `attempted_at` - Timestamp of attempt
- `created_at`, `updated_at`

**Indexes**:
- `user_id` and `status` for faster filtering
- `attempted_at` for cleanup and date-based queries

## Event Registration

Events are registered in `app/Providers/AppServiceProvider.php`:

```php
Event::listen(Login::class, [LogLoginAttempt::class, 'handleLogin']);
Event::listen(Logout::class, [LogLoginAttempt::class, 'handleLogout']);
Event::listen(Failed::class, [LogLoginAttempt::class, 'handleFailed']);
```

## Viewing Logs in Filament

1. **Activity Logs**:
   - Navigate to "System" > "Activity Logs"
   - View table with description, type, model, user, and timestamp
   - Filter by log type (user, role) or model type
   - Click on any row to view full details with changes JSON

2. **Login Attempts**:
   - Navigate to "System" > "Login Attempts"
   - View table with user, email, status, IP, location, and timestamp
   - Filter by status (success, failed, logout) or user
   - See color-coded status badges
   - View failure reasons for failed attempts

## Configuration

### Activity Log Settings
Edit `config/activitylog.php` to customize:
- Database connection
- Table name
- Default log name
- Auth driver

### Retention Period
Default: 3 months in database (older logs are archived to files)

To change:
1. Edit the scheduled task in `routes/console.php`:
   ```php
   Schedule::command('logs:archive --months=6')->monthly();
   ```
2. Or run manually with custom months:
   ```bash
   php artisan logs:archive --months=6
   ```

## Testing

To test the logging system:

1. **Test Activity Logging**:
   ```bash
   # Login as superadmin
   # Edit a user's name or email
   # View "Activity Logs" to see the change recorded
   ```

2. **Test Login Attempts**:
   ```bash
   # Successful login: Login normally and check "Login Attempts"
   # Failed login: Try to login with wrong password
   # Logout: Logout and check "Login Attempts"
   ```

3. **Test Archive Command**:
   ```bash
   php artisan logs:archive
   # Should show count of archived records and file locations
   # Check storage/app/logs/archives/ for JSON files
   ```

4. **View Archived Logs**:
   ```bash
   # View archived activity logs
   cat storage/app/logs/archives/2025/10/activity-logs_*.json | jq .
   
   # View archived login attempts
   cat storage/app/logs/archives/2025/10/login-attempts_*.json | jq .
   ```

## Scheduled Task Setup

To enable the scheduled archival, add to your server's crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Or use Laravel Forge, Vapor, or other deployment platform that handles scheduling automatically.

## Security Considerations

1. ✅ Only superadmin can view logs
2. ✅ All resources are read-only (no create, edit, delete)
3. ✅ Sensitive data (passwords) are never logged
4. ✅ IP addresses and user agents are stored for security auditing
5. ✅ Old logs are automatically archived (not deleted) for compliance
6. ✅ Archived logs are stored in JSON format for easy retrieval and analysis
7. ✅ Archive directory is excluded from version control (.gitignore)

## Troubleshooting

### Logs not appearing
1. Check if `LogsActivity` trait is added to models
2. Verify models implement `getActivitylogOptions()` method
3. Check `config/activitylog.php` - ensure `enabled` is `true`

### Login attempts not tracked
1. Verify event listeners are registered in `AppServiceProvider`
2. Check if authentication events are being fired
3. Ensure `login_attempts` table exists

### Cannot access log resources
1. Verify you're logged in as superadmin
2. Check Role policy allows superadmin access
3. Clear cache: `php artisan optimize:clear`

## Future Enhancements

Potential improvements:
- Add export functionality (CSV, PDF)
- Implement GeoIP for accurate location tracking
- Add email notifications for suspicious activities
- Create dashboard widgets with log statistics
- Add admin role access (currently only superadmin)
- Implement log archiving to separate tables

## Dependencies

- `spatie/laravel-activitylog` (^4.10.2) - Activity logging
- `spatie/laravel-permission` (^6.21.0) - Role-based access control
- `filament/filament` (^4.1.2) - Admin panel resources
