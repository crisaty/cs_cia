<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\Empresa;
use Carbon\Carbon;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $clientes = Cliente::join('empresa as e','cliente.empresa_id_empresa','=','e.id_empresa')
                    ->select('cliente.*','e.nom_empresa as empresa')
                    ->orderBy('id_cliente', 'desc')->get();

        return [
            'clientes' => $clientes
          ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        setlocale(LC_TIME, 'Chile/Continental');
        Carbon::setUtf8(true);

        if (!$request->ajax()) return redirect('/');
        $cliente = new Cliente();
        $cliente->nom_cliente = $request->nombre;
        $cliente->fec_ingreso = Carbon::parse($request->fechaIngreso)->toDateString();
        $cliente->mail = $request->mail;
        $cliente->telefono = $request->telefono;
        $cliente->empresa_id_empresa = $request->idEmpresa;
        $cliente->estado = '1';
        $cliente->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        setlocale(LC_TIME, 'Chile/Continental');
        Carbon::setUtf8(true);

        if (!$request->ajax()) return redirect('/');
        $cliente = Cliente::findOrFail($request->id);
        $cliente->nom_cliente = $request->nombre;
        $cliente->fec_ingreso = Carbon::parse($request->fechaIngreso)->toDateString();
        $cliente->mail = $request->mail;
        $cliente->telefono = $request->telefono;
        $cliente->empresa_id_empresa = $request->idEmpresa;
        $cliente->estado = '1';
        $cliente->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deactivate(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cliente = Cliente::findOrFail($request->id);
        $cliente->estado = '0';
        $cliente->save();
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cliente = Cliente::findOrFail($request->id);
        $cliente->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function activate(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cliente = Cliente::findOrFail($request->id);
        $cliente->estado = '1';
        $cliente->save();
    }

    public function selectEmpresa(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $empresas = Empresa::where('estado','=','1')
                    ->select('id_empresa','nom_empresa')
                    ->orderBy('nom_empresa','asc')->get();

        return ['empresas' => $empresas];
    }
}
