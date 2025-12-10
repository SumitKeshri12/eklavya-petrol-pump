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

class Transaction extends Model
{
    use CommonTrait;
    use CreatedbyUpdatedby;
    use HasFactory;
    use ImportTrait;
    use Legendable;
    use SoftDeletes;
    use UploadTrait;

    protected $fillable = ['shift_id', 'vehicle_number', 'user_id', 'with_vehicle', 'mobile_number', 'fuel_type', 'payment_type', 'payment_method', 'volume_liters', 'amount', 'count', 'remark', 'status'];

    protected $casts = [

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
