<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function vip()
    {
        return $this->hasOne(Vip::class);
    }

    public function isVip()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $vip = $this->vip()->where('end_date', '>=', $currentDate)->first();

        return $vip ? true : false;
    }

    public function remainingVipDays()
    {
        if ($this->isVip()) {
            $currentDate = Carbon::now()->format('Y-m-d');
            $endDate = $this->vip->end_date;
            return Carbon::parse($endDate)->diffInDays($currentDate);
        }

        return 0;
    }
}
