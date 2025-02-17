<?php

namespace App\Http\Requests;

use App\Models\MasterJenisMobil;
use App\Models\MasterPresentase;
use App\Rules\IgnoreHtmlTagRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;

class TransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'master_karyawan_id.*' => ['required', 'exists:users,id'],
            'plat_nomor' => ['required'],
            'master_jenis_mobil_id' => ['required', 'exists:master_jenis_mobil,id'],
            'layanan_jasa' => ['required', 'exists:master_presentase,id'],
            'total_harga' => ['required', 'integer'],
            'payment' => ['required', 'in:qris,tunai']
        ];
    }

    protected function passedValidation()
    {
        #PRESENTASE KAS | PRESENTASE PEKERJA | PRESENTASE OPERASIONAL
        $master_presentase = DB::table('master_presentase')
            ->select(
                'id', 'name',
                DB::raw('`presentase-kas` as presentase_kas'),
                DB::raw('`presentase-pekerja` as presentase_pekerja'),
                DB::raw('`presentase-operasional` as presentase_operasional')
            )
            ->where('id', $this->layanan_jasa)
            ->first();
        $this->merge(['layanan_jasa' => $master_presentase->name]);
        $this->merge(['presentase_kas' => $master_presentase->presentase_kas]);
        $this->merge(['presentase_pekerja' => $master_presentase->presentase_pekerja]);
        $this->merge(['presentase_operasional' => $master_presentase->presentase_operasional]);

        #JENIS MOBIL
        $master_jenis_mobil = MasterJenisMobil::find($this->master_jenis_mobil_id);
        $this->merge(['jenis_mobil' => $master_jenis_mobil->name]);
    }

    protected function failedValidation(Validator $validator) {
        $errors = json_decode($validator->errors());
        $array = [];
        //format error validation message laravel to Wowrack RESTAPI format
        foreach($errors as $key => $item){
            foreach($item as $error){
                $array[] = [
                    'message' => $error,
                    'field' => $key,
                ];
            }
        }
        throw new HttpResponseException(response()->json([
            'code' => 500,
            'errors' => $array,
            'message' => 'Input validation error'
        ], 400));
    }
}
