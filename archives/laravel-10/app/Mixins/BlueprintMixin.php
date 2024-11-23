<?php

namespace App\Mixins;

use Illuminate\Database\Schema\Blueprint;

final class BlueprintMixin
{
    /**
     * Create userstamps columns to table.
     */
    public function userstamps()
    {
        return function (): void {
            /** @var Blueprint $this */
            $this->unsignedBigInteger('created_by');
            $this->unsignedBigInteger('updated_by');
        };
    }

    /**
     * Create nullable userstamps columns to table.
     */
    public function nullableUserstamps()
    {
        return function (): void {
            /** @var Blueprint $this */
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();
        };
    }

    /**
     * Drop userstamps columns from table.
     */
    public function dropUserstamps()
    {
        return function (): void {
            /** @var Blueprint $this */
            $this->dropColumn('created_by', 'updated_by');
        };
    }
}
