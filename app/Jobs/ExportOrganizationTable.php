<?php

namespace App\Jobs;

use App\Helper;
use App\Models\Organization;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportOrganizationTable implements ShouldQueue
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
        $query = Organization::query();

        $query
            ->select([
                'organizations.name', 'organizations.owner_name', 'organizations.contact_number', 'organizations.state', 'organizations.city', 'organizations.pincode',
            ]);

        // Apply name filters
        $where_name = $this->filters['input_text']['organizations']['name'] ?? null;
        if ($where_name) {
            $query->where('organizations.name', 'like', "%$where_name%");
        }

        // Apply owner_name filters
        $where_owner_name = $this->filters['input_text']['organizations']['owner_name'] ?? null;
        if ($where_owner_name) {
            $query->where('organizations.owner_name', 'like', "%$where_owner_name%");
        }

        // Apply state filters
        $where_state = $this->filters['input_text']['organizations']['state'] ?? null;
        if ($where_state) {
            $query->where('organizations.state', 'like', "%$where_state%");
        }

        // Apply city filters
        $where_city = $this->filters['input_text']['organizations']['city'] ?? null;
        if ($where_city) {
            $query->where('organizations.city', 'like', "%$where_city%");
        }

        // Apply checkbox filter: If organization select checkbox then only that result will be exported
        if ($this->checkboxValues) {
            $query->whereIn('organizations.id', $this->checkboxValues);
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
            ->whereNull('organizations.deleted_at')
            ->orderByDesc('organizations.id')
            ->groupBy('organizations.id')
            ->skip($offset)->take($itemCountBatching)->get()->toArray();

        // Convert query result to array
        // $final_data = json_decode(json_encode($query_data), true);

        $final_data = $query_data;

        // Call Helper method to put data into export file
        Helper::putExportData('ExportOrganizationTable', $final_data, $file, $sr_no);
    }
}
