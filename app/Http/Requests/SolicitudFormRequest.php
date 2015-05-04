<?php namespace Guia\Http\Requests;

use Guia\Http\Requests\Request;

class SolicitudFormRequest extends Request {

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
        $accion = $this->input('accion');

        if(empty($accion)) {
            return [
                'tipo_solicitud' => 'required',
                'proyecto_id' => 'required|integer|not_in:0',
                'urg_id' => 'required|integer|not_in:0',
                'benef_id' => 'required|integer|not_in:0',
                'no_documento' => 'required',
                'concepto' => 'required'
            ];
        } else {
            return ['accion' => 'required'];
        }
	}

}
