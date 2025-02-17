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

        $transaksi = Transaksi::with('transaksi_karyawan')->whereDate('created_at', $today)->get();

        $array = [];
        foreach($transaksi as $item){
            //! PRESENTASE KAS
            if($item->presentase_kas > 0){
                $array[] = [
                    'desc' => "[KAS][$item->layanan_jasa] $item->master_customer_plat_nomor",
                    'payment' => $item->payment,
                    'in' => $item->total_harga * ($item->presentase_kas / 100),
                    'out' => 0,
                ];
            }

            //! PRESENTASE OPERASIONAL
            if($item->presentase_operasional > 0){
                $array[] = [
                    'desc' => "[OPS][$item->layanan_jasa] $item->master_customer_plat_nomor",
                    'payment' => $item->payment,
                    'in' => $item->total_harga * ($item->presentase_operasional / 100),
                    'out' => 0,
                ];
            }

            //! PRESENTASE PEKERJA
            if($item->presentase_pekerja > 0){
                $array[] = [
                    'desc' => "[WORKER][$item->layanan_jasa] $item->master_customer_plat_nomor",
                    'payment' => $item->payment,
                    'in' => 0,
                    'out' => $item->total_harga * ($item->presentase_pekerja / 100),
                ];
            }
        }

        return DataTables::of($array)
            ->addIndexColumn()
            ->make(true);
    }

    public function change_date(Request $request){

            $transaksi = Transaksi::with('transaksi_karyawan')->whereBetween(DB::raw('DATE(created_at)'), [$request->startDate, $request->endDate])->get();

            $array = [];
            foreach($transaksi as $item){
                 //! PRESENTASE KAS
                if($item->presentase_kas > 0){
                    $array[] = [
                        'desc' => "[KAS][$item->layanan_jasa] $item->master_customer_plat_nomor",
                        'payment' => $item->payment,
                        'in' => $item->total_harga * ($item->presentase_kas / 100),
                        'out' => 0,
                    ];
                }

                //! PRESENTASE OPERASIONAL
                if($item->presentase_operasional > 0){
                    $array[] = [
                        'desc' => "[OPS][$item->layanan_jasa] $item->master_customer_plat_nomor",
                        'payment' => $item->payment,
                        'in' => $item->total_harga * ($item->presentase_operasional / 100),
                        'out' => 0,
                    ];
                }

                //! PRESENTASE PEKERJA
                if($item->presentase_pekerja > 0){
                    $array[] = [
                        'desc' => "[WORKER][$item->layanan_jasa] $item->master_customer_plat_nomor",
                        'payment' => $item->payment,
                        'in' => 0,
                        'out' => $item->total_harga * ($item->presentase_pekerja / 100),
                    ];
                }
            }

            return DataTables::of($array)
                ->addIndexColumn()
                ->make(true);
    }
}
