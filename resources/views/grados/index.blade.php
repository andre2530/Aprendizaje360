<!DOCTYPE html>
<html>
<head>
    <title>Grados</title>
</head>
<body>
    <h1>Registrar Grado</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('grados.store') }}">
        @csrf
        <label for="nombre">Nombre del grado:</label>
        <input type="text" name="nombre" required>
        <button type="submit">Guardar</button>
    </form>

    <h2>Grados existentes</h2>
    <ul>
        @foreach($grados as $grado)
            <li>{{ $grado->nombre }}</li>
        @endforeach
    </ul>
</body>
</html>
