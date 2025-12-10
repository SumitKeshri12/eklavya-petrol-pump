<?php

namespace App\Jobs;

use App\Helper;
use App\Models\FuelConfig;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ExportFuelConfigTable implements ShouldQueue
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
        $query = FuelConfig::query();

        $query
            ->select([

                DB::raw(
                    '(CASE
                                    WHEN fuel_configs.fuel_type = "' . config('constants.fuel_config.fuel_type.key.petrol') . '" THEN  "' . config('constants.fuel_config.fuel_type.value.petrol') . '"
                                    WHEN fuel_configs.fuel_type = "' . config('constants.fuel_config.fuel_type.key.diesel') . '" THEN  "' . config('constants.fuel_config.fuel_type.value.diesel') . '"
                            ELSE " "
                            END) AS fuel_type'
                ), 'fuel_configs.price', 'fuel_configs.date',
            ]);

        // Apply fuel_type filters
        $where_fuel_type = $this->filters['select']['fuelconfigs']['fuel_type'] ?? null;
        if ($where_fuel_type) {
            $query->where('fuelconfigs.fuel_type', $where_fuel_type);
        }

        // Apply price filters
        $where_price = $this->filters['input_text']['fuelconfigs']['price'] ?? null;
        if ($where_price) {
            $query->where('fuelconfigs.price', 'like', "%$where_price%");
        }

        // Apply date filters
        $where_start = $this->filters['datetime']['fuelconfigs']['date']['start'] ?? null;
        $where_end = $this->filters['datetime']['fuelconfigs']['date']['end'] ?? null;

        if ($where_start && $where_end) {
            $query->whereBetween('fuelconfigs.date', [$where_start, $where_end]);
        }

        // Apply checkbox filter: If fuelconfig select checkbox then only that result will be exported
        if ($this->checkboxValues) {
            $query->whereIn('fuel_configs.id', $this->checkboxValues);
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
            ->whereNull('fuel_configs.deleted_at')
            ->orderByDesc('fuel_configs.id')
            ->groupBy('fuel_configs.id')
            ->skip($offset)->take($itemCountBatching)->get()->toArray();

        // Convert query result to array
        // $final_data = json_decode(json_encode($query_data), true);

        $final_data = $query_data;

        // Call Helper method to put data into export file
        Helper::putExportData('ExportFuelConfigTable', $final_data, $file, $sr_no);
    }
}
