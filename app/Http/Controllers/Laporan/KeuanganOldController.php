<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class KeuanganController extends Controller
{
    public function index(){
        return view('laporan.keuangan');
    }

    public function datatables(){
        $today = Carbon::today();
        $data = Transaksi::selectRaw('layanan_jasa, SUM(total_harga * (presentase_pekerja / 100)) as karyawan_percentage, SUM(total_harga * (presentase_kas / 100)) as owner_percentage, SUM(total_harga * (presentase_operasional / 100)) as operasional_percentage')
            ->groupBy('layanan_jasa')
            ->whereDate('created_at', $today)
            ->get();
        $data = $data->map(function ($item) {
            $fieldsToFormat = ['karyawan_percentage', 'owner_percentage', 'operasional_percentage'];
            foreach ($fieldsToFormat as $field) {
                $item->$field = number_format((float) $item->$field, 0, '.', '');
            }
            return $item;
        });
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function change_date(Request $request){
        $data = Transaksi::selectRaw('layanan_jasa, SUM(total_harga * (presentase_pekerja / 100)) as karyawan_percentage, SUM(total_harga * (presentase_kas / 100)) as owner_percentage, SUM(total_harga * (presentase_operasional / 100)) as operasional_percentage')
            ->groupBy('layanan_jasa')
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->startDate, $request->endDate])
            ->get();
        $data = $data->map(function ($item) {
            $fieldsToFormat = ['karyawan_percentage', 'owner_percentage', 'operasional_percentage'];
            foreach ($fieldsToFormat as $field) {
                $item->$field = number_format((float) $item->$field, 0, '.', '');
            }
            return $item;
        });
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
