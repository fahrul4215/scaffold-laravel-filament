<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use LogsActivity;

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'guard_name']) // Log name and guard changes
            ->logOnlyDirty() // Log only changed attributes
            ->dontSubmitEmptyLogs() // Don't log if nothing changed
            ->setDescriptionForEvent(fn(string $eventName) => "Role has been {$eventName}");
    }
}
