<?php

namespace App\Http\Controllers\Home;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    private static $bulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );

    private function bulan_tahun(){
        $carbonDate = Carbon::now();

        // Format the date to 'Y-m-d' (year-month-day)
        $formattedDate = $carbonDate->format('Y-m-d');

        $bulan = self::$bulan;
        $pecahkan = explode('-', $formattedDate);
        
    
        return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    public function index(){
        $data['month_year_ind'] = $this->bulan_tahun(); 
        $today = Carbon::today();
        $data['pendapatan_hari_ini'] = Transaksi::withoutGlobalScope('orderByDesc')->selectRaw('SUM(total_harga) as total_pendapatan, SUM(total_harga * (presentase_pekerja / 100)) as karyawan_percentage, SUM(total_harga * (presentase_kas / 100)) as owner_percentage, SUM(total_harga * (presentase_operasional / 100)) as operasional_percentage')
            ->whereDate('created_at', $today)
            ->first();

        $data['pendapatan_bulan_ini'] = Transaksi::withoutGlobalScope('orderByDesc')->selectRaw('SUM(total_harga) as total_pendapatan, SUM(total_harga * (presentase_pekerja / 100)) as karyawan_percentage, SUM(total_harga * (presentase_kas / 100)) as owner_percentage, SUM(total_harga * (presentase_operasional / 100)) as operasional_percentage')
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();


            return view('dashboard.index', $data);
        }

    public function get_data(){
        $endDate = Carbon::now(); // Current date and time
        $startDate = $endDate->copy()->subDays(4); // Five days ago
        $raw['raw_pendapatan_5_hari'] = Transaksi::selectRaw('DATE(created_at) as transaction_date, COALESCE(SUM(total_harga * (presentase_pekerja / 100))) as karyawan_percentage, SUM(total_harga * (presentase_kas / 100)) as owner_percentage, SUM(total_harga * (presentase_operasional / 100)) as operasional_percentage')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->get();

        $start_date = Carbon::parse($startDate);
        $end_date = Carbon::parse($endDate);
        $period = CarbonPeriod::create($start_date, $end_date);
        $dates = $period->toArray();
        $array = [];
        foreach ($dates as $date) {
            $date = $date->toDateString();

            if(!empty($raw['raw_pendapatan_5_hari']->where('transaction_date', $date)->first())){
                $array[] = $raw['raw_pendapatan_5_hari']->where('transaction_date', $date)->first();
            }else{
                $array[] = [
                    'transaction_date' => $date,
                    'karyawan_percentage' => 0,
                    'owner_percentage' => 0,
                    'operasional_percentage' => 0
                ];
            }
        }

        $array_date = [];
        $array_owner = [];
        $array_karyawan = [];
        $array_operasional = [];
        foreach ($array as $item) {
            array_push($array_date, $item['transaction_date']);
            array_push($array_owner, $item['owner_percentage']);
            array_push($array_karyawan, $item['karyawan_percentage']);
            array_push($array_operasional, $item['operasional_percentage']);
        }

        $data['date_list'] = $array_date;
        $data['owner_percentage_list'] = $array_owner;
        $data['karyawan_percentage_list'] = $array_karyawan;
        $data['operasional_percentage_list'] = $array_operasional;

        return ApiFormatter::success(200, 'success', $data);
    }
}
