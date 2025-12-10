<?php

namespace App\Jobs;

use App\Helper;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ExportUserTable implements ShouldQueue
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
        $query = User::query();

        $query
            ->select([
                'users.id', 'users.first_name', 'users.last_name', 'users.party_name', 'users.email', 'users.mobile_number',
                DB::raw(
                    '(CASE
                                    WHEN users.status = "' . config('constants.user.status.key.active') . '" THEN  "' . config('constants.user.status.value.active') . '"
                                    WHEN users.status = "' . config('constants.user.status.key.inactive') . '" THEN  "' . config('constants.user.status.value.inactive') . '"
                            ELSE " "
                            END) AS status'
                ),
            ]);

        // Apply first_name filters
        $where_first_name = $this->filters['input_text']['users']['first_name'] ?? null;
        if ($where_first_name) {
            $query->where('users.first_name', 'like', "%$where_first_name%");
        }

        // Apply last_name filters
        $where_last_name = $this->filters['input_text']['users']['last_name'] ?? null;
        if ($where_last_name) {
            $query->where('users.last_name', 'like', "%$where_last_name%");
        }

        // Apply party_name filters
        $where_party_name = $this->filters['input_text']['users']['party_name'] ?? null;
        if ($where_party_name) {
            $query->where('users.party_name', 'like', "%$where_party_name%");
        }

        // Apply mobile_number filters
        $where_mobile_number = $this->filters['input_text']['users']['mobile_number'] ?? null;
        if ($where_mobile_number) {
            $query->where('users.mobile_number', 'like', "%$where_mobile_number%");
        }

        // Apply status filters
        $where_status = $this->filters['select']['users']['status'] ?? null;
        if ($where_status) {
            $query->where('users.status', $where_status);
        }

        // Apply checkbox filter: If user select checkbox then only that result will be exported
        if ($this->checkboxValues) {
            $query->whereIn('users.id', $this->checkboxValues);
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
            ->whereNull('users.deleted_at')
            ->orderByDesc('users.id')
            ->groupBy('users.id')
            ->skip($offset)->take($itemCountBatching)->get()->toArray();

        // Convert query result to array
        // $final_data = json_decode(json_encode($query_data), true);

        $final_data = $query_data;

        // Call Helper method to put data into export file
        Helper::putExportData('ExportUserTable', $final_data, $file, $sr_no);
    }
}
