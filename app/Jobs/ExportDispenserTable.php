<?php

namespace App\Jobs;

use App\Helper;
use App\Models\Dispenser;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportDispenserTable implements ShouldQueue
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
        $query = Dispenser::query();

        $query
            ->select([
                'dispensers.number',
            ]);

        // Apply number filters
        $where_number = $this->filters['input_text']['dispensers']['number'] ?? null;
        if ($where_number) {
            $query->where('dispensers.number', 'like', "%$where_number%");
        }

        // Apply checkbox filter: If dispenser select checkbox then only that result will be exported
        if ($this->checkboxValues) {
            $query->whereIn('dispensers.id', $this->checkboxValues);
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
            ->whereNull('dispensers.deleted_at')
            ->orderByDesc('dispensers.id')
            ->groupBy('dispensers.id')
            ->skip($offset)->take($itemCountBatching)->get()->toArray();

        // Convert query result to array
        // $final_data = json_decode(json_encode($query_data), true);

        $final_data = $query_data;

        // Call Helper method to put data into export file
        Helper::putExportData('ExportDispenserTable', $final_data, $file, $sr_no);
    }
}
