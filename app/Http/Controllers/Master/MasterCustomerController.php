<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterCustomerRequest;
use App\Models\MasterCustomer;
use Yajra\DataTables\DataTables;

class MasterCustomerController extends Controller
{
    public function index(){
        return view('master.customer');
    }
    
    public function datatables(){
        $data = MasterCustomer::withCount(['transaksi as total_transaksi_count' => function ($query) {
            $query->whereColumn('plat_nomor', 'master_customer_plat_nomor');
        }])
        ->orderBy('created_at','desc')
        ->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }
}
