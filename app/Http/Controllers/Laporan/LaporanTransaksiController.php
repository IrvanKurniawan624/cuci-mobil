<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class LaporanTransaksiController extends Controller
{
    public function index(){
        return view('laporan.laporan-transaksi');
    }

    public function detail($id){
        return Transaksi::with(['transaksi_karyawan.users' => function ($query) {
                    $query->addSelect(['id', 'name']);
                }])
                ->with('master_customer')
                ->find($id);
    }

    public function datatables(){
        $today = Carbon::today();
        $data = Transaksi::with(['transaksi_karyawan.users' => function ($query) {
                $query->addSelect(['id', 'name']);
            }, 'master_customer'])
            ->whereDate('created_at', $today)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function change_date(Request $request){
        $data = Transaksi::with(['transaksi_karyawan.users' => function ($query) {
                $query->addSelect(['id', 'name']);
            }, 'master_customer'])
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->startDate, $request->endDate])
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
