<?php

namespace Kishan\AuditLog\Traits;

use Kishan\AuditLog\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logActivity($model, 'created');
        });

        static::updated(function ($model) {
            self::logActivity($model, 'updated', $model->getOriginal(), $model->getDirty());
        });

        static::deleted(function ($model) {
            self::logActivity($model, 'deleted', $model->getOriginal());
        });
    }

    protected static function logActivity($model, $action, $old = [], $new = [])
    {
        AuditLog::create([
            'model'      => get_class($model),
            'model_id'   => $model->id,
            'action'     => $action,
            'old_values' => $old,
            'new_values' => $new,
            'user_id'    => Auth::id(),
        ]);
    }
}
