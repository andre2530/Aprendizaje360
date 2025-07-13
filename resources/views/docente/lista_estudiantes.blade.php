@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-md">
    <h2 class="text-2xl font-bold text-blue-700 mb-4">Lista de estudiantes subidos</h2>
<div class="mt-6">
        <a href="{{ route('dashboard') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Volver al Dashboard
        </a>
    </div>
    
    @if($estudiantes->isEmpty())
        <p class="text-gray-600">No hay estudiantes registrados aún.</p>

        
    @else
        <table class="w-full table-auto border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Nombre</th>
                    <th class="border px-4 py-2 text-left">Sexo</th>
                    <th class="border px-4 py-2 text-left">Grado</th>
                    <th class="border px-4 py-2 text-left">Sección</th>
                    <th class="border px-4 py-2 text-left">Notas</th>
                    <th class="border px-4 py-2 text-left">Año</th> <!-- Nueva columna -->
                </tr>
            </thead>
            <tbody>
                @foreach($estudiantes as $estudiante)
                    <tr>
                        <td class="border px-4 py-2">{{ $estudiante->nombres_completos }}</td>
                        <td class="border px-4 py-2">{{ $estudiante->sexo }}</td>
                        <td class="border px-4 py-2">{{ $estudiante->grado->nombre ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $estudiante->seccion->nombre ?? '-' }}</td>
                        <td class="border px-4 py-2">
                            @foreach ($estudiante->notas as $nota)
                                <div>{{ ucfirst($nota->curso) }}: <strong>{{ $nota->valor }}</strong></div>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">
                            {{ $estudiante->notas->pluck('anio')->unique()->implode(', ') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    
</div>
@endsection
