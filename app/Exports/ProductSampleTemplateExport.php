<?php

namespace App\Exports;

use App\Enums\MenuItemStatus;
use App\MenuItem;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductSampleTemplateExport implements ShouldAutoSize, WithHeadings, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Product Name',            
            'Product Type',
            'Brand',
            'Category',
            'Sales Product',
            'Status',
            'Short Description',
            'Brief Description',
            'Ingredients',
            'How To Use',
            'Color',
            'Size',
            'SKU',
            'Barcode',
            'Regular Price',
            'Sales Price',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 12]],
            'D'    => ['alignment' => ['wrapText' => true]],
        ];
    }
}
