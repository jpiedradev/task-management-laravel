<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuerteController extends Controller
{
   /* public function alAzar()
    {
        // Generar 5 números únicos del 1 al 80
        $numeros = range(1, 80);
        shuffle($numeros);
        $resultado = array_slice($numeros, 0, 5);
        sort($resultado);

        return view('Loteria.index', ['numeros' => $resultado]);
    }
   */

    public function alAzar()
    {
        return view('Loteria.index');
    }

    public function generar()
    {
        // Generar 5 números únicos del 1 al 80
        $numeros = range(1, 80);
        shuffle($numeros);
        $resultado = array_slice($numeros, 0, 5);
        sort($resultado);

        return response()->json(['numeros' => $resultado]);
    }
}
