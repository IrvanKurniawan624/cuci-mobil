<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCustomer extends Model
{
    use HasFactory;

    protected $table = 'master_customer';
    protected $guarded = [];
    protected $primaryKey = 'plat_nomor';

    protected $casts = [
        'plat_nomor' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function transaksi(){
        return $this->hasMany(Transaksi::class, 'master_customer_plat_nomor', 'plat_nomor');    
    }
}
