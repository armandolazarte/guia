<?php

namespace Guia\Http\Requests;

use Guia\Http\Requests\Request;

class EgresoFormRequest extends Request
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
            'fecha' => 'required|date',
            'cuenta_id' => 'sometimes|required|integer|not_in:0,27',
            'cuenta_bancaria_id' => 'required|integer|not_in:0',
            'benef_id' => 'required|integer|not_in:0',
            'cheque' => 'required_without:transferencia|integer|min:1',
            'concepto' => 'required',
            'monto' => 'required|numeric|not_in:0'
        ];
    }
}
