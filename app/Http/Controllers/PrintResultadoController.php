<?php

namespace App\Http\Controllers;

use App\Models\OrdenExamen;
use App\Models\OrdenLaboratorio;
use App\Models\ResultadoExamen;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use RuntimeException;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\PdfBuilder;

use function Spatie\LaravelPdf\Support\pdf;

class PrintResultadoController extends Controller
{
    public function __invoke(OrdenLaboratorio $ordenLaboratorio): View
    {
        $impresoEn = $this->registrarImpresion($ordenLaboratorio);

        return view('prints.resultados-examen', $this->datosVista($ordenLaboratorio, $impresoEn));
    }

    public function pdf(OrdenLaboratorio $ordenLaboratorio): PdfBuilder
    {
        $impresoEn = $this->registrarImpresion($ordenLaboratorio);

        return pdf('prints.resultados-examen', $this->datosVista($ordenLaboratorio, $impresoEn))
            ->format(Format::Letter)
            ->margins(top: 0, right: 0, bottom: 0, left: 0)
            ->name("resultados-orden-{$ordenLaboratorio->id}.pdf")
            ->withBrowsershot(fn (Browsershot $browsershot): Browsershot => $browsershot
                ->emulateMedia('print')
                ->setOption('waitUntil', 'domcontentloaded')
                ->timeout(60));
    }

    /**
     * @return array{
     *     orden: OrdenLaboratorio,
     *     examenesAgrupados: Collection<string, Collection<int, array{
     *         grupo: string,
     *         grupo_orden: int,
     *         prueba: string,
     *         resultado: string,
     *         referencia: string,
     *         estado: string|null
     *     }>>,
     *     edad: int|null,
     *     impresoEn: Carbon,
     *     imagenes: array{watermark: string, logo: string, stamp: string}
     * }
     */
    private function datosVista(OrdenLaboratorio $ordenLaboratorio, Carbon $impresoEn): array
    {
        $ordenLaboratorio->load([
            'paciente',
            'usuario',
            'examenesOrdenados.examen.grupo',
            'examenesOrdenados.resultados.variante',
        ]);

        return [
            'orden' => $ordenLaboratorio,
            'examenesAgrupados' => $this->resultadosAgrupados($ordenLaboratorio),
            'edad' => $this->edad($ordenLaboratorio->paciente?->fecha_nacimiento),
            'impresoEn' => $impresoEn,
            'imagenes' => [
                'watermark' => $this->imagenDataUri(public_path('images/microscope_icon.svg')),
                'logo' => $this->imagenDataUri(public_path('images/laboratorio_shadai.svg')),
                'stamp' => $this->imagenDataUri(public_path('images/sello.png')),
            ],
        ];
    }

    private function registrarImpresion(OrdenLaboratorio $ordenLaboratorio): Carbon
    {
        $impresoEn = now();

        $ordenLaboratorio->forceFill([
            'resultado_impreso' => true,
            'fecha_resultado_impreso' => $impresoEn,
            'cantidad_impresiones_resultado' => ((int) $ordenLaboratorio->cantidad_impresiones_resultado) + 1,
        ])->save();

        return $impresoEn;
    }

    private function imagenDataUri(string $path): string
    {
        $content = file_get_contents($path);

        if ($content === false) {
            throw new RuntimeException("No se pudo cargar la imagen para el PDF: {$path}");
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($content) ?: 'image/png';

        return 'data:'.$mime.';base64,'.base64_encode($content);
    }

    /**
     * @return Collection<string, Collection<int, array{
     *     grupo: string,
     *     grupo_orden: int,
     *     prueba: string,
     *     resultado: string,
     *     referencia: string,
     *     estado: string|null
     * }>
     */
    private function resultadosAgrupados(OrdenLaboratorio $ordenLaboratorio): Collection
    {
        return $ordenLaboratorio->examenesOrdenados
            ->flatMap(fn (OrdenExamen $ordenExamen): Collection => $ordenExamen->resultados
                ->sortBy(fn (ResultadoExamen $resultado): string => $this->resultadoSortKey($ordenExamen, $resultado))
                ->map(fn (ResultadoExamen $resultado): array => [
                    'grupo' => $ordenExamen->examen?->grupo?->nombre ?: 'Sin grupo',
                    'grupo_orden' => $ordenExamen->examen?->grupo?->orden ?? PHP_INT_MAX,
                    'prueba' => $resultado->variante_nombre_snapshot ?: ($resultado->variante?->nombre ?: 'Sin nombre'),
                    'resultado' => $this->resultadoLabel($resultado),
                    'referencia' => $this->referenciaConNivelLabel($resultado),
                    'estado' => $resultado->estado_resultado,
                ]))
            ->sortBy(fn (array $resultado): string => sprintf(
                '%08d-%s-%s',
                $resultado['grupo_orden'],
                $resultado['grupo'],
                $resultado['prueba'],
            ))
            ->groupBy('grupo');
    }

    private function resultadoSortKey(OrdenExamen $ordenExamen, ResultadoExamen $resultado): string
    {
        return sprintf(
            '%08d-%08d-%08d-%08d',
            $ordenExamen->examen?->grupo?->orden ?? PHP_INT_MAX,
            $ordenExamen->examen?->orden ?? PHP_INT_MAX,
            $resultado->variante?->orden ?? PHP_INT_MAX,
            $resultado->id,
        );
    }

    private function resultadoLabel(ResultadoExamen $resultado): string
    {
        $unidad = $resultado->unidad ? " {$resultado->unidad}" : '';

        if ($resultado->resultado_numero !== null) {
            return $this->decimal((float) $resultado->resultado_numero, $resultado) . $unidad;
        }

        if (filled($resultado->resultado_texto)) {
            return $resultado->resultado_texto . $unidad;
        }

        return '-';
    }

    private function referenciaLabel(ResultadoExamen $resultado): string
    {
        $unidad = $resultado->ref_unidad ? " {$resultado->ref_unidad}" : ($resultado->unidad ? " {$resultado->unidad}" : '');

        if (filled($resultado->ref_valor_texto)) {
            return $resultado->ref_valor_texto . $unidad;
        }

        $min = $resultado->ref_valor_min;
        $max = $resultado->ref_valor_max;

        return match ($resultado->ref_operador) {
            'RANGO' => filled($min) && filled($max)
                ? $this->decimal((float) $min, $resultado) . ' - ' . $this->decimal((float) $max, $resultado) . $unidad
                : 'Sin referencia',
            'MENOR_QUE' => filled($max) ? '< ' . $this->decimal((float) $max, $resultado) . $unidad : 'Sin referencia',
            'MENOR_IGUAL' => filled($max) ? '<= ' . $this->decimal((float) $max, $resultado) . $unidad : 'Sin referencia',
            'MAYOR_QUE' => filled($min) ? '> ' . $this->decimal((float) $min, $resultado) . $unidad : 'Sin referencia',
            'MAYOR_IGUAL' => filled($min) ? '>= ' . $this->decimal((float) $min, $resultado) . $unidad : 'Sin referencia',
            'IGUAL' => filled($min) ? '= ' . $this->decimal((float) $min, $resultado) . $unidad : 'Sin referencia',
            'SIN_REFERENCIA' => 'Sin referencia',
            default => filled($min) ? $this->decimal((float) $min, $resultado) . $unidad : 'Sin referencia',
        };
    }

    private function referenciaConNivelLabel(ResultadoExamen $resultado): string
    {
        $referencia = $this->referenciaLabel($resultado);

        if (blank($resultado->ref_nivel_nombre)) {
            return $referencia;
        }

        return "{$resultado->ref_nivel_nombre}: {$referencia}";
    }

    private function decimal(float $value, ResultadoExamen $resultado): string
    {
        $decimales = $resultado->variante?->decimales ?? 2;

        return number_format($value, $decimales, '.', '');
    }

    private function edad(?Carbon $fechaNacimiento): ?int
    {
        return $fechaNacimiento?->age;
    }
}
