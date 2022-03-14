<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
	 * user_type 1 = admin, 2 = api, 3 = customer
     */
    protected $fillable = [
        'member_id', 'email', 'password', 'user_type', 'verify_opt', 'mobile', 'first_name', 'last_name', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the full name of user
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    /**
     * Get the registered date of user
     *
     * @return string
     */
    public function getRegisteredDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d g:i A');
    }

    /**
     * Get the user_addresses associated with user
     */
    public function userAddress()
    {
        return $this->hasOne('App\UserAddress');
    }
}
