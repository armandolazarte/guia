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
		return [
			'tipo_solicitud' => 'required',
			'proyecto_id' => 'required|numeric',
			'urg_id' => 'required|numeric',
			'benef_id' => 'required|numeric',
			'no_documento' => 'required',
			'concepto' => 'required'
		];
	}

}
