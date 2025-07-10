<?php

namespace App\Http\Controllers;
use App\Models\Grado;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    public function index()
{
    $grados = Grado::all();
    return view('grados.index', compact('grados'));
}

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
    ]);

    Grado::create(['nombre' => $request->nombre]);

    return redirect()->route('grados.index')->with('success', 'Grado creado.');
}
}
