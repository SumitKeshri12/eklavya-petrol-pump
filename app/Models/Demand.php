<?php

namespace App\Models;

use App\Traits\CommonTrait;
use App\Traits\CreatedbyUpdatedby;
use App\Traits\ImportTrait;
use App\Traits\Legendable;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demand extends Model
{
    use CommonTrait;
    use CreatedbyUpdatedby;
    use HasFactory;
    use ImportTrait;
    use Legendable;
    use SoftDeletes;
    use UploadTrait;

    protected $fillable = ['user_id', 'fuel_type', 'demand_date', 'with_vehicle', 'vehicle_number', 'receiver_mobile_no', 'fuel_quantity', 'quantity_fullfill', 'outstanding_quantity', 'status', 'shift_id', 'nozzle_id', 'receipt_image', 'product_image', 'driver_image', 'vehicle_image'];

    protected $casts = [

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The fuel_type relationship.
     */
    public static function fuel_type()
    {
        return collect(
            [['key' => 'P', 'label' => 'Petrol'], ['key' => 'D', 'label' => 'Diesel']]
        );
    }

    /**
     * The with_vehicle relationship.
     */
    public static function with_vehicle()
    {
        return collect(
            [['key' => 'W', 'label' => 'With Vehicle'], ['key' => 'O', 'label' => 'Without Vehicle']]
        );
    }
}
