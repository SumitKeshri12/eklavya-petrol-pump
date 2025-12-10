<?php

namespace App\Livewire\Demand;

use App\Helper;
use App\Jobs\ExportDemandTable;
use App\Models\Demand;
use App\Traits\RefreshDataTable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use Throwable;

final class Table extends PowerGridComponent
{
    use RefreshDataTable;

    public bool $deferLoading = true; // default false

    public string $tableName;

    public string $loadingComponent = 'components.powergrid-loading';

    public string $sortField = 'demands.id';

    public string $sortDirection = 'desc';

    // Custom per page
    public int $perPage;

    // Custom per page values
    public array $perPageValues;

    public $currentUser;

    public function __construct()
    {
        if (! Gate::allows('view-demand')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->tableName = __('messages.demand.listing.tableName');
        $this->perPage = config('constants.webPerPage');
        $this->perPageValues = config('constants.webPerPageValues');
    }

    public function exportData()
    {
        try {
            // Define export parameters
            $exportClass = ExportDemandTable::class;
            $headingColumn = 'Id,User,FuelType,DemandDate,VehicleNumber,ReceiverMobileNo';
            $batchName = 'Export Demand Table';
            $downloadPrefixFileName = 'DemandReports_';
            $extraParam = [];

            // Run export job and handle result
            $result = Helper::runExportJob($this->total, $this->filters, $this->checkboxValues, $this->search, $headingColumn, $downloadPrefixFileName, $exportClass, $batchName, $extraParam);
            if (! $result['status']) {
                // Dispatch error alert if export fails
                $this->dispatch('alert', type: 'error', message: $result['message']);

                return false;
            }

            // Dispatch event to show export progress
            $this->dispatch('showExportProgressEvent', json_encode($result['data']))->to('common-code');
        } catch (Throwable $e) {
            // Log and dispatch error alert if exception occurs
            logger()->error('App\Livewire\DemandTable: exportData: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            session()->flash('error', __('messages.demand.messages.common_error_message'));

            return false;
        }
    }

    public function header(): array
    {
        $headerArray = [];

        if (Gate::allows('add-demand')) {
            $headerArray[] = Button::add('add-demand')
                ->slot('    <a href="/demand/create" title="Add New Demand" data-testid="add_new" class="flex items-center justify-center cursor-pointer" wire:navigate>
        <svg class="h-5 w-5 text-pg-white-500 dark:text-pg-white-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
    </a>')
                ->class(
                    'flex rounded-md ring-1 transition focus:ring-2
                        dark:text-white text-white
                        bg-black hover:bg-gray-800
                        border-0 py-2 px-2
                        focus:outline-none
                        sm:text-sm sm:leading-6
                        w-8 h-8 lg:w-9 lg:h-9 inline-flex items-center justify-center ml-1
                        focus:ring-black focus:ring-offset-1'
                );
        }

        if (Gate::allows('export-demand')) {
            $headerArray[] = Button::add('export-data')
                ->slot('<a href="javascript:void(0);" title="Export Demand" data-testid="export_button" wire:click="exportData" class="flex items-center justify-center" wire:loading.attr="disabled">
                        <svg class="h-5 w-5 text-white dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </a>
                ')
                ->class('
                    flex rounded-md ring-1 transition focus:ring-2
                    text-white bg-green-600 hover:bg-green-700
                    border-0 py-2 px-2
                    focus:outline-none
                    sm:text-sm sm:leading-6
                    w-8 h-8 lg:w-9 lg:h-9 inline-flex items-center justify-center ml-1
                    focus:ring-green-600 focus:ring-offset-1
                ');
        }

        if (Gate::allows('bulkDelete-demand')) {
            $headerArray[] = Button::add('bulk-delete')
                ->slot('<div x-show="$wire.checkboxValues && $wire.checkboxValues.length > 0" x-transition>
                <div class="flex rounded-md ring-1 transition focus:ring-2
                        dark:text-white text-white
                        bg-red-600 hover:bg-red-600
                        border-0 py-2 px-2
                        focus:outline-none
                        sm:text-sm sm:leading-6
                        w-8 h-8 lg:w-9 lg:h-9 items-center justify-center ml-1
                        focus:ring-red focus:ring-offset-1 cursor-pointer"
                    data-testid="bulk_delete_button"
                    wire:click="bulkDelete"
                    title="Bulk Delete Demands">
                    <svg class="h-5 w-5 text-pg-white-500 dark:text-pg-white-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </div>
            </div>
            ');
        }

        return $headerArray;
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [

            PowerGrid::header(),

            PowerGrid::footer()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        // Main query
        return Demand::query()
            ->leftJoin('users', 'users.id', '=', 'demands.user_id')
            ->select([
                'demands.id', 'users.party_name as user_party_name',
                DB::raw(
                    '(CASE
                                                WHEN demands.fuel_type = "' . config('constants.demand.fuel_type.key.petrol') . '" THEN  "' . config('constants.demand.fuel_type.value.petrol') . '"
                                                WHEN demands.fuel_type = "' . config('constants.demand.fuel_type.key.diesel') . '" THEN  "' . config('constants.demand.fuel_type.value.diesel') . '"
                                        ELSE " "
                                        END) AS fuel_type'
                ), 'demands.vehicle_number', 'demands.fuel_quantity', 'demands.outstanding_quantity',
            ])->groupBy('demands.id');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')

            ->add('created_at_formatted', fn ($row) => Carbon::parse($row->created_at)->format(config('constants.default_datetime_format')));
    }

    public function columns(): array
    {
        return [

            Column::make(__('messages.demand.listing.id'), 'id')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.demand.listing.users'), 'user_party_name')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.demand.listing.fuel_type'), 'fuel_type')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.demand.listing.vehicle_number'), 'vehicle_number')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.demand.listing.fuel_quantity'), 'fuel_quantity')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.demand.listing.outstanding_quantity'), 'outstanding_quantity')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.created_date'), 'created_at_formatted', 'created_at'),
            Column::action(__('messages.demand.listing.actions')),
        ];
    }

    public function filters(): array
    {
        return [

            Filter::select('user_party_name', 'users.party_name')
                ->dataSource(\App\Models\User::all())
                ->optionLabel('party_name')
                ->optionValue('party_name'),
            Filter::select('fuel_type', 'fuel_type')
                ->dataSource(Demand::fuel_type())
                ->optionLabel('label')
                ->optionValue('key'),
            Filter::inputText('vehicle_number', 'demands.vehicle_number')->operators(['contains']),

            Filter::datetimepicker('created_at'),
        ];
    }

    #[On('edit')]
    public function edit($id)
    {
        return $this->redirect('demand/' . $id . '/edit', navigate: true); // redirect to edit component
    }

    public function actions(Demand $row): array
    {
        $actions = [];

        if (Gate::allows('show-demand')) {
            $actions[] = Button::add('view')
                ->slot('<div title="' . __('messages.tooltip.view') . '" class="flex items-center justify-center" data-testid="view_button">' . view('components.flux.icon.eye', ['variant' => 'micro', 'attributes' => new \Illuminate\View\ComponentAttributeBag(['class' => ''])])->render() . '</div>')
                ->class('w-full sm:w-auto text-gray-600 bg-gray-200 hover:bg-gray-300 py-2 px-2 rounded text-lg cursor-pointer hover:cursor-pointer text-gray-500 hover:text-gray-900')
                ->dispatchTo('demand.show', 'show-demand-info', ['id' => $row->id]);
        }

        if (Gate::allows('edit-demand')) {
            $actions[] = Button::add('edit')
                ->slot('<div title="Edit" class="flex items-center justify-center" data-testid="edit_button">' . view('components.flux.icon.pencil', ['variant' => 'micro', 'attributes' => new \Illuminate\View\ComponentAttributeBag(['class' => ''])])->render() . '</div>')
                ->class('w-full sm:w-auto text-gray-600 bg-gray-200 hover:bg-gray-300 py-2 px-2 rounded text-lg cursor-pointer hover:cursor-pointer text-gray-500 hover:text-gray-900')
                ->dispatch('edit', ['id' => $row->id]);
        }

        if (Gate::allows('delete-demand')) {
            $actions[] = Button::add('delete-demand')
                ->slot('<div title="' . __('messages.tooltip.click_delete') . '" class="flex items-center justify-center" data-testid="delete_button">' . view('components.flux.icon.trash', ['variant' => 'micro', 'attributes' => new \Illuminate\View\ComponentAttributeBag(['class' => ''])])->render() . '</div>')
                ->class('w-full h-8 sm:h-auto sm:w-auto bg-red-100 sm:bg-red-0 text-red-600 hover:bg-red-200 py-2 px-2 rounded text-lg cursor-pointer hover:cursor-pointer hover:text-red-800')
                ->dispatchTo('demand.delete', 'delete-confirmation', ['ids' => [$row->id], 'tableName' => $this->tableName]);
        }

        return $actions;
    }

    public function actionRules($row): array
    {
        return [];
    }

    public function handlePageChange()
    {
        $this->checkboxAll = false;
        $this->checkboxValues = [];
    }

    #[On('deSelectCheckBoxEvent')]
    public function deSelectCheckBox(): bool
    {
        $this->checkboxAll = false;
        $this->checkboxValues = [];

        return true;
    }

    public function bulkDelete(): void
    {
        try {
            // Clear any existing error message
            if (! empty($this->checkboxValues)) {
                // Dispatch to the delete component
                $this->dispatch('bulk-delete-confirmation', [
                    'ids' => $this->checkboxValues,
                    'tableName' => $this->tableName,
                ]);
            } else {
                // Show flash message using Livewire event
                session()->flash('error', __('messages.bulk_delete.no_users_selected'));
            }
        } catch (Throwable $e) {
            // Defer logging to run after response
            defer(function () use ($e) {
                logger()->error('App\Livewire\User\Table: bulkDelete: Throwable', [
                    'Message' => $e->getMessage(),
                    'TraceAsString' => $e->getTraceAsString(),
                ]);
            });
            session()->flash('error', __('messages.bulk_delete.failed'));
        }
    }
}
