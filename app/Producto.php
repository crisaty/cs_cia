<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $table = 'producto';

    protected $primaryKey = 'id_producto';

    protected $fillable =
    ['nom_producto','precio_costo','precio_venta','fecha_exp','estado'
    ,'tipo_producto_id_tipoproducto','cliente_id_cliente'];

    protected $dates = ['deleted_at'];

}
