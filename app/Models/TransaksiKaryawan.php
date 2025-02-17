<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiKaryawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksi_karyawan';
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('notSoftDeletedTransaksi', function ($builder) {
            $builder->whereHas('transaksi', function ($query) {
                // Add a condition to exclude soft-deleted transaksi records
                $query->whereNull('deleted_at');
            });
        });

        static::addGlobalScope('orderByDesc', function ($builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    #RELATIONAL
    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    #GET ATTRIBUTE

    #SET ATTRIBUTE
}
