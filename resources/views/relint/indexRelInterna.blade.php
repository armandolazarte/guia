@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('relint.modalFormRelInt')

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#formRelIntModal">Crear Nueva Relación</button>


        </div>
    </div>
@stop
