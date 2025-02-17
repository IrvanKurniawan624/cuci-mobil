<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksi';
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByDesc', function ($builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    #RELATIONAL
    public function transaksi_karyawan(){
        return $this->hasMany(TransaksiKaryawan::class, 'transaksi_id');
    }

    public function master_customer(){
        return $this->belongsTo(MasterCustomer::class, 'master_customer_plat_nomor', 'plat_nomor');
    }

    #GET ATTRIBUTE

    #SET ATTRIBUTE
}
