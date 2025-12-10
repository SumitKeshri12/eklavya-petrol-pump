<?php

namespace App\Jobs;

use App\Helper;
use App\Models\Sanction;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ExportSanctionTable implements ShouldQueue
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
        $query = Sanction::query();

        $query
            ->leftJoin('users', 'users.id', '=', 'sanctions.user_id')
            ->select([
                'users.first_name as user_first_name', 'sanctions.month', 'sanctions.year',
                DB::raw(
                    '(CASE
                                    WHEN sanctions.fuel_type = "' . config('constants.sanction.fuel_type.key.petrol') . '" THEN  "' . config('constants.sanction.fuel_type.value.petrol') . '"
                                    WHEN sanctions.fuel_type = "' . config('constants.sanction.fuel_type.key.diesel') . '" THEN  "' . config('constants.sanction.fuel_type.value.diesel') . '"
                            ELSE " "
                            END) AS fuel_type'
                ), 'sanctions.quantity',
            ]);

        // Apply month filters
        $where_start = $this->filters['datetime']['sanctions']['month']['start'] ?? null;
        $where_end = $this->filters['datetime']['sanctions']['month']['end'] ?? null;

        if ($where_start && $where_end) {
            $query->whereBetween('sanctions.month', [$where_start, $where_end]);
        }

        // Apply year filters
        $where_start = $this->filters['datetime']['sanctions']['year']['start'] ?? null;
        $where_end = $this->filters['datetime']['sanctions']['year']['end'] ?? null;

        if ($where_start && $where_end) {
            $query->whereBetween('sanctions.year', [$where_start, $where_end]);
        }

        // Apply fuel_type filters
        $where_fuel_type = $this->filters['select']['sanctions']['fuel_type'] ?? null;
        if ($where_fuel_type) {
            $query->where('sanctions.fuel_type', $where_fuel_type);
        }

        // Apply checkbox filter: If sanction select checkbox then only that result will be exported
        if ($this->checkboxValues) {
            $query->whereIn('sanctions.id', $this->checkboxValues);
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
            ->whereNull('sanctions.deleted_at')
            ->orderByDesc('sanctions.id')
            ->groupBy('sanctions.id')
            ->skip($offset)->take($itemCountBatching)->get()->toArray();

        // Convert query result to array
        // $final_data = json_decode(json_encode($query_data), true);

        $final_data = $query_data;

        // Call Helper method to put data into export file
        Helper::putExportData('ExportSanctionTable', $final_data, $file, $sr_no);
    }
}
