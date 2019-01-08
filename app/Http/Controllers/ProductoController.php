<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Producto;
use App\Cliente;
use Carbon\Carbon;

use App\Notifications\AlertExpProducto;

class ProductoController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      $criterio = $request->criterio;

      $productos = Producto::join('tipo_producto as tp','producto.tipo_producto_id_tipoproducto','=','tp.id_tipoproducto')
                    ->select('producto.*','tp.nom_tipoproducto as tipo')
                    ->orderBy('id_producto', 'desc')->get();

      if ($criterio) {
        $productos = Producto::join('tipo_producto as tp','producto.tipo_producto_id_tipoproducto','=','tp.id_tipoproducto')
                    ->select('producto.*','tp.nom_tipoproducto as tipo')
                    ->where('tp.nom_tipoproducto','like', $criterio)
                    ->orderBy('id_producto', 'desc')->get();
      }

      return [
        'productos' => $productos
      ];
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      $producto = new Producto();
      $producto->cliente_id_cliente = $request->idCliente;
      $producto->tipo_producto_id_tipoproducto = $request->idTipoProducto;
      $producto->nom_producto = $request->nombre;
      $producto->fecha_exp = Carbon::parse($request->fechaIngreso)->toDateString();
      $producto->precio_costo = $request->precioCosto;
      $producto->precio_venta = $request->precioVenta;
      $producto->info = $request->info;

      $producto->estado = '1';
      $producto->save();
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
      setlocale(LC_TIME, 'Chile/Continental');
      Carbon::setUtf8(true);
      //if (!$request->ajax()) return redirect('/');
      $producto = Producto::findOrFail($request->id);
      $producto->cliente_id_cliente = $request->idCliente;
      $producto->tipo_producto_id_tipoproducto = $request->idTipoProducto;
      $producto->nom_producto = $request->nombre;
      $producto->fecha_exp = Carbon::parse($request->fechaIngreso);
      $producto->precio_costo = $request->precioCosto;
      $producto->precio_venta = $request->precioVenta;
      $producto->info = $request->info;
      $producto->estado = '1';
      $producto->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function deactivate(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      $producto = Producto::findOrFail($request->id);
      $producto->estado = '0';
      $producto->save();
  }

  public function delete(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      $producto = Producto::findOrFail($request->id);
      $producto->delete();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function activate(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      $producto = Producto::findOrFail($request->id);
      $producto->estado = '1';
      $producto->save();
  }

  public function selectCliente(Request $request){
      //if (!$request->ajax()) return redirect('/');
      $clientes = Cliente::where('estado','=','1')
                  ->select('id_cliente','nom_cliente')
                  ->orderBy('nom_cliente','asc')->get();

      return ['clientes' => $clientes];
  }

  public function selectTipo(Request $request){
      //if (!$request->ajax()) return redirect('/');
      $tipos = DB::table('tipo_producto')
                  ->select('id_tipoproducto','nom_tipoproducto')
                  ->orderBy('nom_tipoproducto','asc')->get();

      return ['tipos_productos' => $tipos];
  }

  public function enviarAlertExp(Request $request)
  {
      if (!$request->ajax()) return redirect('/');

      $producto = Producto::findOrFail($request->id_producto);
      $cliente = Cliente::findOrFail($request->id_cliente);

      $user = new User();
      $user->email = $cliente->mail;
      $user->notify(new AlertExpProducto($cliente, $producto));

  }
}
