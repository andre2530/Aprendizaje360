<!DOCTYPE html>
<html>
<head>
    <title>Secciones</title>
</head>
<body>
    <h1>Registrar Sección</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('secciones.store') }}">
        @csrf
        <label for="nombre">Nombre de la sección:</label>
        <input type="text" name="nombre" required>
        <button type="submit">Guardar</button>
    </form>

    <h2>Secciones existentes</h2>
    <ul>
        @foreach($secciones as $seccion)
            <li>{{ $seccion->nombre }}</li>
        @endforeach
    </ul>
</body>
</html>
