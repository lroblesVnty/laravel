<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipoRequest extends FormRequest
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
            'nserie'=>'required|string|unique:equipos,nserie',
            'tipo'=>'required|string|in:PC,CEL',
            'marca'=>'required|string',
            'modelo'=>'required|string',
            'fechaCompra'=>'required|date',
            'costo'=>'required|numeric',
            'procesador'=>'required|string',
            'ram'=>'integer|required_if:tipo,PC',
            'hdd'=>'string|required_if:tipo,PC',
            'software'=>'required|string',
            'proveedor_id'=>'required|integer|exists:proveedors,id',
            'user_id'=>'required|integer|exists:users,id',
            //'user_id'=>'required|integer|exists:users,id|unique:equipos,user_id',
        ];
    }
}
