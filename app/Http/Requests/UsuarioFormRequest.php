<?php namespace Guia\Http\Requests;

use Guia\Http\Requests\Request;

class UsuarioFormRequest extends Request {

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
		$userId = $this->route('usuario');

		//Rules for Create
		if(empty($userId)) {
			$rules_1 = [
				'username' => 'required|numeric|min:7|unique:users',
				'password' => 'required|confirmed|min:4',
				'email' => 'required|email|unique:users'
			];
		//Rules for Edit
		} else {
			$rules_1 = [
				'username' => 'required|numeric|min:7|unique:users,username,'.$userId,
				'password' => 'confirmed',
				'email' => 'required|email|unique:users,email,'.$userId
			];
		}

		$rules_2 = [
			'nombre' => 'required',
			'prefijo' => 'max:50',
			'iniciales' => 'alpha|max:5'
		];

		$rules = array_merge($rules_1, $rules_2);
		return $rules;
	}

}
