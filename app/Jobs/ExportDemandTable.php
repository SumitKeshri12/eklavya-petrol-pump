<?php

namespace App\Jobs;

use App\Helper;
use App\Models\Demand;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ExportDemandTable implements ShouldQueue
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
        $query = Demand::query();

        $query
            ->leftJoin('users', 'users.id', '=', 'demands.user_id')
            ->select([
                'demands.id', 'users.party_name as user_party_name',
                DB::raw(
                    '(CASE
                                    WHEN demands.fuel_type = "' . config('constants.demand.fuel_type.key.petrol') . '" THEN  "' . config('constants.demand.fuel_type.value.petrol') . '"
                                    WHEN demands.fuel_type = "' . config('constants.demand.fuel_type.key.diesel') . '" THEN  "' . config('constants.demand.fuel_type.value.diesel') . '"
                            ELSE " "
                            END) AS fuel_type'
                ), 'demands.demand_date', 'demands.vehicle_number', 'demands.receiver_mobile_no',
            ]);

        // Apply user_id filters
        $where_user_id = $this->filters['select']['demands']['user_id'] ?? null;
        if ($where_user_id) {
            $query->where('demands.user_id', $where_user_id);
        }

        // Apply fuel_type filters
        $where_fuel_type = $this->filters['select']['demands']['fuel_type'] ?? null;
        if ($where_fuel_type) {
            $query->where('demands.fuel_type', $where_fuel_type);
        }

        // Apply demand_date filters
        $where_start = $this->filters['datetime']['demands']['demand_date']['start'] ?? null;
        $where_end = $this->filters['datetime']['demands']['demand_date']['end'] ?? null;

        if ($where_start && $where_end) {
            $query->whereBetween('demands.demand_date', [$where_start, $where_end]);
        }

        // Apply vehicle_number filters
        $where_vehicle_number = $this->filters['input_text']['demands']['vehicle_number'] ?? null;
        if ($where_vehicle_number) {
            $query->where('demands.vehicle_number', 'like', "%$where_vehicle_number%");
        }

        // Apply checkbox filter: If demand select checkbox then only that result will be exported
        if ($this->checkboxValues) {
            $query->whereIn('demands.id', $this->checkboxValues);
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
            ->whereNull('demands.deleted_at')
            ->orderByDesc('demands.id')
            ->groupBy('demands.id')
            ->skip($offset)->take($itemCountBatching)->get()->toArray();

        // Convert query result to array
        // $final_data = json_decode(json_encode($query_data), true);

        $final_data = $query_data;

        // Call Helper method to put data into export file
        Helper::putExportData('ExportDemandTable', $final_data, $file, $sr_no);
    }
}
