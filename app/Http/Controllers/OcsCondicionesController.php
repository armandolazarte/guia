<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\OcsCondicion;
use Illuminate\Http\Request;

class OcsCondicionesController extends Controller {

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$condiciones = OcsCondicion::find($id);

        return view('oc.formCondiciones', compact('condiciones'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $condiciones = OcsCondicion::findOrFail($id);
        $condiciones->update($request->all());

        return redirect()->action('OcsController@index', $condiciones->oc->req_id);
	}

}
