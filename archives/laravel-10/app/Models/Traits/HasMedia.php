<?php

namespace App\Models\Traits;

use App\Media;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use App\Models\Traits\HasMedia\MediaBuilder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMedia
{

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function addMedia(File|UploadedFile|string $file)
    {
        return tap(new MediaBuilder, fn ($MediaBuilder) => $MediaBuilder->from($file)->for($this));
    }
}
