<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

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
        'permission' => 'array',
    ];

    // Define a mutator to automatically encode the 'hak_akses' attribute
    public function setHakAksesAttribute($value)
    {
        $this->attributes['hak_akses'] = json_encode($value, JSON_UNESCAPED_SLASHES);
    }

    // Define an accessor to automatically decode the 'hak_akses' attribute
    public function getHakAksesAttribute($value)
    {
        return json_decode($value, true);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!isset($model->level)) {
                $model->level = 1;
            }
        });
    }

    public function getLevelAttribute($value)
    {
        // Modify the level attribute as needed
        if ($value == 1) {
            return 'karyawan'; // Change the value for level 1 to 'karyawan'
        } elseif ($value == 0) {
            return 'superadmin'; // Change the value for level 0 to 'superadmin'
        }

        // For other levels, keep the original value
        return $value;
    }
}
