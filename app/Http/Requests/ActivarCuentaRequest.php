<?php namespace Guia\Http\Requests;

use Guia\Http\Requests\Request;

class ActivarCuentaRequest extends Request {

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
        $userId = \Auth::user()->id;

        return [
            'username' => 'required|numeric|min:7|unique:users,username,'.$userId,
            'password' => 'required|confirmed',
            'email' => 'required|email|unique:users,email,'.$userId,
            'nombre' => 'required',
            'prefijo' => 'max:5'
        ];
	}

}
