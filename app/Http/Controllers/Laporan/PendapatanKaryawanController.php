<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\TransaksiKaryawan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendapatanKaryawanController extends Controller
{
    public function index(){
        return view('laporan.pendapatan-karyawan');
    }

    public function detail(Request $request){
        $data = TransaksiKaryawan::with('transaksi')
            ->where('user_id', $request->id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->startDate, $request->endDate])
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function datatables(){
        $today = Carbon::today();
        $data = TransaksiKaryawan::with('users')
            ->select('user_id', DB::raw('SUM(pendapatan) as total_pendapatan'))
            ->whereDate('created_at', $today)
            ->groupBy('user_id')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function change_date(Request $request){
        $data = TransaksiKaryawan::with('users')
            ->select('user_id', DB::raw('SUM(pendapatan) as total_pendapatan'))
            ->groupBy('user_id')
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->startDate, $request->endDate])
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
