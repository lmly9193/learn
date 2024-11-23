<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'ulid',
        'user_id',
        'collection',
        'path',
        'display_name',
        'original_name',
        'size',
        'mimetype',
        'properties',
        'whitelist',
        'blacklist',
        'order',
    ];

    protected $attributes = [
        'ulid'          => null,
        'user_id'       => null,
        'collection'    => 'default',
        'path'          => null,
        'display_name'  => null,
        'original_name' => null,
        'size'          => null,
        'mimetype'      => null,
        'properties'    => '[]',
        'whitelist'     => '[]',
        'blacklist'     => '[]',
        'order'         => null,
    ];

    protected $casts = [
        'ulid'       => 'string',
        'properties' => 'array',
        'whitelist'  => 'array',
        'blacklist'  => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Booted
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        // static::retrieved(function (self $media) {
        // });

        static::creating(function (self $media) {
            $media->attributes['ulid'] = (string) str()->ulid();
        });

        static::updating(function (self $media) {
            $media->attributes['size'] = $media->filesystem()->size($media->path);
            $media->attributes['mimetype'] = $media->filesystem()->mimeType($media->path);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Associates
    |--------------------------------------------------------------------------
    */

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor & Mutator
    |--------------------------------------------------------------------------
    |
    */

    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => str()->slash($value),
            set: fn (string $value) => str()->slash($value),
        );
    }

    protected function dirname(): Attribute
    {
        return Attribute::make(
            get: fn () => pathinfo($this->realpath, PATHINFO_DIRNAME),
        );
    }

    protected function filename(): Attribute
    {
        return Attribute::make(
            get: fn () => pathinfo($this->realpath, PATHINFO_FILENAME),
        );
    }

    protected function basename(): Attribute
    {
        return Attribute::make(
            get: fn () => pathinfo($this->realpath, PATHINFO_BASENAME),
        );
    }

    protected function extension(): Attribute
    {
        return Attribute::make(
            get: fn () => pathinfo($this->realpath, PATHINFO_EXTENSION),
        );
    }

    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?: $this->filename,
        );
    }

    protected function downloadName(): Attribute
    {
        return Attribute::make()->get(function () {
            if ($extension = $this->extension) {
                $extension = '.' . $extension;
            }
            return $this->display_name . $extension;
        });
    }

    protected function width(): Attribute
    {
        // 使用600秒快取，避免造成頻繁讀寫檔案。
        return Attribute::make()->get(function () {
            return cache()->remember(
                key: "media.{$this->id}.width",
                ttl: 600,
                callback: fn () => $this->filesystem()->image($this->path)->width(),    // 若要避免拋出異常，可以參考 safely() 這個自訂的輔助函數
            );
        });
    }

    protected function height(): Attribute
    {
        return Attribute::make()->get(function () {
            return cache()->remember(
                key: "media.{$this->id}.height",
                ttl: 600,
                callback: fn () => $this->filesystem()->image($this->path)->height(),
            );
        });
    }

    protected function whitelist(): Attribute
    {
        return Attribute::make()->set(function (array $value) {
            $value = array_map('intval', $value);
            $sort = fn ($v) => collect($v)->sort()->values()->toJson();
            return [
                'whitelist' => $sort(collect($value)),
                'blacklist' => $sort(collect($this->blacklist)->diff($value)),
            ];
        });
    }

    protected function blacklist(): Attribute
    {
        return Attribute::make()->set(function (array $value) {
            $value = array_map('intval', $value);
            $sort = fn ($v) => collect($v)->sort()->values()->toJson();
            return [
                'whitelist' => $sort(collect($this->whitelist)->diff($value)),
                'blacklist' => $sort(collect($value)),
            ];
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function filesystem(): \Illuminate\Filesystem\FilesystemAdapter
    {
        return \Illuminate\Support\Facades\Storage::disk('media');
    }

    public function isPublic(): bool
    {
        return !$this->whitelist && !$this->blacklist;
    }

    public function getRealPath(): string
    {
        return $this->filesystem()->path($this->path);
    }

    public function getUrl($absolute = true): string
    {
        return route('media.download', ['ulid' => $this->ulid, 'timestamp' => time()], $absolute);
    }

    public function isCsrSupported(): bool
    {
        [$fs, $path] = [$this->filesystem(), $this->path];
        return $fs->isImage($path) && ($fs->isJpg($path) || $fs->isPng($path) || $fs->isGif($path) || $fs->isBmp($path) || $fs->isWebp($path) || $fs->isSvg($path));
    }

    public function isSsrSupported(): bool
    {
        [$fs, $path] = [$this->filesystem(), $this->path];
        return $fs->isPdf($path) || $fs->isWord($path) || $fs->isPowerPoint($path) || $fs->isText($path) || $fs->isMsg($path) || $fs->isArchive($path) || $fs->isExcel($path);
    }

    public function isConvertNeeded(): bool
    {
        [$fs, $path] = [$this->filesystem(), $this->path];
        return $fs->isWord($path) || $fs->isPowerPoint($path);
    }

    public function getConvertedPath(): string
    {
        return ".gotenberg/{$this->ulid}.pdf";
    }

    public function getConvertedRealPath(): string
    {
        return $this->filesystem()->path($this->getConvertedPath());
    }

    public function getConvertedUrl($absolute = true): string
    {
        return route('media.download', ['ulid' => $this->ulid, 'type' => 'converted'], $absolute);
    }

    public function hasConverted(): bool
    {
        return $this->filesystem()->exists($this->getConvertedPath());
    }
}
