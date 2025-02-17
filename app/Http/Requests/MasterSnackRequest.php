<?php

namespace App\Http\Requests;

use App\Rules\IgnoreHtmlTagRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\MoreThan;

class MasterSnackRequest extends FormRequest
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
            'id' => ['nullable', 'exists:master_snack,id'],
            'snack_name' => ['required'],
            'stock' => ['required', 'integer'],
            'harga_beli' => ['required', 'integer'],
            'harga_jual' => ['required', 'integer', new MoreThan('harga_beli')],
        ];
    }

    protected function passedValidation()
    {
        $this->merge(['keuntungan' => $this->harga_jual - $this->harga_beli]);
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
            'code' => 400,
            'errors' => $array,
            'message' => 'Input validation error'
        ], 400));
    }
}
