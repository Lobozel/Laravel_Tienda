@extends('plantillas.plantilla')
@section('titulo')
    Detalle Artículo {{$articulo->nombre}}
@endsection
@section('cabecera')
    <i>{{$articulo->categoria."/"}}<b>{{($articulo->nombre)}}</b></i>
@endsection
@section('contenido')
    <span class="clearfix"></span>
    <div class="card text-white bg-info mt-5 mx-auto" style="max-width: 48rem;">
        <div class="card-header text-center"><b>{{($articulo->nombre)}}</b></div>
        <div class="card-body" style="font-size: 1.1em">
            <p class="card-text">
            <div class="float-right"><img src="{{asset($articulo->imagen)}}" width="160px" heght="160px" class="rounded-circle"></div>
            <p><b>Categoria:</b> {{$articulo->categoria}}</p>
            <p><b>Precio (€):</b> {{$articulo->precio}}</p>
            <p><b>Stock: </b>{{$articulo->stock." unidades"}}</p>
            </p>
            <a href="{{route('articulos.index')}}" class="float-left btn btn-success">Volver</a>
        </div>
    </div>



@endsection