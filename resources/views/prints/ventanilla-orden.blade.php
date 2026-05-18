<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Orden de examenes</title>
    <style>
        @page {
            size: A4;
            margin: 18mm;
        }

        body {
            color: #111827;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        header {
            border-bottom: 1px solid #111827;
            margin-bottom: 18px;
            padding-bottom: 12px;
        }

        h1 {
            font-size: 18px;
            margin: 0 0 4px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        .meta {
            display: grid;
            gap: 6px;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 18px;
        }

        .print-button {
            margin-bottom: 16px;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">Imprimir</button>

    <header>
        <h1>Laboratorio Shadai</h1>
        <div>Orden de examenes</div>
    </header>

    <section class="meta">
        <div><strong>Cliente:</strong> {{ $orden->paciente?->nombre_completo }}</div>
        <div><strong>Documento:</strong> {{ $orden->paciente?->docid ?: '-' }}</div>
        <div><strong>Fecha:</strong> {{ $orden->fecha_recepcion?->format('d/m/Y H:i') }}</div>
        <div><strong>Registrado por:</strong> {{ $orden->usuario?->usuario ?: '-' }}</div>
    </section>

    <table>
        <thead>
            <tr>
                <th>Examen</th>
                <th>Muestra</th>
                <th>Ayuno</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orden->ordenLaboratorio?->examenesOrdenados ?? [] as $examenOrdenado)
                <tr>
                    <td>{{ $examenOrdenado->nombre_examen_snapshot ?: $examenOrdenado->examen?->nombre }}</td>
                    <td>{{ $examenOrdenado->tipo_muestra_snapshot ?: '-' }}</td>
                    <td>{{ $examenOrdenado->requiere_ayuno_snapshot ? 'Si' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($orden->observacion)
        <p><strong>Observaciones:</strong> {{ $orden->observacion }}</p>
    @endif
</body>
</html>
