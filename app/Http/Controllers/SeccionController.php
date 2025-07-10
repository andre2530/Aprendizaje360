<?php

namespace App\Http\Controllers;
use App\Models\Seccion;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
   public function index()
{
    $secciones = Seccion::all();
    return view('secciones.index', compact('secciones'));
}

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
    ]);

    Seccion::create(['nombre' => $request->nombre]);

    return redirect()->route('secciones.index')->with('success', 'Sección creada.');
}
}
