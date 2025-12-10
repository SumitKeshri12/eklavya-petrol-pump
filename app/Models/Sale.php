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

class Sale extends Model
{
    use CommonTrait;
    use CreatedbyUpdatedby;
    use HasFactory;
    use ImportTrait;
    use Legendable;
    use SoftDeletes;
    use UploadTrait;

    protected $fillable = ['shift_id', 'nozzle_id', 'date', 'test_ltr', 'cash_collected', 'online_collected', 'credit_sales', 'petrol_consumed', 'diesel_consumed'];

    protected $casts = [

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
