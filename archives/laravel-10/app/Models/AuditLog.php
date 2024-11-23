<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use App\Contracts\AuditLog\HasAuditLogProperties;

class AuditLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'model_type',
        'model_id',
        'causer_type',
        'causer_id',
        'event',
        'values',
        'changes',
        'requests',
        'properties',
        'parent_id',
    ];

    protected $attributes = [
        'values'     => '{}',
        'changes'    => '{}',
        'requests'   => '{}',
        'properties' => '{}',
    ];

    protected $casts = [
        'values'     => AsCollection::class,
        'changes'    => AsCollection::class,
        'requests'   => AsCollection::class,
        'properties' => AsCollection::class,
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    public static function track(Model $model, string $event): void
    {
        if (!app()->runningInConsole()) {
            $user = auth()->user();
        } else {
            $user = Admin::find(1);
        }

        $audit = new self([
            'event'      => $event,
            'values'     => $model->fresh(),
            'changes'    => $model->getChanges(),
            'parent_id'  => $model->histories()->max('id'),
        ]);

        if (!app()->runningInConsole()) {
            $audit->requests = [
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url'        => request()->fullUrl(),
                'method'     => request()->method(),
                'attributes' => request()->all(),
                'cookies'    => request()->cookies->all(),
            ];
        }

        if ($model instanceof HasAuditLogProperties) {
            $audit->properties = $model->hasAuditLogProperties();
        }

        $audit->model()->associate($model);
        $audit->causer()->associate($user);

        $audit->save();
    }

    public function previous(): ?AuditLog
    {
        return $this->where('id', $this->parent_id)->first();
    }

    public function next(): ?AuditLog
    {
        return $this->where('parent_id', $this->id)->first();
    }
}
