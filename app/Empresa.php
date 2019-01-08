<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $table = 'empresa';

    protected $primaryKey = 'id_empresa';

    protected $fillable = ['nom_empresa','rep_empresa'];

    public function clientes()
    {
      return $this->hasMany('App\Cliente');
    }

    protected $dates = ['deleted_at'];

}
