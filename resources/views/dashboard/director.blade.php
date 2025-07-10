@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold text-blue-800 mb-4">Panel del Director</h1>

        {{-- Filtros --}}
        <form method="GET" action="{{ route('director.panel') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <select name="grado" class="border rounded px-3 py-2">
                <option value="">-- Grado --</option>
                @foreach ($grados as $grado)
                    <option value="{{ $grado->id }}" {{ request('grado') == $grado->id ? 'selected' : '' }}>
                        {{ $grado->nombre }}
                    </option>
                @endforeach
            </select>

            <select name="seccion" class="border rounded px-3 py-2">
                <option value="">-- Sección --</option>
                @foreach ($secciones as $seccion)
                    <option value="{{ $seccion->id }}" {{ request('seccion') == $seccion->id ? 'selected' : '' }}>
                        {{ $seccion->nombre }}
                    </option>
                @endforeach
            </select>

            <select name="docente" class="border rounded px-3 py-2">
                <option value="">-- Docente --</option>
                @foreach ($docentes as $docente)
                    <option value="{{ $docente->id }}" {{ request('docente') == $docente->id ? 'selected' : '' }}>
                        {{ $docente->name }}
                    </option>
                @endforeach
            </select>

            <select name="anio" class="border rounded px-3 py-2">
                <option value="">-- Año --</option>
                @for ($year = now()->year; $year >= 2017; $year--)
                    <option value="{{ $year }}" {{ request('anio') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endfor
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded col-span-full hover:bg-blue-700">
                Aplicar Filtros
            </button>
        </form>

        {{-- Tabla --}}
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-2">Lista de Estudiantes</h2>
            <table class="w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-2 py-1">Estudiante</th>
                        <th class="border px-2 py-1">Grado</th>
                        <th class="border px-2 py-1">Sección</th>
                        <th class="border px-2 py-1">Docente</th>
                        <th class="border px-2 py-1">Notas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estudiantes as $estudiante)
                        <tr>
                            <td class="border px-2 py-1">{{ $estudiante->nombres_completos }}</td>
                            <td class="border px-2 py-1">{{ $estudiante->grado->nombre ?? '-' }}</td>
                            <td class="border px-2 py-1">{{ $estudiante->seccion->nombre ?? '-' }}</td>
                            <td class="border px-2 py-1">{{ $estudiante->docente->name ?? '-' }}</td>
                            <td class="border px-2 py-1">
                                @foreach ($estudiante->notas as $nota)
                                    <div>{{ $nota->curso }}: <strong>{{ $nota->valor }}</strong></div>
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center border px-2 py-2 text-gray-500">No hay datos disponibles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
