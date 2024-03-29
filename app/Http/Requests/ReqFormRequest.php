<?php namespace Guia\Http\Requests;

use Guia\Http\Requests\Request;

class ReqFormRequest extends Request {

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

        if(empty($accion)){
            return [
                'urg_id' => 'required|integer|not_in:0',
                'proyecto_id' => 'required|integer|not_in:0',
                'etiqueta' => 'required',
                'lugar_entrega' => 'required'
            ];
        } else {
            return ['accion' => 'required'];
        }
	}

}
