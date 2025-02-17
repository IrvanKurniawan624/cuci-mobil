<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function errorLog($exception){

        $user_id = null;
        if(auth('api')->check()){
            $user_id = auth('api')->user()->id;
        }

        //save error log to db
        ErrorLog::create([
            'user_id' => $user_id,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'log' => $exception->getMessage(),
        ]);
    }
}
