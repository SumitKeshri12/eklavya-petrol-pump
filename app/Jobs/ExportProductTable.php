<?php

namespace App\Jobs;

use App\Helper;
use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ExportProductTable implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $index;

    public $itemCountBatching;

    public $file;

    public $filters;

    public $checkboxValues;

    public $search;

    public $extraParam;

    /**
     * Create a new job instance.
     */
    public function __construct($index, $itemCountBatching, $file, $filters, $checkboxValues, $search, $extraParam)
    {
        $this->index = $index;
        $this->itemCountBatching = $itemCountBatching;
        $this->file = $file;
        $this->filters = $filters;
        $this->checkboxValues = $checkboxValues;
        $this->search = $search;
        $this->extraParam = $extraParam;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Extract parameters
        $index = $this->index;
        $itemCountBatching = $this->itemCountBatching;
        $sr_no = $offset = ($index - 1) * $itemCountBatching;
        $file = $this->file;
        $search = $this->search;

        // Initialize query builder
        $query = Product::query();

        $query
            ->select([
                'products.name', 'products.hsn_code', 'products.category',
                DB::raw(
                    '(CASE
                                    WHEN products.unit = "' . config('constants.product.unit.key.liter') . '" THEN  "' . config('constants.product.unit.value.liter') . '"
                                    WHEN products.unit = "' . config('constants.product.unit.key.milliliter') . '" THEN  "' . config('constants.product.unit.value.milliliter') . '"
                                    WHEN products.unit = "' . config('constants.product.unit.key.gallon') . '" THEN  "' . config('constants.product.unit.value.gallon') . '"
                                    WHEN products.unit = "' . config('constants.product.unit.key.pint') . '" THEN  "' . config('constants.product.unit.value.pint') . '"
                                    WHEN products.unit = "' . config('constants.product.unit.key.qty') . '" THEN  "' . config('constants.product.unit.value.qty') . '"
                                    WHEN products.unit = "' . config('constants.product.unit.key.cup') . '" THEN  "' . config('constants.product.unit.value.cup') . '"
                            ELSE " "
                            END) AS unit'
                ), 'products.tax_rate', 'products.opening_quantity', 'products.opening_rate', 'products.purchase_rate', 'products.selling_rate',
            ]);

        // Apply name filters
        $where_name = $this->filters['input_text']['products']['name'] ?? null;
        if ($where_name) {
            $query->where('products.name', 'like', "%$where_name%");
        }

        // Apply hsn_code filters
        $where_hsn_code = $this->filters['input_text']['products']['hsn_code'] ?? null;
        if ($where_hsn_code) {
            $query->where('products.hsn_code', 'like', "%$where_hsn_code%");
        }

        // Apply category filters
        $where_category = $this->filters['input_text']['products']['category'] ?? null;
        if ($where_category) {
            $query->where('products.category', 'like', "%$where_category%");
        }

        // Apply unit filters
        $where_unit = $this->filters['select']['products']['unit'] ?? null;
        if ($where_unit) {
            $query->where('products.unit', $where_unit);
        }

        // Apply tax_rate filters
        $where_tax_rate = $this->filters['input_text']['products']['tax_rate'] ?? null;
        if ($where_tax_rate) {
            $query->where('products.tax_rate', 'like', "%$where_tax_rate%");
        }

        // Apply opening_quantity filters
        $where_opening_quantity = $this->filters['input_text']['products']['opening_quantity'] ?? null;
        if ($where_opening_quantity) {
            $query->where('products.opening_quantity', 'like', "%$where_opening_quantity%");
        }

        // Apply opening_rate filters
        $where_opening_rate = $this->filters['input_text']['products']['opening_rate'] ?? null;
        if ($where_opening_rate) {
            $query->where('products.opening_rate', 'like', "%$where_opening_rate%");
        }

        // Apply purchase_rate filters
        $where_purchase_rate = $this->filters['input_text']['products']['purchase_rate'] ?? null;
        if ($where_purchase_rate) {
            $query->where('products.purchase_rate', 'like', "%$where_purchase_rate%");
        }

        // Apply selling_rate filters
        $where_selling_rate = $this->filters['input_text']['products']['selling_rate'] ?? null;
        if ($where_selling_rate) {
            $query->where('products.selling_rate', 'like', "%$where_selling_rate%");
        }

        // Apply checkbox filter: If product select checkbox then only that result will be exported
        if ($this->checkboxValues) {
            $query->whereIn('products.id', $this->checkboxValues);
        }

        // Apply search filter
        // if ($search) {
        // $query->where(function ($query) use ($search, $exportableColumns) {
        //  foreach ($exportableColumns as $column) {
        //     $query->orWhere($column, 'like', '%' . $search . '%');
        //  }
        //  });
        //  }

        // Execute query and fetch data
        $query_data = $query
            ->whereNull('products.deleted_at')
            ->orderByDesc('products.id')
            ->groupBy('products.id')
            ->skip($offset)->take($itemCountBatching)->get()->toArray();

        // Convert query result to array
        // $final_data = json_decode(json_encode($query_data), true);

        $final_data = $query_data;

        // Call Helper method to put data into export file
        Helper::putExportData('ExportProductTable', $final_data, $file, $sr_no);
    }
}
