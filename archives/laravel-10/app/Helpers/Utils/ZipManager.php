<?php

namespace App\Helpers\Utils;

use ZipArchive;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class ZipManager
{
    protected ZipArchive $zipArchive;

    protected $status = false;

    public function __construct(
        protected readonly string $realpath,
        protected readonly ?string $password = null,
    ) {
        $this->zipArchive = new ZipArchive();
        $this->open();
    }

    protected function open(): bool
    {
        if (is_file($this->realpath)) {
            $ret = $this->zipArchive->open($this->realpath);
        } else {
            $ret = $this->zipArchive->open($this->realpath, ZipArchive::CREATE);
        }

        $message = match ($ret) {
            ZipArchive::ER_MULTIDISK   => 'Multi-disk zip archives not supported',
            ZipArchive::ER_RENAME      => 'Renaming temporary file failed',
            ZipArchive::ER_CLOSE       => 'Closing zip archive failed',
            ZipArchive::ER_SEEK        => 'Seek error',
            ZipArchive::ER_READ        => 'Read error',
            ZipArchive::ER_WRITE       => 'Write error',
            ZipArchive::ER_CRC         => 'CRC error',
            ZipArchive::ER_ZIPCLOSED   => 'Containing zip archive was closed',
            ZipArchive::ER_NOENT       => 'No such file',
            ZipArchive::ER_EXISTS      => 'File already exists',
            ZipArchive::ER_OPEN        => 'Can\'t open file',
            ZipArchive::ER_TMPOPEN     => 'Failure to create temporary file',
            ZipArchive::ER_ZLIB        => 'Zlib error',
            ZipArchive::ER_MEMORY      => 'Malloc failure',
            ZipArchive::ER_CHANGED     => 'Entry has been changed',
            ZipArchive::ER_COMPNOTSUPP => 'Compression method not supported',
            ZipArchive::ER_EOF         => 'Premature EOF',
            ZipArchive::ER_INVAL       => 'Invalid argument',
            ZipArchive::ER_NOZIP       => 'Not a zip archive',
            ZipArchive::ER_INTERNAL    => 'Internal error',
            ZipArchive::ER_INCONS      => 'Zip archive inconsistent',
            ZipArchive::ER_REMOVE      => 'Can\'t remove file',
            ZipArchive::ER_DELETED     => 'Entry has been deleted',
            ZipArchive::ER_OK          => 'No error',
            default => 'No error',
        };

        throw_if(!$this->status = ($ret === true), new \Exception("Error: {$message}. Failed to open zip file: {$this->realpath}."));

        if (!!$this->password) $this->zipArchive->setPassword($this->password);

        return $this->status;
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    /**
     * 取得實例
     */
    public function getZipArchive(): ZipArchive
    {
        return $this->zipArchive;
    }

    /**
     * 取得實際路徑
     */
    public function getRealPath(): string
    {
        return $this->realpath;
    }

    /**
     * 將指定的檔案加入目標壓縮檔中
     */
    public function addFile(File|UploadedFile|string $file, string $entryname = null): self
    {
        $is_file = is_string($file) && is_file($file);
        if ($is_file) $file = new File($file);

        $name = $entryname ?? $file->getBasename();
        $this->zipArchive->addFromString($name, $file->getContent());

        if (!!$this->password) {
            $this->zipArchive->setEncryptionName($name, ZipArchive::EM_AES_256);
        }

        return $this;
    }

    /**
     * 將目標壓縮案解壓至指定目錄
     */
    public function extractTo(string $realpath): bool
    {
        return tap($this->zipArchive->extractTo($realpath), fn () => $this->zipArchive->close());
    }

    /**
     * 儲存至壓縮檔
     */
    public function save(): bool
    {
        return $this->zipArchive->close();
    }
}
