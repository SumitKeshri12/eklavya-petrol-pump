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

class PushNotificationTemplate extends Model
{
    use CommonTrait;
    use CreatedbyUpdatedby;
    use HasFactory;
    use ImportTrait;
    use Legendable;
    use SoftDeletes;
    use UploadTrait;

    protected $fillable = ['type', 'label', 'title', 'body', 'image', 'button_name', 'button_link', 'status'];

    protected $casts = [

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The status relationship.
     */
    public static function status()
    {
        return collect(
            [['key' => 'I', 'label' => 'Inactive'], ['key' => 'A', 'label' => 'Active']]
        );
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string|null
     */
    public function getImageAttribute($value)
    {
        if (! empty($value) && $this->is_file_exists($value)) {
            return $this->getFilePathByStorage($value);
        }

        return null;
    }
}
