<?php namespace Guia\Http\Requests;

use Guia\Http\Requests\Request;

class InvitacionRequest extends Request {

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
			'benef_id' => 'required|integer|not_in:0',
            'fecha_invitacion' => 'required|date',
            'req_id' => 'required|integer|not_in:0'
		];
	}

}
