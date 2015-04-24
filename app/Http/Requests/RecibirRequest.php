<?php namespace Guia\Http\Requests;

use Guia\Http\Requests\Request;

class RecibirRequest extends Request {

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
        if($this->input('tipo_doc') == 'sol'){
            return [
                'arr_sol_id' => 'required',
                'tipo_doc' => 'required'
            ];
        }

        if($this->input('tipo_doc') == 'req'){
            return [
                'arr_req_id' => 'required',
                'tipo_doc' => 'required'
            ];
        }
    }

}
