<?php

namespace App\Livewire\Product;

use App\Helper;
use App\Jobs\ExportProductTable;
use App\Models\Product;
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

    public string $sortField = 'products.id';

    public string $sortDirection = 'desc';

    // Custom per page
    public int $perPage;

    // Custom per page values
    public array $perPageValues;

    public $currentUser;

    public function __construct()
    {
        if (! Gate::allows('view-product')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->tableName = __('messages.product.listing.tableName');
        $this->perPage = config('constants.webPerPage');
        $this->perPageValues = config('constants.webPerPageValues');
    }

    public function exportData()
    {
        try {
            // Define export parameters
            $exportClass = ExportProductTable::class;
            $headingColumn = 'Name,HsnCode,Category,Unit,TaxRate,OpeningQuantity,OpeningRate,PurchaseRate,SellingRate';
            $batchName = 'Export Product Table';
            $downloadPrefixFileName = 'ProductReports_';
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
            logger()->error('App\Livewire\ProductTable: exportData: Throwable', ['Message' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            session()->flash('error', __('messages.product.messages.common_error_message'));

            return false;
        }
    }

    public function header(): array
    {
        $headerArray = [];

        if (Gate::allows('add-product')) {
            $headerArray[] = Button::add('add-product')
                ->slot('    <a href="/product/create" title="Add New Product" data-testid="add_new" class="flex items-center justify-center cursor-pointer" wire:navigate>
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

        if (Gate::allows('export-product')) {
            $headerArray[] = Button::add('export-data')
                ->slot('<a href="javascript:void(0);" title="Export Product" data-testid="export_button" wire:click="exportData" class="flex items-center justify-center" wire:loading.attr="disabled">
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

        if (Gate::allows('bulkDelete-product')) {
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
                    title="Bulk Delete Products">
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
        return Product::query()

            ->select([
                'products.id', 'products.name', 'products.hsn_code', 'products.category',
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

            Column::make(__('messages.product.listing.id'), 'id')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.product.listing.name'), 'name')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.product.listing.hsn_code'), 'hsn_code')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.product.listing.category'), 'category')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.product.listing.unit'), 'unit')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.product.listing.tax_rate'), 'tax_rate')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.product.listing.opening_quantity'), 'opening_quantity')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.product.listing.opening_rate'), 'opening_rate')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.product.listing.purchase_rate'), 'purchase_rate')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.product.listing.selling_rate'), 'selling_rate')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.created_date'), 'created_at_formatted', 'created_at'),
            Column::action(__('messages.product.listing.actions')),
        ];
    }

    public function filters(): array
    {
        return [

            Filter::inputText('name', 'products.name')->operators(['contains']),
            Filter::inputText('hsn_code', 'products.hsn_code')->operators(['contains']),
            Filter::inputText('category', 'products.category')->operators(['contains']),
            Filter::select('unit', 'unit')
                ->dataSource(Product::unit())
                ->optionLabel('label')
                ->optionValue('key'),
            Filter::inputText('tax_rate', 'products.tax_rate')->operators(['contains']),
            Filter::inputText('opening_quantity', 'products.opening_quantity')->operators(['contains']),
            Filter::inputText('opening_rate', 'products.opening_rate')->operators(['contains']),
            Filter::inputText('purchase_rate', 'products.purchase_rate')->operators(['contains']),
            Filter::inputText('selling_rate', 'products.selling_rate')->operators(['contains']),
            Filter::datetimepicker('created_at'),
        ];
    }

    #[On('edit')]
    public function edit($id)
    {
        return $this->redirect('product/' . $id . '/edit', navigate: true); // redirect to edit component
    }

    public function actions(Product $row): array
    {
        $actions = [];

        if (Gate::allows('show-product')) {
            $actions[] = Button::add('view')
                ->slot('<div title="' . __('messages.tooltip.view') . '" class="flex items-center justify-center" data-testid="view_button">' . view('components.flux.icon.eye', ['variant' => 'micro', 'attributes' => new \Illuminate\View\ComponentAttributeBag(['class' => ''])])->render() . '</div>')
                ->class('w-full sm:w-auto text-gray-600 bg-gray-200 hover:bg-gray-300 py-2 px-2 rounded text-lg cursor-pointer hover:cursor-pointer text-gray-500 hover:text-gray-900')
                ->dispatchTo('product.show', 'show-product-info', ['id' => $row->id]);
        }

        if (Gate::allows('edit-product')) {
            $actions[] = Button::add('edit')
                ->slot('<div title="Edit" class="flex items-center justify-center" data-testid="edit_button">' . view('components.flux.icon.pencil', ['variant' => 'micro', 'attributes' => new \Illuminate\View\ComponentAttributeBag(['class' => ''])])->render() . '</div>')
                ->class('w-full sm:w-auto text-gray-600 bg-gray-200 hover:bg-gray-300 py-2 px-2 rounded text-lg cursor-pointer hover:cursor-pointer text-gray-500 hover:text-gray-900')
                ->dispatch('edit', ['id' => $row->id]);
        }

        if (Gate::allows('delete-product')) {
            $actions[] = Button::add('delete-product')
                ->slot('<div title="' . __('messages.tooltip.click_delete') . '" class="flex items-center justify-center" data-testid="delete_button">' . view('components.flux.icon.trash', ['variant' => 'micro', 'attributes' => new \Illuminate\View\ComponentAttributeBag(['class' => ''])])->render() . '</div>')
                ->class('w-full h-8 sm:h-auto sm:w-auto bg-red-100 sm:bg-red-0 text-red-600 hover:bg-red-200 py-2 px-2 rounded text-lg cursor-pointer hover:cursor-pointer hover:text-red-800')
                ->dispatchTo('product.delete', 'delete-confirmation', ['ids' => [$row->id], 'tableName' => $this->tableName]);
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
