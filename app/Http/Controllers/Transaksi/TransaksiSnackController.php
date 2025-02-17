<?php

namespace App\Http\Controllers\Transaksi;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransaksiRequest;
use App\Http\Requests\TransaksiSnackRequest;
use App\Models\MasterCustomer;
use App\Models\MasterJenisMobil;
use App\Models\MasterPresentase;
use App\Models\MasterSnack;
use App\Models\Transaksi;
use App\Models\TransaksiKaryawan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class TransaksiSnackController extends Controller
{
    public function index(){
        return view('main.transaksi-snack');
    }

    public function datatables_snack(){
        $data = MasterSnack::where('stock','>',0)->orderBy('id','asc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store(TransaksiSnackRequest $request){
        DB::beginTransaction();
        try{
            $transaksiData = [
                'master_customer_plat_nomor' => null,
                'layanan_jasa' => $request->layanan_jasa,
                'total_harga' => $request->total_harga,
                'payment' => $request->payment,
                'presentase_kas' => $request->presentase_kas,
                'presentase_pekerja' => 0,
                'presentase_operasional' => 0,
                'information_snack' => $request->information_snack,
            ];
            
            if (collect(Auth::user()->hak_akses)->contains('changeDateTransaksi') && $request->tanggal_transaksi !== null) {
                $transaksiData['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->tanggal_transaksi . ' 12:00:00', 'Asia/Jakarta');
                $transaksiData['updated_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->tanggal_transaksi . ' 12:00:00', 'Asia/Jakarta');
            }

            Transaksi::create($transaksiData);

            DB::commit();
            $message = 'Data berhasil disimpan';
            return ApiFormatter::success(200, $message);

        } catch(\Exception $e){
            // $this->errorLog($e);
            return $e;

            $message = 'Oops! Terjadi kesalahan silahkan hubungi admin jika berkelanjutan';
            return ApiFormatter::error(500, $message);
        }
    }

    public function delete($id){
        $delete = Transaksi::find($id);
        $delete->deleted_by = auth()->user()->id;
        $delete->save();

        $message = 'Data berhasil dihapus';
        return ApiFormatter::success(200, $message);
    }
}
