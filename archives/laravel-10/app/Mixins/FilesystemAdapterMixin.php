<?php

namespace App\Mixins;

use App\Helpers\Utils\Mime;
use Illuminate\Filesystem\FilesystemAdapter;

final class FilesystemAdapterMixin
{
    /*
    |--------------------------------------------------------------------------
    | FileReader
    |--------------------------------------------------------------------------
    */

    public function file()
    {
        return function (string $path, bool $checkPath = true): \Illuminate\Http\File {
            /** @var FilesystemAdapter $this */
            return new \Illuminate\Http\File($this->path($path), $checkPath);
        };
    }

    public function pathinfo()
    {
        return function (string $path, int $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME): array|string {
            /** @var FilesystemAdapter $this */
            return pathinfo($this->path($path), $options);
        };
    }

    public function dirname()
    {
        return function (string $path): string {
            /** @var FilesystemAdapter $this */
            return $this->pathinfo($path, PATHINFO_DIRNAME);
        };
    }

    public function basename()
    {
        return function (string $path): string {
            /** @var FilesystemAdapter $this */
            return $this->pathinfo($path, PATHINFO_BASENAME);
        };
    }

    public function extension()
    {
        return function (string $path, $guess = false): string {
            /** @var FilesystemAdapter $this */
            if ($guess) {
                return $this->file($path)->extension();
            }
            return $this->pathinfo($path, PATHINFO_EXTENSION);
        };
    }

    public function filename()
    {
        return function (string $path): string {
            /** @var FilesystemAdapter $this */
            return $this->pathinfo($path, PATHINFO_FILENAME);
        };
    }

    public function hashName()
    {
        return function (string $path, $guess = false): string {
            /** @var FilesystemAdapter $this */
            if ($guess) {
                return $this->file($path)->hashName();
            }
            $hash = str()->random(40);
            if ($extension = $this->extension($path)) {
                $extension = '.' . $extension;
            }
            return $hash . $extension;
        };
    }

    public function mainType()
    {
        return function (string $path): string {
            /** @var FilesystemAdapter $this */
            return Mime::mainType($this->mimeType($path));
        };
    }

    public function subType()
    {
        return function (string $path): string {
            /** @var FilesystemAdapter $this */
            return Mime::subType($this->mimeType($path));
        };
    }

    public function isText()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isText($this->mimeType($path));
        };
    }

    public function isImage()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isImage($this->mimeType($path));
        };
    }

    public function isAudio()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isAudio($this->mimeType($path));
        };
    }

    public function isVideo()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isVideo($this->mimeType($path));
        };
    }

    public function isApplication()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isApplication($this->mimeType($path));
        };
    }

    public function isZip()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isZip($this->mimeType($path));
        };
    }

    public function isRar()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isRar($this->mimeType($path));
        };
    }

    public function is7z()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::is7z($this->mimeType($path));
        };
    }

    public function isArchive()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isArchive($this->mimeType($path));
        };
    }

    public function isDocx()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isDocx($this->mimeType($path));
        };
    }

    public function isDoc()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isDoc($this->mimeType($path));
        };
    }

    public function isXlsx()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isXlsx($this->mimeType($path));
        };
    }

    public function isXls()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isXls($this->mimeType($path));
        };
    }

    public function isPptx()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isPptx($this->mimeType($path));
        };
    }

    public function isPpt()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isPpt($this->mimeType($path));
        };
    }

    public function isWord()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isWord($this->mimeType($path));
        };
    }

    public function isExcel()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isExcel($this->mimeType($path));
        };
    }

    public function isPowerPoint()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isPowerPoint($this->mimeType($path));
        };
    }

    public function isPdf()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isPdf($this->mimeType($path));
        };
    }

    public function isMsg()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isMsg($this->mimeType($path));
        };
    }

    public function isCode()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isCode($this->mimeType($path));
        };
    }

    public function isJpg()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isJpg($this->mimeType($path));
        };
    }

    public function isPng()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isPng($this->mimeType($path));
        };
    }

    public function isGif()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isGif($this->mimeType($path));
        };
    }

    public function isBmp()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isBmp($this->mimeType($path));
        };
    }

    public function isWebp()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isWebp($this->mimeType($path));
        };
    }

    public function isSvg()
    {
        return function (string $path): bool {
            /** @var FilesystemAdapter $this */
            return Mime::isSvg($this->mimeType($path));
        };
    }

    public function unit()
    {
        return function (string $path, int $precision = 2): string {
            /** @var FilesystemAdapter $this */
            return readable($this->size($path))->bytes($precision);
        };
    }

    /*
    |--------------------------------------------------------------------------
    | FileProcessor
    |--------------------------------------------------------------------------
    */

    public function image()
    {
        return function (string $path): \App\Helpers\Utils\ImageManager {
            /** @var FilesystemAdapter $this */
            return new \App\Helpers\Utils\ImageManager($this->path($path));
        };
    }

    public function zip()
    {
        return function (string $path, ?string $password = null): \App\Helpers\Utils\ZipManager {
            /** @var FilesystemAdapter $this */
            return new \App\Helpers\Utils\ZipManager($this->path($path), $password);
        };
    }

    public function pdf()
    {
        return function (string $path): \App\Helpers\Utils\GotenbergClient {
            /** @var FilesystemAdapter $this */
            return new \App\Helpers\Utils\GotenbergClient($this->path($path));
        };
    }

    public function excel()
    {
        return function (string $path): \App\Helpers\Utils\ArrayExporter {
            /** @var FilesystemAdapter $this */
            return new \App\Helpers\Utils\ArrayExporter($this->path($path));
        };
    }
}
