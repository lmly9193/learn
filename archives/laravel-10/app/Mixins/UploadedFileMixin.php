<?php

namespace App\Mixins;

use App\Helpers\Utils\Mime;
use Illuminate\Http\UploadedFile;

final class UploadedFileMixin
{
    /*
    |--------------------------------------------------------------------------
    | FileReader
    |--------------------------------------------------------------------------
    */

    public function mainType()
    {
        return function (): string {
            /** @var UploadedFile $this */
            return Mime::mainType($this->getMimeType());
        };
    }

    public function subType()
    {
        return function (): string {
            /** @var UploadedFile $this */
            return Mime::subType($this->getMimeType());
        };
    }
    public function isText()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isText($this->getMimeType());
        };
    }

    public function isImage()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isImage($this->getMimeType());
        };
    }

    public function isAudio()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isAudio($this->getMimeType());
        };
    }

    public function isVideo()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isVideo($this->getMimeType());
        };
    }

    public function isApplication()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isApplication($this->getMimeType());
        };
    }

    public function isZip()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isZip($this->getMimeType());
        };
    }

    public function isRar()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isRar($this->getMimeType());
        };
    }

    public function is7z()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::is7z($this->getMimeType());
        };
    }

    public function isArchive()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isArchive($this->getMimeType());
        };
    }

    public function isDocx()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isDocx($this->getMimeType());
        };
    }

    public function isDoc()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isDoc($this->getMimeType());
        };
    }

    public function isXlsx()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isXlsx($this->getMimeType());
        };
    }

    public function isXls()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isXls($this->getMimeType());
        };
    }

    public function isPptx()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isPptx($this->getMimeType());
        };
    }

    public function isPpt()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isPpt($this->getMimeType());
        };
    }

    public function isWord()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isWord($this->getMimeType());
        };
    }

    public function isExcel()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isExcel($this->getMimeType());
        };
    }

    public function isPowerPoint()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isPowerPoint($this->getMimeType());
        };
    }

    public function isPdf()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isPdf($this->getMimeType());
        };
    }

    public function isMsg()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isMsg($this->getMimeType());
        };
    }

    public function isCode()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isCode($this->getMimeType());
        };
    }

    public function isJPG()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isJPG($this->getMimeType());
        };
    }

    public function isPng()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isPng($this->getMimeType());
        };
    }

    public function isGif()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isGif($this->getMimeType());
        };
    }

    public function isBmp()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isBmp($this->getMimeType());
        };
    }

    public function isWebp()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isWebp($this->getMimeType());
        };
    }

    public function isSvg()
    {
        return function (): bool {
            /** @var UploadedFile $this */
            return Mime::isSvg($this->getMimeType());
        };
    }

    public function unit()
    {
        return function (int $precision = 2): string {
            /** @var UploadedFile $this */
            return readable($this->getSize())->bytes($precision);
        };
    }

    /*
    |--------------------------------------------------------------------------
    | FileProcessor
    |--------------------------------------------------------------------------
    */

    public function image()
    {
        return function (callable $callback): UploadedFile {
            /** @var UploadedFile $this */
            $imageManager = new \App\Helpers\Utils\ImageManager($this->getRealPath());
            $callback($imageManager);
            $imageManager->save();
            return $this;
        };
    }

    public function addToZip()
    {
        return function (string $realpath, string $entryname = null): UploadedFile {
            /** @var UploadedFile $this */
            $zipManager = new \App\Helpers\Utils\ZipManager($realpath);
            $zipManager->addFile($this, $entryname ?? $this->getClientOriginalName())->save();
            return $this;
        };
    }

    public function extractZipTo()
    {
        return function (string $realpath): UploadedFile {
            /** @var UploadedFile $this */
            $zipManager = new \App\Helpers\Utils\ZipManager($this->getRealPath());
            $zipManager->extractTo($realpath);
            return $this;
        };
    }

    public function storePdfAs()
    {
        return function (string $realpath, bool $landscape): UploadedFile {
            /** @var UploadedFile $this */
            $gotenbergClient = new \App\Helpers\Utils\GotenbergClient($realpath);
            $gotenbergClient
                ->addFile($this)
                ->when($landscape, fn () => $gotenbergClient->landscape())
                ->save();

            return $this;
        };
    }
}
