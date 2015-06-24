<?php namespace Guia\Http\Requests;

use Guia\Http\Requests\Request;

class SalidaRequest extends Request {

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
            'entrada_id' => 'required|integer|not_in:0',
            'urg_id' => 'required|integer|not_in:0',
            'cmt' => 'required',
            'arr_articulo_id' => 'required'
		];
	}

}
