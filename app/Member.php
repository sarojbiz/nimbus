<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'users';

    /**
     * Get the full name of delivery person
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    /**
     * Get the orders associated with delivery person
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * generate random number for referral code
     */
    public function generateReferralCode() {
        $number = mt_rand(100000, 999999);
    
        if ($this->referalCodeExists($number)) {
            return generateReferralCode();
        }
    
        return 'A-'.$number;
    }
    
    /**
     * check for random number for referral code
     */
    public function referalCodeExists($number) {
        return User::where('referral_code', $number)->exists();
    }
}
