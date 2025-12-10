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

class Shift extends Model
{
    use CommonTrait;
    use CreatedbyUpdatedby;
    use HasFactory;
    use ImportTrait;
    use Legendable;
    use SoftDeletes;
    use UploadTrait;

    protected $fillable = ['user_id', 'start_time', 'end_time', 'status'];

    protected $casts = [

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The status relationship.
     */
    public static function status()
    {
        return collect(
            [['key' => 'O', 'label' => 'Ongoing'], ['key' => 'C', 'label' => 'Completed']]
        );
    }
}
