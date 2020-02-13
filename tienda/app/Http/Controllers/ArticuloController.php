<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categorias=['Bazar','Hogar','Electrónica'];
        $precios=['Menos de 10€',
        'De 10€ a 50€',
        'De 50€ a 100€',
        'Más de 100€'];

        $categoria=$request->get('categoria');
        $precio=$request->get('precio');

        $articulos=Articulo::orderBy('id')
        ->categoria($categoria)
        ->precio($precio)
        ->paginate(3);

        return view('articulos.index',compact('articulos','categorias','precios','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articulos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>['required'],
            'categoria'=>['required'],
            'precio'=>['required']
        ]);
        //compruebo si he subido archiivo
        if($request->has('imagen')){
            $request->validate([
                'imagen'=>['image']
            ]);
            //Todo bien hemos subido un archivo y es de imagen
            $file=$request->file('imagen');
            //Creo un nombre
            $nombre='articulos/'.time().'_'.$file->getClientOriginalName();
            //Guardo el archivo de imagen
            Storage::disk('public')->put($nombre, \File::get($file));
            //Guardo el articulo pero la imagen estaria mal
            $articulo=Articulo::create($request->all());
            //actualiza el registro imagen del articulo guardado
            $articulo->update(['imagen'=>"/img/$nombre"]);
        }
        else{
            Articulo::create($request->all());
        }
        return redirect()->route('articulos.index')->with('mensaje','Artículo guardado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(Articulo $articulo)
    {
        return view('articulos.show',compact('articulo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo)
    {
        $categorias=['Bazar','Hogar','Electrónica'];
        return view('articulos.edit',compact('articulo','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articulo $articulo)
    {
        $request->validate([
            'nombre'=>['required'],
            'categoria'=>['required'],
            'precio'=>['required']
        ]);
        //compruebo si he subido archiivo
        if($request->has('imagen')){
            $request->validate([
                'imagen'=>['image']
            ]);
            //Todo bien hemos subido un archivo y es de imagen
            $file=$request->file('imagen');
            //Creo un nombre
            $nombre='articulos/'.time().'_'.$file->getClientOriginalName();
            //Guardo el archivo de imagen
            Storage::disk('public')->put($nombre, \File::get($file));
            //si he subido una imagen nueva borro la vieja, SALVO que sea default.jpg
            if(basename($articulo->imagen)!='default.png'){
                unlink($articulo->imagen);
            }
            //ahora actualizo el articulo
            $articulo->update($request->all());
            $articulo->update(['imagen'=>"/img/$nombre"]);
        }
        else{
            $articulo->update($request->all());
        }
        return redirect()->route('articulos.index')->with('mensaje','Artículo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        //Dos cosas borrar la imagen si no es default.jpg
        //y borrar registro
        $imagen=$articulo->imagen;
        if(basename($imagen)!='default.png'){
            //la borro NO es default.png
            unlink(public_path().$imagen);
        }
        //en cualquier caso borro el registro
        $articulo->delete();
        return redirect()->route('articulos.index')->with('mensaje','Artículo borrado satisfactoriamente');
    }
}
