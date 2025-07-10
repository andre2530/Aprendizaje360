<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Reporte del Docente: {{ $docente->name }}</h2>
    <p>Fecha de generación: {{ $fecha }}</p>

    <h3>Resumen General</h3>
    <ul>
        <li>Total de notas: {{ $totalNotas }}</li>
        @foreach($conteo as $valor => $total)
            <li>Notas {{ $valor }}: {{ $total }} ({{ $porcentajes[$valor] }}%)</li>
        @endforeach
    </ul>

    <h3>Detalle por estudiante</h3>
    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $estudiante)
                @foreach ($estudiante->notas as $nota)
                    <tr>
                        <td>{{ $estudiante->nombres_completos }}</td>
                        <td>{{ $nota->curso }}</td>
                        <td>{{ $nota->valor }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
