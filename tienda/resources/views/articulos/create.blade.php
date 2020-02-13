@extends('plantillas.plantilla')
@section('titulo')
Nuevo Artículo
@endsection
@section('cabecera')
Guardar un Nuevo Artículo
@endsection
@section('contenido')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $miError)
            <li>{{$miError}}</li>
            @endforeach
        </ul>
    </div>
@endif
<form name="c" method='POST' action="{{route('articulos.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="form-row">
      <div class="col">
        <input type="text" class="form-control" placeholder="Nombre" name='nombre' required>
      </div>
    </div>
    <div class="form-row mt-3">
        <div class="col">
          <select name='categoria' class="form-control">
            <option selected>Bazar</option>
            <option>Hogar</option>
            <option>Electrónica</option>
        </select>
        </div>        
          <div class="col">
            <input type="number" class="form-control" placeholder="Precio(€)" name="precio" required step="0.50" min="0">
          </div>
          <div class="col">
            <input type="number" class="form-control" placeholder="Stock" name="klms" min="0">
          </div>
      </div>
      <div class="form-row mt-3">
        <div class="col">
            <b>Imagen</b>&nbsp;<input type='file' name='imagen' accept="image/*">
        </div>
      </div>
      <div class="form-row mt-3">
        <div class="col">
            <input type='submit' value='Guardar' class='btn btn-success mr-3'>
            <input type='reset' value='Limpiar' class='btn btn-warning mr-3'>
            <a href={{route('articulos.index')}} class='btn btn-info'>Volver</a>
        </div>
    </div>

  </form>
@endsection 