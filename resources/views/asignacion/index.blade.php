<!DOCTYPE html>
<html>
<head>
    <title>Asignar Docente</title>
</head>
<body>
    <h1>Asignar Docente a Grado y Sección</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('asignar.store') }}">
        @csrf

        <label for="usuario_id">Docente:</label>
        <select name="usuario_id" required>
            <option value="">-- Selecciona un docente --</option>
            @foreach($docentes as $docente)
                <option value="{{ $docente->id }}">{{ $docente->name }} ({{ $docente->email }})</option>
            @endforeach
        </select>

        <label for="grado_id">Grado:</label>
        <select name="grado_id" required>
            <option value="">-- Selecciona un grado --</option>
            @foreach($grados as $grado)
                <option value="{{ $grado->id }}">{{ $grado->nombre }}</option>
            @endforeach
        </select>

        <label for="seccion_id">Sección:</label>
        <select name="seccion_id" required>
            <option value="">-- Selecciona una sección --</option>
            @foreach($secciones as $seccion)
                <option value="{{ $seccion->id }}">{{ $seccion->nombre }}</option>
            @endforeach
        </select>

        <button type="submit">Asignar</button>
    </form>
</body>
</html>
