<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Empresa;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

          $empresas = Empresa::select('*')
                    ->orderBy('id_empresa', 'desc')->get();

        return [
          'empresas' => $empresas
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = new Empresa();
        $empresa->nom_empresa = $request->nombre;
        $empresa->rep_empresa = $request->representante;
        $empresa->estado = '1';
        $empresa->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id);
        $empresa->nom_empresa = $request->nombre;
        $empresa->rep_empresa = $request->representante;
        $empresa->estado = '1';
        $empresa->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deactivate(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id);
        $empresa->estado = '0';
        $empresa->save();
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id);
        $empresa->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function activate(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id);
        $empresa->estado = '1';
        $empresa->save();
    }
}
