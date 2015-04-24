<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\Cotizacion;
use Guia\Models\Benef;
use Illuminate\Http\Request;

class InvitacionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($req_id)
	{
		$cotizaciones = Cotizacion::whereReqId($req_id)->get();
        return view('invita.indexInvita', compact('cotizaciones', 'req_id'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($req_id)
	{
        $benefs = Benef::all(array('id','benef'));
        foreach($benefs as $benef){
            $arr_benefs[$benef->id] = $benef->benef;
        }

		return view('invita.formInvita')
            ->with('benefs', $arr_benefs)
            ->with('req_id', $req_id);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
