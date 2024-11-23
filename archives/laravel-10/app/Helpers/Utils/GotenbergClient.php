<?php

namespace App\Helpers\Utils;

use GuzzleHttp\Client;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class GotenbergClient
{
    protected Client $client;

    protected array $options;

    public function __construct(
        protected readonly string $realpath
    ) {
        $this->client   = new Client();
        $this->options  = [
            'base_uri'  => config('gotenberg.base_uri'),
            'multipart' => [],
        ];

        throw_if(!$this->health(), new \Exception('The Gotenberg service is currently unavailable, please try again later.'));
    }

    protected function health(): bool
    {
        try {
            $response = $this->client->request('GET', '/health', $this->options);
            $status = $response->getStatusCode();
            return $status === 200;
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            throw new \Exception("The Gotenberg service is not running. $message");
        }
    }

    protected function resolver(mixed $file): File|UploadedFile
    {
        $strType = function (string $realpath) {
            return new File($realpath, true);
        };

        return match (true) {
            is_string($file) => $strType($file),
            default => $file,
        };
    }

    /**
     * 條件執行
     */
    public function when(bool $condition, callable $callback): self
    {
        if (!!$condition) $callback($this);
        return $this;
    }

    /**
     * 取得代理
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * 取得實際路徑
     */
    public function getRealPath(): string
    {
        return $this->realpath;
    }

    /**
     * 新增要轉換的檔案來源
     */
    public function addFile(File|UploadedFile|string $file): self
    {
        $File = $this->resolver($file);

        $this->options['multipart'][] = [
            'name'     => 'files',
            'contents' => $File->getContent(),
            'filename' => $File->hashName(),
        ];
        return $this;
    }

    /**
     * 設定目標PDF檔案的頁面方向為橫向
     */
    public function landscape(bool $param = true): self
    {
        $this->options['multipart'][] = [
            'name'     => 'landscape',
            'contents' => $param ? 'true' : 'false',
        ];
        return $this;
    }

    /**
     * 建立目標檔案
     */
    public function save(): bool
    {
        $count = collect($this->options['multipart'])->where('name', 'files')->count();
        throw_if(!$count, new \Exception('There are no files to be converted.'));

        if ($count) {
            $this->options['multipart'][] = [
                'name'     => 'merge',
                'contents' => 'true',
            ];
        }

        $response = $this->client->request('POST', '/forms/libreoffice/convert', $this->options);
        $status = $response->getStatusCode();

        if ($status === 200) {
            $bytes = file_put_contents($this->realpath, $response->getBody());
            $wrote = ($bytes !== false);
        }

        return $wrote ?: false;
    }
}
