<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    
    public function login(Request $request){
        $validate = [
            'email'            => 'required',
            'password'         => 'required',
        ];

        $messages = [
            'email.required'   => 'Email wajib di isi',
            'password.required'     => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $validate, $messages);

        if($validator->fails()){
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        auth::attempt($data, true); // add parameter true to prevent logout when refresh

        if (Auth::check()) {

            if(auth()->user()->level !== 'superadmin'){
                return [
                    'status' => 300,
                    'message' => 'anda tidak berhak login',
                ];
            }

            return [
                'status' => 201,
                'message' => 'Anda berhasil login',
                'link' => '/dashboard',
            ];
        }else{

            return [
                'status' => 300,
                'message' => 'Username atau password anda salah silahkan coba lagi'
            ];
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
