<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterJenisMobilRequest;
use App\Models\MasterJenisMobil;
use Yajra\DataTables\DataTables;

class MasterJenisMobilController extends Controller
{
    public function index(){
        return view('master.jenis-mobil');
    }

    public function detail($id){
        $data = MasterJenisMobil::find($id);

        $message = 'Data detail berhasil ditampilkan';
        return ApiFormatter::success(200, $message, $data);
    }

    public function datatables(){
        $data = MasterJenisMobil::orderBy('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(MasterJenisMobilRequest $request){
        MasterJenisMobil::updateOrCreate(['id' => $request->id],$request->all() );

        $message = 'Data berhasil disimpan';
        return ApiFormatter::success(200, $message);
    }

    public function delete($id){
        $delete = MasterJenisMobil::find($id);
        $delete->delete();

        $message = 'Data berhasil dihapus';
        return ApiFormatter::success(200, $message);
    }
}
