<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductoRequest extends FormRequest
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
            'descripcion'=>'required|unique:productos,descripcion',
            'precio'=>'required|numeric',
            'stock'=>'required|numeric|min:1'
        ];
    }
    protected function failedValidation(Validator $validator){//personalizar responseException
        throw new HttpResponseException(
            response(['success' => false,'msg'=>'los datos proporcionados no son válidos', 'error_list' => $validator->errors()],422)
        );
        
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'stock.min' => 'El valor del campo stock debe ser mínimo de :min',//message solo para un campo
            'min' => 'El valor del campo :attribute debe ser mínimo de :min',
        ];
    }
}
