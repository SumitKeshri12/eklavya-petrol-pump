<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DropzoneComponent extends Component
{
    public $importData;

    public $userID;

    /**
     * mount
     *
     * @param mixed $importData
     */
    public function mount($importData)
    {
        $user = Auth::user();
        $this->importData = $importData;
        $this->userID = $user->id;
    }

    public function downloadSampleCsv()
    {
        if ($this->importData['modelName'] == config('constants.import_csv_log.models.role')) {
            $filePath = public_path('samples/import_sample_role.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.user')) {
            $filePath = public_path('samples/import_sample_user.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.fuelconfig')) {
            $filePath = public_path('samples/import_sample_fuelconfig.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.product')) {
            $filePath = public_path('samples/import_sample_product.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.dispenser')) {
            $filePath = public_path('samples/import_sample_dispenser.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.vehicle')) {
            $filePath = public_path('samples/import_sample_vehicle.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.organization')) {
            $filePath = public_path('samples/import_sample_organization.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.shift')) {
            $filePath = public_path('samples/import_sample_shift.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.sanction')) {
            $filePath = public_path('samples/import_sample_sanction.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.demand')) {
            $filePath = public_path('samples/import_sample_demand.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.pushnotificationtemplate')) {
            $filePath = public_path('samples/import_sample_pushnotificationtemplate.csv');
        } elseif ($this->importData['modelName'] == config('constants.import_csv_log.models.smstemplate')) {
            $filePath = public_path('samples/import_sample_smstemplate.csv');
        } else {
            $filePath = ''; // Default file path
        }

        if ($filePath != '') {
            return response()->download($filePath);
        } else {
            session()->flash('error', __('messages.something_went_wrong'));
        }
    }

    public function render()
    {
        return view('livewire.dropzone-component');
    }
}
