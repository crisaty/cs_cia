<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';

    protected $fillable =
    ['nom_cliente','fec_ingreso','mail','telefono','estado','empresa_id_empresa'];

    public function empresa()
    {
      return $this->belongTo('App\Empresa');
    }

    public function producto()
    {
      return $this->hasMany('App\Producto');
    }

    protected $dates = ['deleted_at'];

}
