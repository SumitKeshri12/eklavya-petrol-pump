<?php

namespace App\Jobs;

use App\Helper;
use App\Models\Vehicle;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ExportVehicleTable implements ShouldQueue
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
        $query = Vehicle::query();

        $query
            ->leftJoin('users', 'users.id', '=', 'vehicles.user_id')
            ->select([
                'users.first_name as user_first_name', 'vehicles.vehicle_number',
                DB::raw(
                    '(CASE
                                    WHEN vehicles.fuel_type = "' . config('constants.vehicle.fuel_type.key.petrol') . '" THEN  "' . config('constants.vehicle.fuel_type.value.petrol') . '"
                                    WHEN vehicles.fuel_type = "' . config('constants.vehicle.fuel_type.key.diesel') . '" THEN  "' . config('constants.vehicle.fuel_type.value.diesel') . '"
                            ELSE " "
                            END) AS fuel_type'
                ),
                DB::raw(
                    '(CASE
                                    WHEN vehicles.status = "' . config('constants.vehicle.status.key.active') . '" THEN  "' . config('constants.vehicle.status.value.active') . '"
                                    WHEN vehicles.status = "' . config('constants.vehicle.status.key.inactive') . '" THEN  "' . config('constants.vehicle.status.value.inactive') . '"
                            ELSE " "
                            END) AS status'
                ),
            ]);

        // Apply vehicle_number filters
        $where_vehicle_number = $this->filters['input_text']['vehicles']['vehicle_number'] ?? null;
        if ($where_vehicle_number) {
            $query->where('vehicles.vehicle_number', 'like', "%$where_vehicle_number%");
        }

        // Apply fuel_type filters
        $where_fuel_type = $this->filters['select']['vehicles']['fuel_type'] ?? null;
        if ($where_fuel_type) {
            $query->where('vehicles.fuel_type', $where_fuel_type);
        }

        // Apply status filters
        $where_status = $this->filters['select']['vehicles']['status'] ?? null;
        if ($where_status) {
            $query->where('vehicles.status', $where_status);
        }

        // Apply checkbox filter: If vehicle select checkbox then only that result will be exported
        if ($this->checkboxValues) {
            $query->whereIn('vehicles.id', $this->checkboxValues);
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
            ->whereNull('vehicles.deleted_at')
            ->orderByDesc('vehicles.id')
            ->groupBy('vehicles.id')
            ->skip($offset)->take($itemCountBatching)->get()->toArray();

        // Convert query result to array
        // $final_data = json_decode(json_encode($query_data), true);

        $final_data = $query_data;

        // Call Helper method to put data into export file
        Helper::putExportData('ExportVehicleTable', $final_data, $file, $sr_no);
    }
}
