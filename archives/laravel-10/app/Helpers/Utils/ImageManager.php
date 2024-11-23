<?php

namespace App\Helpers\Utils;

use Intervention\Image\Facades\Image;

class ImageManager
{
    protected \Intervention\Image\Image $image;

    public function __construct(
        protected readonly string $realpath
    ) {
        // if the file exists in the specified path, the image instance will be autoload.
        if (file_exists($realpath)) {
            $this->from($this->realpath);
        }
    }

    /**
     * 取得實例
     * * 基本上只有在需要存取原始實例時才會用到，例如: 你需要使用原始的 save() 方法的情境，
     * * 這是因為我們已經重新封裝了 save 方法，所以你無法值接透過魔術方法調用實例的 save()。
     */
    public function getImage(): \Intervention\Image\Image
    {
        return $this->image;
    }

    /**
     * 取得實際路徑
     */
    public function getRealPath(): string
    {
        return $this->realpath;
    }

    /**
     * 從指定來源建立實例
     */
    public function from(mixed $source): self
    {
        $this->image = Image::make($source);
        return $this;
    }

    /**
     * 等比例調整寬度並防止圖像放大
     */
    public function upSizeWiden($width): self
    {
        $this->image->widen($width, fn ($constraint) => $constraint->upsize());
        return $this;
    }

    /**
     * 等比例調整高度並防止圖像放大
     */
    public function upSizeHeighten($height): self
    {
        $this->image->heighten($height, fn ($constraint) => $constraint->upsize());
        return $this;
    }

    /**
     * 儲存檔案或保存修改
     * * 預設情況下，保存的格式由指定路徑的檔案副檔名定義
     * * quality 參數僅適用於 jpg 格式
     */
    public function save(?int $quality = null, ?string $format = null): self
    {
        $this->image->save($this->realpath, $quality, $format);
        return $this;
    }

    /**
     * 另存新檔至指定路徑
     * * 預設情況下，保存的格式由指定路徑的檔案副檔名定義
     * * quality 參數僅適用於 jpg 格式
     */
    public function saveAs(string $realpath, ?int $quality = null, ?string $format = null): self
    {
        $this->image->save($realpath, $quality, $format);
        return $this;
    }

    // 透過 __call 魔術方法，可以直接呼叫 Image 的方法。
    public function __call($name, $arguments)
    {
        $output = $this->image->$name(...$arguments);
        return ($output instanceof \Intervention\Image\Image) ? $this : $output;
    }
}
