@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: url('/images/PXL_20250513_085216126.MP.jpg');">
        <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-center mb-6">
                <img src="/images/Logoie.svg" alt="Logo Institución" class="h-16">
            </div>
            <h2 class="text-2xl font-bold text-center text-blue-800 mb-6">Registro de Docente</h2>

            <form method="POST" action="{{ route('docente.registrar') }}">
                @csrf

                <div class="mb-4">
                    <input id="name" type="text" name="name" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="Nombre">
                </div>

                <div class="mb-4">
                    <input id="email" type="email" name="email" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="Correo electrónico">
                </div>

                <div class="mb-4">
                    <input id="password" type="password" name="password" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="Contraseña">
                </div>

                <div class="mb-4">
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="Confirmar contraseña">
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
