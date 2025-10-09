# Log Archival System - Change Summary

## 🎯 What Changed

Instead of **deleting** old logs, the system now **archives** them to JSON files for permanent storage and compliance.

## ✨ Key Features

### 1. Archive Instead of Delete
- ✅ Logs are exported to JSON files before removal from database
- ✅ All data is preserved in human-readable format
- ✅ Archived logs can be easily searched and analyzed
- ✅ Supports compliance and audit requirements

### 2. Organized Storage
- ✅ Archives stored in `storage/app/logs/archives/YYYY/MM/` structure
- ✅ Separate files for activity logs and login attempts
- ✅ Timestamped filenames for easy identification
- ✅ .gitignore prevents accidental commits

### 3. Same Schedule
- ✅ Still runs monthly on the 1st day at 2:00 AM
- ✅ Default: Archives logs older than 3 months
- ✅ Configurable retention period

## 📝 Command Changes

### Old Command (Deleted)
```bash
php artisan logs:cleanup
# This deleted logs permanently
```

### New Command (Archives)
```bash
php artisan logs:archive
# This archives logs to JSON files, then removes from DB
```

## 📁 Archive Structure

```
storage/app/logs/archives/
├── 2025/
│   ├── 10/
│   │   ├── activity-logs_2025-10-01_02-00-00.json
│   │   └── login-attempts_2025-10-01_02-00-00.json
│   ├── 11/
│   │   ├── activity-logs_2025-11-01_02-00-00.json
│   │   └── login-attempts_2025-11-01_02-00-00.json
└── .gitignore (excludes archives from git)
```

## 🔍 Viewing Archived Logs

### Using jq (JSON processor)
```bash
# View all activity logs from October 2025
cat storage/app/logs/archives/2025/10/activity-logs_*.json | jq .

# View all login attempts
cat storage/app/logs/archives/2025/10/login-attempts_*.json | jq .

# Filter by specific user
cat storage/app/logs/archives/2025/10/activity-logs_*.json | jq '.[] | select(.causer_id == 1)'

# Count archived records
cat storage/app/logs/archives/2025/10/activity-logs_*.json | jq '. | length'
```

### Using grep (search)
```bash
# Search for specific email across all archives
grep -r "admin@example.com" storage/app/logs/archives/

# Find all failed login attempts
grep -r '"status":"failed"' storage/app/logs/archives/

# Search by date
grep -r "2025-10-01" storage/app/logs/archives/
```

### Using less (view)
```bash
# View with pagination
less storage/app/logs/archives/2025/10/activity-logs_*.json
```

## 🔄 How It Works

1. **Monthly Schedule**: On the 1st of each month at 2:00 AM
2. **Query Old Logs**: Finds logs older than 3 months
3. **Export to JSON**: Saves logs to JSON files with pretty formatting
4. **Remove from DB**: Deletes archived records from database
5. **Reports**: Shows count of archived records and file locations

### Example Output
```
Archiving logs older than 3 months (before 2025-07-01 00:00:00)...
Archived 1,234 activity log records to: storage/app/logs/archives/2025/10/activity-logs_2025-10-01_02-00-00.json
Archived 5,678 login attempt records to: storage/app/logs/archives/2025/10/login-attempts_2025-10-01_02-00-00.json

✓ Log archival completed successfully!
Archives stored in: storage/app/logs/archives/2025/10
```

## 💾 Benefits

### For Compliance
- ✅ All logs are preserved indefinitely
- ✅ Easy to provide audit trails
- ✅ Can be backed up separately
- ✅ Meets data retention requirements

### For Performance
- ✅ Database stays lean (only recent logs)
- ✅ Faster queries on active logs
- ✅ Reduced backup sizes
- ✅ No storage bloat

### For Analysis
- ✅ JSON format is easy to parse
- ✅ Can use standard tools (jq, grep, awk)
- ✅ Can import into analytics tools
- ✅ Easy to restore if needed

## 🔒 Security Considerations

- ✅ Archives excluded from version control
- ✅ Stored in storage directory (not public)
- ✅ Same access restrictions as database logs
- ✅ Can be encrypted for sensitive data
- ✅ Should be included in backups

## 📚 Files Updated

### Modified Files
- `app/Console/Commands/CleanupOldLogs.php` - Renamed and updated to archive instead of delete
- `routes/console.php` - Updated scheduled task from `logs:cleanup` to `logs:archive`
- `ACTIVITY_LOGGING.md` - Updated documentation with archival information
- `ACTIVITY_LOGGING_SUMMARY.md` - Updated summary with archival details

### New Files
- `storage/app/logs/archives/.gitignore` - Excludes archives from git
- `storage/app/logs/archives/README.md` - Complete guide for working with archives

## 🚀 Usage

### Test Archive Command
```bash
# Dry run - see what would be archived (no actual archival)
php artisan logs:archive --months=100

# Archive logs older than 3 months (default)
php artisan logs:archive

# Archive logs older than 6 months
php artisan logs:archive --months=6
```

### Check Scheduled Task
```bash
# View scheduled tasks
php artisan schedule:list

# Run scheduler manually (for testing)
php artisan schedule:run
```

### View Archives
```bash
# List all archive files
ls -lh storage/app/logs/archives/*/*/

# View latest activity log archive
cat storage/app/logs/archives/$(date +%Y)/$(date +%m)/activity-logs_*.json | jq . | less

# Count records in archives
find storage/app/logs/archives -name "*.json" -exec cat {} \; | jq '. | length' | awk '{s+=$1} END {print s}'
```

## 🔄 Restoring Archived Logs

If you need to restore archived logs back to the database:

```php
// Using Laravel Tinker
php artisan tinker

// Restore activity logs
$json = file_get_contents('storage/app/logs/archives/2025/10/activity-logs_2025-10-01_02-00-00.json');
$logs = json_decode($json, true);
foreach ($logs as $log) {
    \Spatie\Activitylog\Models\Activity::create($log);
}

// Restore login attempts
$json = file_get_contents('storage/app/logs/archives/2025/10/login-attempts_2025-10-01_02-00-00.json');
$attempts = json_decode($json, true);
foreach ($attempts as $attempt) {
    \App\Models\LoginAttempt::create($attempt);
}
```

## 📊 Maintenance Tips

### Periodic Cleanup
While archives are kept indefinitely by default, you may want to clean up very old archives:

```bash
# Delete archives older than 2 years
find storage/app/logs/archives -type f -mtime +730 -delete

# Or move them to cold storage
tar -czf logs-archive-$(date +%Y).tar.gz storage/app/logs/archives/
```

### Monitoring Archive Size
```bash
# Check total size of archives
du -sh storage/app/logs/archives/

# Check size by month
du -sh storage/app/logs/archives/2025/*/
```

### Backup Strategy
```bash
# Include in your backup script
tar -czf backup-logs-$(date +%Y%m%d).tar.gz storage/app/logs/archives/

# Upload to S3 or other storage
aws s3 cp backup-logs-$(date +%Y%m%d).tar.gz s3://your-bucket/logs/
```

## ✅ Testing Checklist

- [x] Command renamed from `logs:cleanup` to `logs:archive`
- [x] Scheduled task updated to use `logs:archive`
- [x] Archives stored in organized directory structure
- [x] .gitignore prevents committing archives
- [x] README documentation created for archives directory
- [x] Main documentation updated with archival information
- [x] Command help text updated
- [x] JSON format with pretty printing enabled

## 🎉 Ready to Use!

The archival system is now fully operational. Logs will be automatically archived monthly, preserving all your audit trail data while keeping the database lean and performant.
