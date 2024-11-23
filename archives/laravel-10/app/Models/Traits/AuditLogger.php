<?php

namespace App\Models\Traits;

use App\Models\Audit;

trait AuditLogger
{
    public static function bootAuditLogger()
    {
        /**
         * Eloquent ORM Operations
         *
         * Create      : saving, creating, retrieved, created, saved
         * Read        : retrieved
         * Update      : saving, updating, retrieved, updated, saved
         * Delete      : deleting, deleted
         * Soft-Delete : deleting, trashed, retrieved, deleted
         * Restore     : restoring, saving, updating, retrieved, updated, saved, retrieved, restored
         * Force-Delete: forceDeleting, deleting, deleted, forceDeleted
         * Replicate   : replicating
         */

        static::created(function ($model) {
            Audit::log('created', $model);
        });

        static::updated(function ($model) {
            Audit::log( 'updated', $model);
        });

        static::deleted(function ($model) {
            Audit::log( 'deleted', $model);
        });

        if (method_exists(static::class, 'bootSoftDeletes')) {
            static::restored(function ($model) {
                Audit::log( 'restored', $model);
            });

            static::forceDeleted(function ($model) {
                Audit::log( 'forceDeleted', $model);
            });
        }
    }

    /**
     * Get the audit logs for the model.
     */
    public function audits(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        /**
         * @var \Illuminate\Database\Eloquent\Model $this
         */
        return $this->morphMany(Audit::class, 'auditable');
    }

    /**
     * set audit messages for auditable model.
     */
    public function setAuditMessages(string $event): array
    {
        return [];
    }
}
