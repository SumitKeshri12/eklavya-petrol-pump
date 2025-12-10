<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helper;
use App\Traits\CommonTrait;
use App\Traits\CreatedbyUpdatedby;
use App\Traits\ImportTrait;
use App\Traits\Legendable;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use CommonTrait;
    use CreatedbyUpdatedby;
    use HasFactory;
    use ImportTrait;
    use Legendable;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;
    use UploadTrait;

    protected $fillable = ['role_id', 'user_code', 'user_type', 'party_type', 'first_name', 'last_name', 'party_name', 'email', 'mobile_number', 'aadhar_no', 'esic_number', 'pancard', 'profile', 'bank_name', 'account_number', 'ifsc_code', 'account_holder_name', 'gstin', 'tan_number', 'status', 'last_login_at', 'locale'];

    public $legend = ['{{users_name}}', '{{users_email}}'];

    protected $casts = [

    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The party_type relationship.
     */
    public static function party_type()
    {
        return collect(
            [['key' => 'I', 'label' => 'Individual'], ['key' => 'B', 'label' => 'Business']]
        );
    }

    /**
     * The status relationship.
     */
    public static function status()
    {
        return collect(
            [['key' => 'Y', 'label' => 'Active'], ['key' => 'N', 'label' => 'Inactive']]
        );
    }

    public function hasPermission($permission, $roleId)
    {
        $permissions = Helper::getCachedPermissionsByRole($roleId);

        return in_array($permission, $permissions);
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string|null
     */
    public function getProfileAttribute($value)
    {
        if (! empty($value) && $this->is_file_exists($value)) {
            return $this->getFilePathByStorage($value);
        }

        return null;
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
