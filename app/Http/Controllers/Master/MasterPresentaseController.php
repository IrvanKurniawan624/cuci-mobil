<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterPresentaseRequest;
use App\Models\MasterPresentase;
use Yajra\DataTables\DataTables;

class MasterPresentaseController extends Controller
{
    public function index(){
        return view('master.presentase');
    }

    public function detail($id){
        $data = MasterPresentase::find($id);

        $message = 'Data detail berhasil ditampilkan';
        return ApiFormatter::success(200, $message, $data);
    }

    public function datatables(){
        $data = MasterPresentase::orderBy('id','asc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(MasterPresentaseRequest $request){
        MasterPresentase::updateOrCreate(['id' => $request->id],$request->all() );

        $message = 'Data berhasil disimpan';
        return ApiFormatter::success(200, $message);
    }

    public function delete($id){
        $delete = MasterPresentase::find($id);
        $delete->delete();

        $message = 'Data berhasil dihapus';
        return ApiFormatter::success(200, $message);
    }
}
