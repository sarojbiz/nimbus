<?php

namespace App\Exports;

use App\Product;
use App\Size;
use App\Color;
use App\Enums\GeneralStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    use Exportable;
    private $products;

    public function collection()
    {
        $this->products = Product::orderBy('pdt_id', 'ASC')->get();
        return $this->products;
    }

    public function map($data): array
    {
        $return = [];
        if( $data->simple_product && $data->inventorySimpleProduct ){
            $return[] = [
                        $data->mcode,
                        $data->pdt_name,
                        optional($data->parent)->category_name,
                        $data->has_size_color ? 'Variable product' : 'Simple product',
                        optional($data->brand)->name,
                        $data->is_sales_product ? 'Yes' : 'No',
                        GeneralStatus::fromValue((int) $data->status)->description,            
                        //optional($data->pdt_brand)->category->parent,
                        //Carbon::parse($data->created_at)->format('Y-m-d g:i A'),
                        Size::where('id', $data->inventorySimpleProduct->size_id)->pluck('name')->first(),
                        Color::where('id', $data->inventorySimpleProduct->color_id)->pluck('name')->first(),
                        round($data->inventorySimpleProduct->regular_price, 2),
                        round($data->inventorySimpleProduct->sales_price, 2),
                        $data->inventorySimpleProduct->inventory_sku,
                        $data->inventorySimpleProduct->barcode
            ];
        }
        if( $data->variable_product ){
            foreach( $data->inventoryProducts as $variable ){
                $return[] = [
                    $data->mcode,
                    $data->pdt_name,
                    optional($data->parent)->category_name,
                    $data->has_size_color ? 'Variable product' : 'Simple product',
                    optional($data->brand)->name,
                    $data->is_sales_product ? 'Yes' : 'No',
                    GeneralStatus::fromValue((int) $data->status)->description,            
                    //optional($data->pdt_brand)->category->parent,
                    //Carbon::parse($data->created_at)->format('Y-m-d g:i A'),
                    Size::where('id', $variable->size_id)->pluck('name')->first(),
                    Color::where('id', $variable->color_id)->pluck('name')->first(),
                    round($variable->regular_price, 2),
                    round($variable->sales_price, 2),
                    $variable->inventory_sku,
                    $variable->barcode
                ];
            }
        }
        
        return $return;
    }

    public function headings(): array
    {
        return [
            'Mcode',
            'Name',
            'Category',
            'Product Type',
            'Brand',
            'Sales Product',
            'Status',
            'Size',
            'Color',
            'Regualr Price',
            'Sales Price',
            'SKU',
            'Barcode'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 14]],           
        ];
    }
}
