<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\ApiFormatter;
use Yajra\DataTables\DataTables;
use App\Http\Requests\MasterKaryawanRequest;

class MasterKaryawanController extends Controller
{
    public function index(){
        return view('master.karyawan');
    }

    public function detail($id){
        $data = User::find($id);

        $message = 'Data detail berhasil ditampilkan';
        return ApiFormatter::success(200, $message, $data);
    }

    public function datatables(){
        $data = User::where('level', 1)->orderBy('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(MasterKaryawanRequest $request){
        User::updateOrCreate(['id' => $request->id],$request->all() );

        $message = 'Data berhasil disimpan';
        return ApiFormatter::success(200, $message);
    }

    public function delete($id){
        $delete = User::find($id);
        $delete->delete();

        $message = 'Data berhasil dihapus';
        return ApiFormatter::success(200, $message);
    }
}
