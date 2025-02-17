<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\ApiFormatter;
use App\Http\Requests\HakAksesRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Request;

class HakAksesController extends Controller
{
    public function index(){
        return view('config.hak-akses');
    }

    public function detail($id){
        $data = User::find($id);

        $message = 'Data detail berhasil ditampilkan';
        return ApiFormatter::success(200, $message, $data);
    }

    public function datatables(){
        $data = User::where('level', 0)->orderBy('name','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(HakAksesRequest $request){
        if(empty($request->hak_akses)){
            return ApiFormatter::error(500, 'Hak Akses Harus Terisi');
        }
        
        $hak_akses = array_filter($request->hak_akses);

        $attributes = [
            'name' => $request->name,
            'email' => $request->email,
            'level' => 0,
            'hak_akses' => $hak_akses, 
        ];
        
        $password = $request->password !== null ? Hash::make($request->password) : null;
        if ($password !== null) {
            $attributes['password'] = $password;
        }

        User::updateOrCreate(['id' => $request->id], $attributes);
        $message = 'Data berhasil disimpan';
        if($request->id == Auth::user()->id){
            return ApiFormatter::success(201, $message, '/config/hak-akses');
        }

        return ApiFormatter::success(200, $message);
    }

    public function delete($id){
        $delete = User::find($id);
        $delete->delete();
        $message = 'Data berhasil dihapus';
        return ApiFormatter::success(200, $message);
    }
}
