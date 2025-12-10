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

class Product extends Model
{
    use CommonTrait;
    use CreatedbyUpdatedby;
    use HasFactory;
    use ImportTrait;
    use Legendable;
    use SoftDeletes;
    use UploadTrait;

    protected $fillable = ['name', 'chr_code', 'hsn_code', 'category', 'unit', 'tax_rate', 'cess', 'opening_quantity', 'opening_rate', 'purchase_rate', 'opening_value', 'selling_rate'];

    protected $casts = [

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The unit relationship.
     */
    public static function unit()
    {
        return collect(
            [['key' => 'LI', 'label' => 'Liter'], ['key' => 'ML', 'label' => 'Milliliter'], ['key' => 'GA', 'label' => 'Gallon'], ['key' => 'PT', 'label' => 'Pint'], ['key' => 'QT', 'label' => 'QTY'], ['key' => 'CU', 'label' => 'Cup']]
        );
    }
}
