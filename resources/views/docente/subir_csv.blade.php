@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">
    <h2 class="text-2xl font-bold text-blue-700 mb-4">Subir archivo CSV - Estudiantes</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('docente.estudiantes') }}"
   class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
   Ver estudiantes subidos
</a>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('docente.subir.csv') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Archivo CSV:</label>
            <input type="file" name="archivo_csv" accept=".csv" required
                class="border border-gray-300 px-3 py-2 rounded w-full">
        </div>

        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full transition">
            Subir y procesar
        </button>
    </form>
</div>
@endsection
