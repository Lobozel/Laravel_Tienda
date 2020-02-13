<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable=["nombre", "categoria", "precio", "stock", "imagen"];

    public function scopeCategoria($query, $v){
        return $query->where('categoria','like',"%$v%");
    }

    public function scopePrecio($query, $v){
        switch($v){
            case 0:
                return $query->where('precio','>',0);
            break;
                    case 1:
                        return $query->where('precio','<',10);
                    break;
                    case 2:
                        return $query->where('precio','>',10)
                        ->where('precio','<',50);
                    break;
                    case 3:
                        return $query->where('precio','>',50)
                        ->where('precio','<',100);
                    break;
                    case 4:
                        return $query->where('precio','>',100);
                    break;
                }
    }
}
