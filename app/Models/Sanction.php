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

class Sanction extends Model
{
    use CommonTrait;
    use CreatedbyUpdatedby;
    use HasFactory;
    use ImportTrait;
    use Legendable;
    use SoftDeletes;
    use UploadTrait;

    protected $fillable = ['user_id', 'month', 'year', 'fuel_type', 'quantity', 'remarks'];

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
}
