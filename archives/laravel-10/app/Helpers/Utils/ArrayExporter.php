<?php

namespace App\Helpers\Utils;

use App\Exports\ArrayExport;
use Illuminate\Support\Collection;

class ArrayExporter
{
    protected ArrayExport $exporter;

    public function __construct(
        protected readonly string $realpath
    ) {
    }

    /**
     * 取得匯出物件
     */
    public function getExporter()
    {
        return $this->exporter;
    }

    /**
     * 設定資料
     */
    public function data(Collection|array|string $data, array $headers = []): self
    {
        $data = match (true) {
            is_string($data)              => json_decode($data, true),
            is_array($data)               => $data,
            ($data instanceof Collection) => $data->toArray(),
        };
        $this->exporter = new ArrayExport($data, $headers);
        return $this;
    }

    /**
     * 儲存檔案
     */
    public function save(): bool
    {
        $extension = (string) str(pathinfo($this->realpath, PATHINFO_EXTENSION))->lower();
        $writerType = match ($extension) {
            'xlsx'  => \Maatwebsite\Excel\Excel::XLSX,
            'xls'   => \Maatwebsite\Excel\Excel::XLS,
            default => \Maatwebsite\Excel\Excel::CSV,
        };

        $bytes = file_put_contents($this->realpath, $this->exporter->raw($writerType));
        $wrote = ($bytes !== false);
        return $wrote ?: false;
    }

    // 透過 __call 魔術方法，可以直接呼叫 ArrayExport 的方法。
    public function __call($name, $arguments)
    {
        return $this->exporter->$name(...$arguments);
    }
}
