@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 to-blue-400">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center text-blue-800 mb-6">Registro de Docente</h2>

            <form method="POST" action="{{ route('docente.registrar') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Nombre</label>
                    <input id="name" type="text" name="name" required
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email" required
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">Confirmar
                        contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition duration-200">
                    Registrarse
                </button>
            </form>

            <p class="text-sm text-center mt-6 text-gray-600">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-blue-700 hover:underline font-semibold">Iniciar sesión</a>
            </p>
        </div>
    </div>
@endsection
