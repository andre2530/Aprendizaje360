@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 to-blue-400">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center text-blue-800 mb-6">APRENDIZAJE 360</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email" required autofocus
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <div class="flex justify-between items-center mb-4">
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">¿Olvidaste tu
                            contraseña?</a>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition duration-200">
                    Ingresar
                </button>
            </form>

            <p class="text-sm text-center mt-6 text-gray-600">
                ¿No tienes cuenta?
                <a href="{{ route('docente.registro.form') }}"
                    class="text-blue-700 hover:underline font-semibold">Registrarse</a>
            </p>
        </div>
    </div>
@endsection
