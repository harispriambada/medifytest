<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class MasterItemsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MasterItem::with('categories')->get()->map(function ($item) {
            return [
                'kategori' => $item->categories->pluck('nama')->implode(', '), // nama kategori dipisah koma
                'nama_item' => $item->nama,
                'supplier' => $item->supplier,
                'harga' => $item->harga_beli,
                'laba' => $item->laba,
                'harga_jual' => $item->harga_beli + ($item->harga_beli * $item->laba / 100),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Kategori',
            'Nama Item',
            'Nama Supplier',
            'Harga',
            'Laba',
            'Harga Jual',
        ];
    }
}
