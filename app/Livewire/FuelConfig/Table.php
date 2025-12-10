<?php

namespace App\Livewire\FuelConfig;

use App\Helper;
use App\Jobs\ExportFuelConfigTable;
use App\Models\FuelConfig;
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

    public string $sortField = 'fuel_configs.id';

    public string $sortDirection = 'desc';

    // Custom per page
    public int $perPage;

    // Custom per page values
    public array $perPageValues;

    public $currentUser;

    public function __construct()
    {
        if (! Gate::allows('view-fuel-config')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->tableName = __('messages.fuel_config.listing.tableName');
        $this->perPage = config('constants.webPerPage');
        $this->perPageValues = config('constants.webPerPageValues');
    }

    public function exportData()
    {
        try {
            // Define export parameters
            $exportClass = ExportFuelConfigTable::class;
            $headingColumn = 'FuelType,Price,Date';
            $batchName = 'Export FuelConfig Table';
            $downloadPrefixFileName = 'FuelConfigReports_';
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
            logger()->error('App\Livewire\FuelConfigTable: exportData: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            session()->flash('error', __('messages.fuelconfig.messages.common_error_message'));

            return false;
        }
    }

    public function header(): array
    {
        $headerArray = [];

        if (Gate::allows('add-fuel-config')) {
            $headerArray[] = Button::add('add-fuel-config')
                ->slot('    <a href="/fuel-config/create" title="Add New FuelConfig" data-testid="add_new" class="flex items-center justify-center cursor-pointer" wire:navigate>
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

        if (Gate::allows('export-fuel-config')) {
            $headerArray[] = Button::add('export-data')
                ->slot('<a href="javascript:void(0);" title="Export FuelConfig" data-testid="export_button" wire:click="exportData" class="flex items-center justify-center" wire:loading.attr="disabled">
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

        if (Gate::allows('bulkDelete-fuel-config')) {
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
                    title="Bulk Delete FuelConfigs">
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
        return FuelConfig::query()

            ->select([
                'fuel_configs.id',
                DB::raw(
                    '(CASE
                                                WHEN fuel_configs.fuel_type = "' . config('constants.fuel_config.fuel_type.key.petrol') . '" THEN  "' . config('constants.fuel_config.fuel_type.value.petrol') . '"
                                                WHEN fuel_configs.fuel_type = "' . config('constants.fuel_config.fuel_type.key.diesel') . '" THEN  "' . config('constants.fuel_config.fuel_type.value.diesel') . '"
                                        ELSE " "
                                        END) AS fuel_type'
                ), 'fuel_configs.price', 'fuel_configs.date',
            ]);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('date_formatted', fn ($row) => Carbon::parse($row->date)->format(config('constants.default_date_format')))
            ->add('created_at_formatted', fn ($row) => Carbon::parse($row->created_at)->format(config('constants.default_datetime_format')));
    }

    public function columns(): array
    {
        return [

            Column::make(__('messages.fuel_config.listing.id'), 'id')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.fuel_config.listing.fuel_type'), 'fuel_type')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.fuel_config.listing.price'), 'price')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.fuel_config.listing.date'), 'date_formatted', 'date')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.created_date'), 'created_at_formatted', 'created_at'),
            Column::action(__('messages.fuel_config.listing.actions')),
        ];
    }

    public function filters(): array
    {
        return [

            Filter::select('fuel_type', 'fuel_type')
                ->dataSource(FuelConfig::fuel_type())
                ->optionLabel('label')
                ->optionValue('key'),
            Filter::inputText('price', 'fuel_configs.price')->operators(['contains']),
            Filter::datepicker('date'),
            Filter::datetimepicker('created_at'),
        ];
    }

    #[On('edit')]
    public function edit($id)
    {
        return $this->redirect('fuel-config/' . $id . '/edit', navigate: true); // redirect to edit component
    }

    public function actions(FuelConfig $row): array
    {
        $actions = [];

        if (Gate::allows('show-fuel-config')) {
            $actions[] = Button::add('view')
                ->slot('<div title="' . __('messages.tooltip.view') . '" class="flex items-center justify-center" data-testid="view_button">' . view('components.flux.icon.eye', ['variant' => 'micro', 'attributes' => new \Illuminate\View\ComponentAttributeBag(['class' => ''])])->render() . '</div>')
                ->class('w-full sm:w-auto text-gray-600 bg-gray-200 hover:bg-gray-300 py-2 px-2 rounded text-lg cursor-pointer hover:cursor-pointer text-gray-500 hover:text-gray-900')
                ->dispatchTo('fuel-config.show', 'show-fuelconfig-info', ['id' => $row->id]);
        }

        if (Gate::allows('edit-fuel-config')) {
            $actions[] = Button::add('edit')
                ->slot('<div title="Edit" class="flex items-center justify-center" data-testid="edit_button">' . view('components.flux.icon.pencil', ['variant' => 'micro', 'attributes' => new \Illuminate\View\ComponentAttributeBag(['class' => ''])])->render() . '</div>')
                ->class('w-full sm:w-auto text-gray-600 bg-gray-200 hover:bg-gray-300 py-2 px-2 rounded text-lg cursor-pointer hover:cursor-pointer text-gray-500 hover:text-gray-900')
                ->dispatch('edit', ['id' => $row->id]);
        }

        if (Gate::allows('delete-fuel-config')) {
            $actions[] = Button::add('delete-fuel-config')
                ->slot('<div title="' . __('messages.tooltip.click_delete') . '" class="flex items-center justify-center" data-testid="delete_button">' . view('components.flux.icon.trash', ['variant' => 'micro', 'attributes' => new \Illuminate\View\ComponentAttributeBag(['class' => ''])])->render() . '</div>')
                ->class('w-full h-8 sm:h-auto sm:w-auto bg-red-100 sm:bg-red-0 text-red-600 hover:bg-red-200 py-2 px-2 rounded text-lg cursor-pointer hover:cursor-pointer hover:text-red-800')
                ->dispatchTo('fuel-config.delete', 'delete-confirmation', ['ids' => [$row->id], 'tableName' => $this->tableName]);
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
