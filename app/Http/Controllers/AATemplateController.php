<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MasterJenisMobilController extends Controller
{
    public function index(){
        return view('');
    }

    public function detail($id){
        $data = BobotBentuk::find($id);

        $message = 'Data detail berhasil ditampilkan';
        return ApiFormatter::success(200, $message, $data);
    }

    public function datatables(){
        $data = EmergencyCall::orderBy('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(Request $request){
        Dosen::updateOrCreate(['id' => $request->id],$request->all() );

        $message = 'Data berhasil disimpan';
        return ApiFormatter::success(200, $message);
    }

    public function delete($id){
        $delete = BobotBentuk::find($id);
        $delete->delete();

        $message = 'Data berhasil dihapus';
        return ApiFormatter::success(200, $message);
    }
}
