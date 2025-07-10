<x-filament::page>
    {{-- Botones --}}
    <div class="flex justify-between mb-6">
        <x-filament::button tag="a" href="{{ route('docente.csv.form') }}" color="success">
            📤 Subir nuevo CSV
        </x-filament::button>
        <x-filament::button tag="a" href="{{ route('docente.reporte.pdf') }}" color="primary">
            🧾 Descargar Reporte PDF
        </x-filament::button>
    </div>

    {{-- Widgets --}}
    {{ $this->table }}

    {{-- Tabla de estudiantes con notas --}}
    <div class="mt-10">
        <h3 class="text-xl font-bold mb-4">Estudiantes y sus notas</h3>

        @forelse ($estudiantes as $estudiante)
            <div class="mb-4 p-4 border rounded bg-white shadow">
                <p class="font-semibold">{{ $estudiante->nombres_completos }}</p>
                <ul class="list-disc list-inside">
                    @foreach ($estudiante->notas as $nota)
                        <li>{{ $nota->curso }}: <strong>{{ $nota->valor }}</strong></li>
                    @endforeach
                </ul>
            </div>
        @empty
            <p class="text-gray-500">No hay estudiantes asignados.</p>
        @endforelse
    </div>
</x-filament::page>
