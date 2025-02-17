<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterSnackRequest;
use App\Models\MasterSnack;
use Yajra\DataTables\DataTables;

class MasterSnackController extends Controller
{
    public function index(){
        return view('master.snack');
    }

    public function detail($id){
        $data = MasterSnack::find($id);

        $message = 'Data detail berhasil ditampilkan';
        return ApiFormatter::success(200, $message, $data);
    }

    public function datatables(){
        $data = MasterSnack::orderBy('id','asc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(MasterSnackRequest $request){
        MasterSnack::updateOrCreate(['id' => $request->id],$request->all() );

        $message = 'Data berhasil disimpan';
        return ApiFormatter::success(200, $message);
    }

    public function delete($id){
        $delete = MasterSnack::find($id);
        $delete->delete();

        $message = 'Data berhasil dihapus';
        return ApiFormatter::success(200, $message);
    }
}
