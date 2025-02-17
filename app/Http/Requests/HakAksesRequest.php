<?php

namespace App\Http\Requests;

use App\Rules\IgnoreHtmlTagRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class HakAksesRequest extends FormRequest
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
            'id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users')->ignore(request('id'))],
            'password' => [
                Rule::when(is_null(request('id')), 'required|min:5'),
            ],
            'confirm_password' => [
                Rule::when(is_null(request('id')), 'required|same:password'),
            ],
            'hak_akses' => ['array'],
            'hak_akses.*' => ['string'],
        ];
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
