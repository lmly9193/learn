<?php

namespace App\Models\Traits\HasMedia;

use App\Models\Media;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

class MediaBuilder
{

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /**
     * 儲存系統
     */
    protected FilesystemAdapter $filesystem;

    /**
     * 傳入的文件
     */
    protected File|UploadedFile $file;

    /**
     * 檔案名稱
     */
    protected string $filename;

    /**
     * 媒體模型
     */
    protected Media $media;

    /**
     * 建構子
     */
    public function __construct()
    {
        $this->filesystem = Storage::disk('media');
        $this->filename   = str()->random(40);
        $this->media      = new Media();
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /**
     * 取得傳入的文件
     */
    public function getFile()
    {
        return $this->file;
    }
    /**
     * 取得儲存系統
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * 取得檔案名稱
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * 取得媒體模型
     */
    public function getMedia()
    {
        return $this->media;
    }

    /*
    |--------------------------------------------------------------------------
    | Protected Methods
    |--------------------------------------------------------------------------
    */

    /**
     * 檔案來源
     */
    protected function source(mixed $file): self
    {
        $strType = function (string $file) {
            return new File($file);
        };

        $this->file = match (true) {
            is_string($file) => $strType($file),
            default => $file,
        };

        return $this;
    }

    /**
     * 路徑解析器
     */
    protected function resolver(): self
    {
        $path = $this->filename;

        if (!!$assoc = $this->media->mediable) {
            $path = implode('/', [class_basename($assoc::class), $assoc->id, $this->filename]);
        }

        if (!!$extension = $this->file->getExtension()) {
            $path = str($path)->append('.')->append($extension)->toString();
        }

        $this->fill(compact('path'));
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    /**
     * 填入模型屬性
     */
    public function fill(array $attributes): self
    {
        $this->media->fill($attributes);
        return $this;
    }

    /**
     * 儲存檔案 & 模型
     */
    public function save(): Media
    {
        throw_if(file_exists($this->media->getRealPath()), 'RuntimeException', 'Unable to save the file because the model path is conflicting.');

        $this->filesystem->putFileAs('', $this->file, $this->media->path);
        $this->media->save();

        return $this->media->refresh();
    }

    /**
     * 當條件成立時執行
     */
    public function when(bool $condition, \Closure $closure): self
    {
        if ($condition) $closure($this);
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Methods with auto-fill
    |--------------------------------------------------------------------------
    */

    /**
     * 從來源新增檔案
     */
    public function from(File|UploadedFile|string $file): self
    {
        $file = $this->source($file)->file;

        $attributes = [
            'size'     => $file->getSize(),
            'mimetype' => $file->getMimeType(),
        ];

        $attributes['original_name'] = match (true) {
            $file instanceof File         => $file->getFilename(),
            $file instanceof UploadedFile => $file->getClientOriginalName(),
        };

        $this->fill($attributes);

        $this->resolver();
        return $this;
    }

    /**
     * 指定關聯模型
     */
    public function for(Model $model): self
    {
        $this->media->mediable()->associate($model);

        $this->resolver();
        return $this;
    }

    /**
     * 原始檔名
     */
    public function original(): self
    {
        $this->filename = pathinfo($this->file->getFilename(), PATHINFO_FILENAME);
        $this->resolver();
        return $this;
    }

    /**
     * 指定檔名
     */
    public function namedAs(string $filename): self
    {
        $this->filename = $filename;
        $this->resolver();
        return $this;
    }

    /**
     * 序列化檔名
     */
    public function serialize(string $prefix = '', string $suffix = '', int $digit = 3): self
    {
        $files = $this->filesystem->files(str($this->media->path)->dirname());
        $serial = collect($files)->map(fn ($item) => str(pathinfo($item, PATHINFO_FILENAME))->ltrim($prefix)->rtrim($suffix)->toInteger())->max();

        $this->filename = $prefix . str(++$serial)->padLeft($digit, '0') . $suffix;

        $this->resolver();
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | fill attributes
    |--------------------------------------------------------------------------
    */

    /**
     * 指定擁有者
     */
    public function belongsTo(\App\Models\User $user)
    {
        $this->media->user()->associate($user);
        return $this;
    }

    /**
     * 設定顯示名稱
     */
    public function displayedAs(string $name): self
    {
        $this->fill(['display_name' => $name]);
        return $this;
    }

    /**
     * 設定媒體集合
     */
    public function toCollection(string $collection): self
    {
        $this->fill(['collection' => $collection]);
        return $this;
    }

    /**
     * 設定自訂義屬性
     */
    public function with(array $properties): self
    {
        $this->fill(['properties' => $properties]);
        return $this;
    }

    /**
     * 設定白名單
     */
    public function allow(array $users): self
    {
        $this->fill(['whitelist' => $users]);
        return $this;
    }

    /**
     * 設定黑名單
     */
    public function deny(array $users): self
    {
        $this->fill(['blacklist' => $users]);
        return $this;
    }

    /**
     * 設定排序
     */
    public function order(int $order): self
    {
        $this->fill(['order' => $order]);
        return $this;
    }
}
