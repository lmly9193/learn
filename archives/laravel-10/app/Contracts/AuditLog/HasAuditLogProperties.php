<?php

namespace App\Contracts\AuditLog;

use Illuminate\Support\Collection;

interface HasAuditLogProperties
{
    public function hasAuditLogProperties(): Collection|array;
}
