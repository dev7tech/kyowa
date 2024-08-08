<?php

namespace App\Tables;

use Closure;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;
use Okipa\LaravelTable\Column;
use Okipa\LaravelTable\Column\Checkbox;
use Okipa\LaravelTable\Formatters\DateFormatter;
use Okipa\LaravelTable\RowActions\ShowRowAction;
use Okipa\LaravelTable\RowActions\EditRowAction;
use Okipa\LaravelTable\RowActions\DestroyRowAction;
use Okipa\LaravelTable\Table;
use Okipa\LaravelTable\BulkActions\DestroyBulkAction;
use Okipa\LaravelTable\BulkActions\ActivateBulkAction;
use Okipa\LaravelTable\BulkActions\DeactivateBulkAction;
use Okipa\LaravelTable\Filters\ValueFilter;
use Okipa\LaravelTable\HeadActions\AddHeadAction;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Product;
use App\Category;
use App\Image;
use App\Media;
use App\Unit;
use App\RetailSale;
use App\WholeSale;
use App\Tax;
use App\User;

class ProductTable extends AbstractTableConfiguration
{
    public int $categoryId;

    protected function table(): Table
    {
        return Table::make()->model(product::class)
            ->query(fn(Builder $query) => $query->where('category_id',$this->categoryId))
            ->numberOfRowsPerPageOptions([15, 20, 25])
            ->bulkActions(fn(product $product) => [
                new ActivateBulkAction('active'),
            ])
            ->emitEventsOnLoad(['js:selector:init' => ['clickCheckbox', (fn(Product $product)=>[$product->id])]]);
            
    }


    protected function columns(): array
    {
        return [
            Column::make('codeNo')->title('商品ID')->searchable()->sortable(),
            Column::make('name')->title('商品名称')->searchable()->sortable(),
            Column::make('gauge')->title('测量')->sortable(),
            Column::make('qty')->title('数量')->sortable(),
            Column::make('price')->title('价格')->sortable()->format(fn(Product $product)=>(isset($product->retailsales->retailsale) ? $product->retailsales->retailsale : '')),
            Column::make('tax')->title('税')->sortable(),
            Column::make('mark')->title('生产国')->searchable()->sortable(),
            Column::make('status')->title('地位')->format(fn(Product $product)=>($product->is_available ? '<a class="badge badge-success px-2" style="color: #fff;">可用的</a>' : '<a class="badge badge-danger px-2" style="color: #fff;">不可用</a>')),
        ];
    }

    protected function results(): array
    {
        return [
            // The table results configuration.
            // As results are optional on tables, you may delete this method if you do not use it.
        ];
    }
}
