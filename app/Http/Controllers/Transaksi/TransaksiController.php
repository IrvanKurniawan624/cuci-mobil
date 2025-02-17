<?php

namespace App\Http\Controllers\Transaksi;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransaksiRequest;
use App\Models\MasterCustomer;
use App\Models\MasterJenisMobil;
use App\Models\MasterPresentase;
use App\Models\Transaksi;
use App\Models\TransaksiKaryawan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(){
        $data['jenis_mobil'] = MasterJenisMobil::orderBy('id', 'asc')->get();
        $data['pegawais'] = User::where('level', 1)->orderBy('id', 'asc')->get();
        $data['presentase'] = DB::table('master_presentase')
            ->select(
                'id', 'name',
                DB::raw('`presentase-kas` as presentase_kas'),
                DB::raw('`presentase-pekerja` as presentase_pekerja'),
                DB::raw('`presentase-operasional` as presentase_operasional')
            )
            ->get();
        return view('main.transaksi', $data);
    }

    public function suggestion_plat($input){
        return MasterCustomer::where('plat_nomor', 'like', '%' . $input . '%')->select(['plat_nomor', 'name', 'jenis_mobil', 'no_telepon', 'mobil'])->get();
    }

    public function store(TransaksiRequest $request){
        DB::beginTransaction();
        try{
            MasterCustomer::updateOrCreate(['plat_nomor' => $request->plat_nomor], [
                "plat_nomor" => $request->plat_nomor,
                "name" => $request->name,
                "jenis_mobil" => $request->jenis_mobil,
                "mobil" => $request->mobil,
                "no_telepon" => $request->no_telepon,
            ]);

            $transaksiData = [
                'master_customer_plat_nomor' => $request->plat_nomor,
                'layanan_jasa' => $request->layanan_jasa,
                'total_harga' => $request->total_harga,
                'payment' => $request->payment,
                'presentase_kas' => $request->presentase_kas,
                'presentase_pekerja' => $request->presentase_pekerja,
                'presentase_operasional' => $request->presentase_operasional,
            ];

            if (collect(Auth::user()->hak_akses)->contains('changeDateTransaksi') && $request->tanggal_transaksi !== null) {
                $transaksiData['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->tanggal_transaksi . ' 12:00:00', 'Asia/Jakarta');
                $transaksiData['updated_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->tanggal_transaksi . ' 12:00:00', 'Asia/Jakarta');
            }

            $transaksi = Transaksi::create($transaksiData);

            $pendapatan_pekerja = $request->total_harga * ($request->presentase_pekerja / 100) / count($request->master_karyawan_id);

            foreach($request->master_karyawan_id as $item) {
                $transaksiKaryawanData = [
                    'transaksi_id' => $transaksi->id,
                    'user_id' => $item,
                    'pendapatan' => $pendapatan_pekerja,
                ];

                if(isset($transaksiData['created_at'])) {
                    $transaksiKaryawanData['created_at'] = $transaksiData['created_at'];
                    $transaksiKaryawanData['updated_at'] = $transaksiData['updated_at'];
                }

                TransaksiKaryawan::create($transaksiKaryawanData);
            }

            DB::commit();
            $message = 'Data berhasil disimpan';
            return ApiFormatter::success(200, $message);

        } catch(\Exception $e){
            // $this->errorLog($e);
            // return $e;

            $message = 'Oops! Terjadi kesalahan silahkan hubungi admin jika berkelanjutan';
            return ApiFormatter::error(500, $message);
        }
    }

    public function delete($id){
        $delete = Transaksi::find($id);
        $delete->deleted_by = auth()->user()->id;
        $delete->save();

        //delete transaksi karyawan
        TransaksiKaryawan::where('transaksi_id', $id)->delete();

        //delete data
        $delete->delete();

        $message = 'Data berhasil dihapus';
        return ApiFormatter::success(200, $message);
    }
}
