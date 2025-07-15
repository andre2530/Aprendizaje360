@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-8 px-6">
        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-3xl font-extrabold text-blue-800">Hola, {{ $user->name }}</h2>
                <p class="text-gray-600">Este es tu panel personal como docente.</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Dashboard: Squares2x2 -->
                <a href="{{ route('filament.admin.pages.dashboard-docente') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow flex items-center justify-center"
                    title="Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
                    </svg>
                </a>
                <!-- Subir CSV: Arrow Up Tray -->
                <a href="{{ route('docente.csv.form') }}"
                    class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full shadow flex items-center justify-center"
                    title="Subir CSV">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                </a>
                <!-- Descargar PDF: Arrow Down Tray -->
                <a href="{{ route('docente.reporte.pdf') }}"
                    class="bg-gray-800 hover:bg-gray-900 text-white p-2 rounded-full shadow flex items-center justify-center"
                    title="Descargar PDF">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 10l-4 4m0 0L8 10m4 4V4" />
                    </svg>
                </a>
                <!-- Eliminar: Trash -->
                <form method="POST" action="{{ route('docente.eliminar.estudiantes') }}"
                    onsubmit="return confirm('¿Estás seguro de eliminar todos los estudiantes de tu grado y sección?')">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full shadow flex items-center justify-center"
                        title="Eliminar todos">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                        </svg>
                    </button>
                </form>
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


    @endsection