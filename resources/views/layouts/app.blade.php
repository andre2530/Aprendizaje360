<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Educativo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a class="text-lg font-bold text-blue-700 hover:underline">
                Panel de Gestión
            </a>
                <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
        Cerrar sesión
    </button>
</form>
            </form>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
