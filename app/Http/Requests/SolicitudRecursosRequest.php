<?php namespace Guia\Http\Requests;

use Guia\Http\Requests\Request;

class SolicitudRecursosRequest extends Request {

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
        if ($this->input('tipo_solicitud') == 'Vale') {
            $rules = ['objetivo_id' => 'required|numeric'];
        } else {
            $rules = ['rm_id' => 'required|numeric'];
        }

        $rules = array_merge($rules, [
            'solicitud_id' => 'required|numeric',
            'tipo_solicitud' => 'required',
            'monto' => 'required|numeric'
        ]);
        return $rules;
	}

}
