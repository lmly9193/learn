<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'event',
        'values',
        'changes',
        'messages',
        'user_id',
        'parent_id',
    ];

    protected $attributes = [
        'values'   => '{}',
        'changes'  => '{}',
        'messages' => '{}',
    ];

    protected $casts = [
        'values'     => 'array',
        'changes'    => 'array',
        'messages'   => 'array',
    ];

    /**
     * Get the owning auditable model.
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user that performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the previous audit log.
     */
    public function previous(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the next audit log.
     */
    public function next(): HasOne
    {
        return $this->hasOne(self::class, 'parent_id');
    }

    /**
     * Log the changes to a model.
     */
    public static function log(string $event, Model $auditable): self
    {
        $audit = new self([
            'event'      => $event,
            'values'     => $auditable->refresh(),
            'changes'    => $auditable->getChanges(),
            'parent_id'  => $auditable->audits()->max('id'),
        ]);

        $audit->auditable()->associate($auditable);
        $audit->user()->associate(auth()->user());

        $audit->messages = $auditable->setAuditMessages($event);

        $audit->save();

        return $audit->refresh();
    }
}
