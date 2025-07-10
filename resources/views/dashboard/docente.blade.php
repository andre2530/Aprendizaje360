@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-8 px-6">
        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-3xl font-extrabold text-blue-800">Hola, {{ $user->name }}</h2>
                <p class="text-gray-600">Este es tu panel personal como docente.</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('filament.admin.pages.dashboard-docente') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow inline-flex items-center">
                    📊 Ver Dashboard
                </a>
                <a href="{{ route('docente.csv.form') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow inline-flex items-center">
                    📄 Subir nuevo CSV
                </a>
                <a href="{{ route('docente.reporte.pdf') }}"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded shadow inline-flex items-center">
                    📄 Descargar Reporte PDF
                </a>
            </div>
        </div>

        {{-- Tarjetas de estudiantes --}}
        <div class="bg-white p-4 rounded shadow border">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Estudiantes de tu grado y sección</h3>

            @if ($estudiantes->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($estudiantes as $estudiante)
                        <div class="bg-gray-50 p-4 rounded-lg border shadow-sm hover:shadow-md transition">
                            <h4 class="text-blue-800 font-bold text-lg mb-2">{{ $estudiante->nombres_completos }}</h4>

                            <div class="space-y-1">
                                @forelse ($estudiante->notas as $nota)
                                    <div class="flex justify-between text-sm">
                                        <span>{{ $nota->curso }}</span>
                                        <span
                                            class="font-semibold {{ $nota->valor >= 11 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $nota->valor }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 italic">Sin notas registradas</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-600 py-10">
                    <h4 class="text-lg font-semibold mb-2">Aún no tienes estudiantes asignados.</h4>
                    <p class="text-sm mb-4">Puedes comenzar subiendo un archivo CSV con tus estudiantes asignados.</p>

                    <a href="{{ route('docente.csv.form') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded shadow">
                        📄 Subir estudiantes
                    </a>
                </div>
            @endif
        </div>

        {{-- Gráfico interactivo --}}
        <div class="mt-8">
            @livewire('app.filament.widgets.notas-por-categoria-chart')
        </div>
    </div>
    <form method="POST" action="{{ route('docente.eliminar.estudiantes') }}"
        onsubmit="return confirm('¿Estás seguro de eliminar todos los estudiantes de tu grado y sección?')">
        @csrf
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">
            🗑️ Eliminar todos los estudiantes
        </button>
    </form>

@endsection
