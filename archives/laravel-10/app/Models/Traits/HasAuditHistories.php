<?php

namespace App\Models\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAuditHistories
{
    public static function bootHasAuditHistories()
    {
        static::created(function ($model) {
            AuditLog::track($model, 'created');
        });

        static::updated(function ($model) {
            AuditLog::track($model, 'updated');
        });

        static::deleted(function ($model) {
            AuditLog::track($model, 'deleted');
        });

        if (is_callable(static::bootSoftDeletes())) {
            static::forceDeleted(function ($model) {
                AuditLog::track($model, 'forceDeleted');
            });

            static::restored(function ($model) {
                AuditLog::track($model, 'restored');
            });
        }
    }

    public function initializeHasAuditHistories()
    {
        //
    }

    public function histories(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'model');
    }
}
