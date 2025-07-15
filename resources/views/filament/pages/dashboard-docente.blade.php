<x-filament::page>
    <style>
        .tooltip-group { position: relative; display: inline-block; }
        .tooltip-text {
            visibility: hidden;
            opacity: 0;
            width: max-content;
            background-color: #222;
            color: #fff;
            text-align: center;
            border-radius: 0.375rem;
            padding: 0.25rem 0.75rem;
            position: absolute;
            z-index: 20;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.875rem;
            transition: opacity 0.2s;
            pointer-events: none;
            white-space: nowrap;
        }
        .tooltip-group:hover .tooltip-text,
        .tooltip-group:focus-within .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>

    <div class="max-w-7xl mx-auto w-full space-y-20">
        {{-- Sección 1: Botones y tabla --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-4 mb-2">
                <span class="tooltip-group">
                    <a href="{{ route('docente.csv.form') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-green-500 text-green-700 bg-white hover:bg-green-50 transition font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-green-200"
                       title="Subir un archivo CSV de estudiantes">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">Subir CSV</span>
                    </a>
                    <span class="tooltip-text">Subir un archivo CSV de estudiantes</span>
                </span>
                <span class="tooltip-group">
                    <a href="{{ route('docente.reporte.pdf') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-blue-500 text-blue-700 bg-white hover:bg-blue-50 transition font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                       title="Descargar reporte en PDF">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-8m0 8l-4-4m4 4l4-4" />
                            <rect x="6" y="4" width="12" height="16" rx="2" />
                        </svg>
                        <span class="hidden sm:inline">Descargar PDF</span>
                    </a>
                    <span class="tooltip-text">Descargar reporte en PDF</span>
                </span>
            </div>
            <div>
                {{ $this->table }}
            </div>
        </section>

        
        <div aria-hidden="true" class="my-32">
            <div class="w-full max-w-5xl mx-auto h-8"></div>
        </div>

        {{-- Sección 2: Notas de estudiantes --}}
        <section class="bg-gray-50 rounded-xl border space-y-14 border-gray-200 p-6 mt-20">
            <div x-data="{
            showAll: false,
            estudiantes: {{ json_encode($estudiantes) }},
            displayCount: 3,
            currentIndex: 0,
            get displayedEstudiantes() {
                if (!this.showAll) {
                return this.estudiantes.slice(0, this.displayCount);
                }
                return this.estudiantes.slice(this.currentIndex, this.currentIndex + this.displayCount);
            },
            next() {
                if (this.currentIndex + this.displayCount < this.estudiantes.length) {
                this.currentIndex += this.displayCount;
                }
            },
            prev() {
                if (this.currentIndex > 0) {
                this.currentIndex -= this.displayCount;
                }
            },
            get canNext() {
                return this.showAll && this.currentIndex + this.displayCount < this.estudiantes.length;
            },
            get canPrev() {
                return this.showAll && this.currentIndex > 0;
            }
            }" class="space-y-6">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-xl font-bold text-gray-900">Notas de los Estudiantes</h3>
                <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">
                {{ $estudiantes->count() }} estudiantes
                </span>
            </div>

            <div class="relative w-full">
                <button x-show="canPrev" @click="prev"
                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 bg-white rounded-full p-2 shadow-lg text-blue-600 hover:text-blue-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                </button>

                <div class="flex w-full max-w-full justify-center items-stretch gap-6 min-h-[220px]">
                <template x-for="(estudiante, idx) in displayedEstudiantes" :key="estudiante.id">
                    <div class="flex-1 min-w-0 bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 flex flex-col justify-between mx-auto">
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                        <div class="bg-blue-100 text-blue-700 p-2 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900" x-text="estudiante.nombres_completos"></h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                        <template x-for="nota in estudiante.notas" :key="nota.id">
                            <div class="flex justify-between items-center py-1">
                            <span class="text-gray-600" x-text="nota.curso"></span>
                            <span class="px-3 py-1 text-sm rounded-full font-medium"
                                :class="{
                                'bg-green-100 text-green-700': nota.valor >= 15,
                                'bg-yellow-100 text-yellow-700': nota.valor >= 11 && nota.valor < 15,
                                'bg-red-100 text-red-700': nota.valor < 11
                                }" x-text="nota.valor"></span>
                            </div>
                        </template>
                        </div>
                    </div>
                    </div>
                </template>
                <template x-if="displayedEstudiantes.length < 3">
                    <template x-for="i in (3 - displayedEstudiantes.length)"><div class="flex-1 min-w-0"></div></template>
                </template>
                </div>

                <button x-show="canNext" @click="next"
                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 bg-white rounded-full p-2 shadow-lg text-blue-600 hover:text-blue-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                </button>
            </div>

            <div class="flex justify-center pt-4">
                <button @click="showAll = !showAll; currentIndex = 0"
                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-black bg-white hover:bg-gray-100 border border-gray-300">
                <span x-text="!showAll ? 'Ver todos los estudiantes' : 'Ver solo los primeros 3'"></span>
                </button>
            </div>
            </div>
        </section>
    </div>
</x-filament::page>