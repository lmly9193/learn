<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ArrayExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function __construct(
        protected array $data,
        protected array $headers = []
    ) {
    }

    /**
     * Implement this method from FromCollection
     */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * Implement this method from WithHeadings
     */
    public function headings(): array
    {
        return $this->headers;
    }
}
