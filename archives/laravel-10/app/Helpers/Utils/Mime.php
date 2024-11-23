<?php

namespace App\Helpers\Utils;

class Mime
{
    public static function mainType(string $mime): string
    {
        return str($mime)->before('/')->toString();
    }

    public static function subType(string $mime): string
    {
        return str($mime)->after('/')->toString();
    }


    /*
    |--------------------------------------------------------------------------
    | Text
    |--------------------------------------------------------------------------
    */

    public static function isText(string $mime): bool
    {
        return self::mainType($mime) === 'text';
    }

    public static function isCode(string $mime): bool
    {
        return match (self::subType($mime)) {
            'css'           => true,
            'csv'           => true,
            'html'          => true,
            'javascript'    => true,
            'json'          => true,
            'markdown'      => true,
            'sql'           => true,
            'x-c++src'      => true,
            'x-csrc'        => true,
            'x-httpd-php'   => true,
            'x-java-source' => true,
            'x-python'      => true,
            'x-ruby'        => true,
            'x-sh'          => true,
            'x-swift'       => true,
            'x-yaml'        => true,
            'xml'           => true,
            'yaml'          => true,
            default => false,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Image
    |--------------------------------------------------------------------------
    */

    public static function isImage(string $mime): bool
    {
        return self::mainType($mime) === 'image';
    }

    public static function isJpg(string $mime): bool
    {
        return self::subType($mime) === 'jpeg';
    }

    public static function isPng(string $mime): bool
    {
        return self::subType($mime) === 'png';
    }

    public static function isBmp(string $mime): bool
    {
        return self::subType($mime) === 'bmp';
    }

    public static function isGif(string $mime): bool
    {
        return self::subType($mime) === 'gif';
    }

    public static function isWebp(string $mime): bool
    {
        return self::subType($mime) === 'webp';
    }

    public static function isSvg(string $mime): bool
    {
        return match (self::subType($mime)) {
            'svg'     => true,
            'svg+xml' => true,
            default => false,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Audio
    |--------------------------------------------------------------------------
    */

    public static function isAudio(string $mime): bool
    {
        return self::mainType($mime) === 'audio';
    }

    public static function isMp3(string $mime): bool
    {
        return self::subType($mime) === 'mpeg';
    }


    /*
    |--------------------------------------------------------------------------
    | Video
    |--------------------------------------------------------------------------
    */

    public static function isVideo(string $mime): bool
    {
        return self::mainType($mime) === 'video';
    }

    public static function isMp4(string $mime): bool
    {
        return self::subType($mime) === 'mp4';
    }


    /*
    |--------------------------------------------------------------------------
    | Application
    |--------------------------------------------------------------------------
    */

    public static function isApplication(string $mime): bool
    {
        return self::mainType($mime) === 'application';
    }

    public static function isZip(string $mime): bool
    {
        return match (self::subType($mime)) {
            'zip'              => true,
            'x-zip-compressed' => true,
            default => false,
        };
    }

    public static function isRar(string $mime): bool
    {
        return match (self::subType($mime)) {
            'vnd.rar'          => true,
            'x-rar'            => true,
            'x-rar-compressed' => true,
            default => false,
        };
    }

    public static function is7z(string $mime): bool
    {
        return self::subType($mime) === 'x-7z-compressed';
    }

    public static function isDocx(string $mime): bool
    {
        return self::subType($mime) === 'vnd.openxmlformats-officedocument.wordprocessingml.document';
    }

    public static function isDoc(string $mime): bool
    {
        return self::subType($mime) === 'msword';
    }

    public static function isXlsx(string $mime): bool
    {
        return self::subType($mime) === 'vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    }

    public static function isXls(string $mime): bool
    {
        return self::subType($mime) === 'vnd.ms-excel';
    }

    public static function isPptx(string $mime): bool
    {
        return self::subType($mime) === 'vnd.openxmlformats-officedocument.presentationml.presentation';
    }

    public static function isPpt(string $mime): bool
    {
        return self::subType($mime) === 'vnd.ms-powerpoint';
    }

    public static function isPdf(string $mime): bool
    {
        return self::subType($mime) === 'pdf';
    }

    public static function isMsg(string $mime): bool
    {
        return self::subType($mime) === 'vnd.ms-outlook';
    }


    /*
    |--------------------------------------------------------------------------
    | Grouping
    |--------------------------------------------------------------------------
    */

    public static function isArchive(string $mime): bool
    {
        return self::isZip($mime) || self::isRar($mime) || self::is7z($mime);
    }

    public static function isWord(string $mime): bool
    {
        return self::isDocx($mime) || self::isDoc($mime);
    }

    public static function isExcel(string $mime): bool
    {
        return self::isXlsx($mime) || self::isXls($mime);
    }

    public static function isPowerPoint(string $mime): bool
    {
        return self::isPptx($mime) || self::isPpt($mime);
    }


    /*
    |--------------------------------------------------------------------------
    | Etc.
    |--------------------------------------------------------------------------
    */

    public static function gd(string $mime): bool
    {
        return self::isJPG($mime) || self::isPNG($mime) || self::isGif($mime) || self::isBmp($mime) || self::isWebp($mime);
    }

    public static function fa5html(string $mime): string
    {
        return match (true) {
            self::isPdf($mime)        => '<i class="fas fa-file-pdf"></i>',
            self::isWord($mime)       => '<i class="fas fa-file-word"></i>',
            self::isExcel($mime)      => '<i class="fas fa-file-excel"></i>',
            self::isPowerPoint($mime) => '<i class="fas fa-file-powerpoint"></i>',
            self::isImage($mime)      => '<i class="fas fa-file-image"></i>',
            self::isArchive($mime)    => '<i class="fas fa-file-archive"></i>',
            self::isAudio($mime)      => '<i class="fas fa-file-audio"></i>',
            self::isVideo($mime)      => '<i class="fas fa-file-video"></i>',
            self::isCode($mime)       => '<i class="fas fa-file-code"></i>',
            self::isText($mime)       => '<i class="fas fa-file-alt"></i>',
            default => '<i class="fas fa-file"></i>',
        };
    }

    public static function fa5unicode(string $mime): string
    {
        return match (true) {
            self::isPdf($mime)        => "\u{f1c1}",
            self::isWord($mime)       => "\u{f1c2}",
            self::isExcel($mime)      => "\u{f1c3}",
            self::isPowerPoint($mime) => "\u{f1c4}",
            self::isImage($mime)      => "\u{f1c5}",
            self::isArchive($mime)    => "\u{f1c6}",
            self::isAudio($mime)      => "\u{f1c7}",
            self::isVideo($mime)      => "\u{f1c8}",
            self::isCode($mime)       => "\u{f1c9}",
            self::isText($mime)       => "\u{f15c}",
            default => "\u{f15b}",
        };
    }
}
