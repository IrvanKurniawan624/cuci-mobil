<?php

namespace App\Http\Requests;

use App\Models\MasterSnack;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TransaksiSnackRequest extends FormRequest
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
            'snack' => ['required','array'],
            'snack.*.master_snack_id' => ['required','exists:master_snack,id'],
            'snack.*.quantity' => ['required'],
            'snack.*.total_harga' => ['required'], //* harga_jual * quantity
            'total_harga' => ['required', 'integer'],
            'payment' => ['required', 'in:qris,tunai']
        ];
    }

    protected function passedValidation()
    {
        $array = [];
        $total_keuntungan = 0;
        
        foreach($this->snack as $item){
            $master_snack = MasterSnack::find($item['master_snack_id']);
            
            //! CHECK STOCK SNACK
            if($item['quantity'] > $master_snack->stock){
                throw new HttpResponseException(response()->json([
                    'code' => 400,
                    'message' => "Stock snack " . $master_snack->snack_name . " tersisa " . $master_snack->stock . " PCS",
                ], 400));
            }

            $total_keuntungan += $master_snack->keuntungan * $item['quantity'];
            
            $array['snack'][] = [
                'master_snack' => $master_snack,
                'quantity' => $item['quantity'],
                'total_harga' => $item['total_harga'],
                'keuntungan' => $master_snack->keuntungan * $item['quantity'],
            ];

            $master_snack->stock = $master_snack->stock - $item['quantity'];
            $master_snack->save();
        }
        
        $array['total_harga'] = $this->total_harga;
        $array['total_keuntungan'] = $total_keuntungan;

        $this->merge(['layanan_jasa' => 'Snack']);
        $this->merge(['information_snack' => json_encode($array)]);
        unset($this->snack);

        //? total harga dirubah keuntungan karena di table transaksi yang dihitung hanya keuntungan saja
        $this->merge(['total_harga' => $total_keuntungan]);

        //? untuk snack keuntungan 100% masuk kas
        $this->merge(['presentase_kas' => 100]);
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
