<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        @page {
            size: letter;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        body {
            background: #e9e5e5;
            color: #050505;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            margin: 0;
        }

        .toolbar {
            padding: 12px;
            text-align: center;
        }

        .toolbar button {
            background: #b8444d;
            border: 0;
            border-radius: 6px;
            color: #fff;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 16px;
        }

        .toolbar a {
            background: #b8444d;
            border-radius: 6px;
            color: #fff;
            display: inline-block;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 16px;
            text-decoration: none;
        }

        .sheet {
            background: #fff;
            border: 1px solid #c9c9c9;
            margin: 0 auto 20px;
            min-height: 279mm;
            overflow: hidden;
            padding: 15mm 14mm 38mm;
            position: relative;
            width: 216mm;
        }

        .watermark {
            left: 50%;
            opacity: 0.18;
            position: fixed;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 88mm;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .letterhead {
            display: grid;
            grid-template-columns: 50mm 1fr 50mm;
            min-height: 26mm;
        }

        .logo {
            opacity: 0.48;
            width: 43mm;
        }

        .lab-title {
            color: #676767;
            font-size: 10px;
            font-weight: 700;
            line-height: 1.45;
            padding-top: 3mm;
            text-align: center;
            text-transform: uppercase;
        }

        .patient-meta {
            display: grid;
            font-size: 10px;
            font-weight: 700;
            grid-template-columns: 1fr 1fr;
            line-height: 1.45;
            margin: 7mm 5mm 9mm;
        }

        .patient-meta .right {
            justify-self: end;
            min-width: 42mm;
        }

        .exam-group {
            margin: 0 0 14mm;
            page-break-inside: avoid;
        }

        .group-title {
            font-size: 14px;
            font-weight: 700;
            margin: 0 0 7mm;
            text-align: center;
            text-decoration: underline;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }

        thead {
            display: table-header-group;
        }

        th,
        td {
            border: 1px solid #111;
            padding: 5px 7px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            background: #fff;
            font-weight: 700;
        }

        td {
            background: #d1d1d1;
            min-height: 7mm;
        }

        td:first-child,
        td:nth-child(3) {
            font-weight: 700;
        }

        .result.abnormal {
            font-weight: 700;
            text-decoration: underline;
        }

        .empty-results {
            border: 1px solid #111;
            font-weight: 700;
            padding: 10mm;
            text-align: center;
        }

        .signature {
            margin-left: auto;
            margin-top: 6mm;
            text-align: center;
            width: 45mm;
        }

        .signature .doctor {
            font-weight: 700;
            margin-bottom: 2mm;
        }

        .stamp {
            padding: 2px;
            width: 32mm;
        }

        .footer {
            bottom: 11mm;
            left: 31mm;
            position: absolute;
            right: 31mm;
            text-align: center;
            z-index: 1;
        }

        .footer .red-line {
            background: #bd4a52;
            height: 1.2mm;
            margin-bottom: 2mm;
        }

        .footer .text {
            font-size: 8px;
            font-weight: 700;
            line-height: 1.35;
        }

        .footer .black-line {
            background: #111;
            height: 0.35mm;
            margin-top: 2mm;
        }

        @media print {
            body {
                background: #fff;
            }

            .toolbar {
                display: none;
            }

            .sheet {
                border: 0;
                margin: 0;
                min-height: 279mm;
                overflow: visible;
                padding: 10mm 14mm 34mm;
                width: 216mm;
            }

            .watermark {
                position: fixed;
            }

            .footer {
                bottom: 10mm;
                left: 31mm;
                position: fixed;
                right: 31mm;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a href="{{ route('resultados.pdf', $orden) }}" target="_blank" rel="noopener">Guardar PDF</a>
        <button type="button" onclick="window.print()">Imprimir desde navegador</button>
    </div>

    <main class="sheet">
        <img class="watermark" src="{{ $imagenes['watermark'] }}" alt="">

        <div class="content">
            <header class="letterhead">
                <div>
                    <img class="logo" src="{{ $imagenes['logo'] }}" alt="Laboratorio Shadai">
                </div>
                <div class="lab-title">
                    <div>Laboratorio de Analisis Clinico Shadai</div>
                    <div>Colonia Lomas del Norte Media Cuadra al Oeste de la Antigua</div>
                    <div>Gasolinera Dippsa B1 Casa #1</div>
                </div>
                <div></div>
            </header>

            <section class="patient-meta">
                <div>
                    <div>Paciente: {{ $orden->paciente?->nombre_completo ?: '-' }}</div>
                    <div>Sexo: {{ $orden->paciente?->sexo ?: '-' }}</div>
                    <div>Edad: {{ $edad !== null ? "{$edad} ANOS." : '-' }}</div>
                </div>
                <div class="right">
                    <div>Solicitado: {{ $orden->fecha_orden?->format('d/m/Y') ?: '-' }}</div>
                    <div>Impreso: {{ $impresoEn->format('d/m/Y') }}</div>
                </div>
            </section>

            @forelse ($examenesAgrupados as $grupo => $resultados)
                <section class="exam-group">
                    <h2 class="group-title">{{ $grupo }}</h2>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 32%">Prueba</th>
                                <th style="width: 37%">Valor de referencia</th>
                                <th style="width: 31%">Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultados as $resultado)
                                <tr>
                                    <td>{{ $resultado['prueba'] }}</td>
                                    <td>{{ $resultado['referencia'] }}</td>
                                    <td class="result {{ in_array($resultado['estado'], ['BAJO', 'ALTO', 'ANORMAL', 'POSITIVO'], true) ? 'abnormal' : '' }}">
                                        {{ $resultado['resultado'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            @empty
                <div class="empty-results">No hay resultados registrados para esta orden.</div>
            @endforelse

            <section class="signature">
                <div class="doctor">Dr. Yordy Gonzales</div>
                <img class="stamp" src="{{ $imagenes['stamp'] }}" alt="Sello del laboratorio">
            </section>
        </div>

        <footer class="footer">
            <div class="red-line"></div>
            <div class="text">
                <div>LABORATORIO DE ANALISIS CLINICO SHADAI</div>
                <div>Colonia Lomas del Norte, media cuadra al Oeste de la Antigua Gasolinera Dippsa</div>
                <div>B1 casa N. 91 Cel: 3168 6556</div>
                <div>Horario de Atencion: lunes a sabado de 7:00 A.M - 5:00 P.M</div>
            </div>
            <div class="black-line"></div>
        </footer>
    </main>
</body>
</html>
