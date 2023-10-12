<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMiembroRequest extends FormRequest
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
            'nombre'=>'required|string|max:150|min:3|regex:/^[a-zA-ZÁ-ÿ\s]+$/',
            'tel'=>'required|integer|digits:10|unique:miembros,tel',
            'edad'=>'required|integer|max:100|gte:11',
            //'user_id'=>'required|integer|exists:users,id|unique:equipos,user_id',
        ];
    }

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.regex' => 'El campo nombre solo debe contener letras',//message solo para un campo
            //'min' => 'El valor del campo :attribute debe ser mínimo de :min',
        ];
    }
}
