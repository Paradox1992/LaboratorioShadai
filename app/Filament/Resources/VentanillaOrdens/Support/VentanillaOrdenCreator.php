<?php

namespace App\Filament\Resources\VentanillaOrdens\Support;

use App\Models\OrdenLaboratorio;
use App\Models\Paciente;
use App\Models\ValorReferencia;
use App\Models\VentanillaOrden;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VentanillaOrdenCreator
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): VentanillaOrden
    {
        $selecciones = $this->seleccionesFromData($data);

        if ($selecciones === []) {
            throw ValidationException::withMessages([
                'selecciones' => 'Agrega al menos un examen.',
            ]);
        }

        return DB::transaction(function () use ($data, $selecciones): VentanillaOrden {
            $this->updatePaciente($data);

            $ventanillaOrden = VentanillaOrden::create([
                'paciente_id' => $data['paciente_id'],
                'usuario_id' => Auth::id(),
                'fecha_recepcion' => now(),
                'estado' => 'ABIERTA',
                'prioridad' => 'NORMAL',
                'observacion' => $data['observacion'] ?? null,
                'impresa' => false,
                'fecha_impresion' => null,
                'cantidad_impresiones' => 0,
            ]);

            $orden = OrdenLaboratorio::create([
                'ventanilla_orden_id' => $ventanillaOrden->id,
                'paciente_id' => $ventanillaOrden->paciente_id,
                'usuario_id' => $ventanillaOrden->usuario_id,
                'fecha_orden' => $ventanillaOrden->fecha_recepcion,
                'estado' => 'PENDIENTE',
                'prioridad' => 'NORMAL',
            ]);

            $this->crearResultados($orden, $selecciones);

            return $ventanillaOrden;
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function updatePaciente(array $data): void
    {
        $pacienteData = $this->pacienteData($data);

        if ($pacienteData === []) {
            return;
        }

        Paciente::query()
            ->whereKey($data['paciente_id'])
            ->update($pacienteData);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function pacienteData(array $data): array
    {
        $pacienteData = [];

        if (filled($data['paciente_telefono'] ?? null)) {
            $pacienteData['telefono'] = $data['paciente_telefono'];
        }

        if (filled($data['paciente_edad'] ?? null)) {
            $pacienteData['fecha_nacimiento'] = now()
                ->subYears((int) $data['paciente_edad'])
                ->toDateString();
        }

        return $pacienteData;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<int, array{resultado: mixed}>
     */
    private function seleccionesFromData(array $data): array
    {
        return collect($data['selecciones'] ?? [])
            ->filter(fn (array $seleccion): bool => filled($seleccion['valor_referencia_id'] ?? null))
            ->mapWithKeys(fn (array $seleccion): array => [
                (int) $seleccion['valor_referencia_id'] => [
                    'resultado' => $seleccion['resultado'] ?? null,
                ],
            ])
            ->all();
    }

    /**
     * @param  array<int, array{resultado: mixed}>  $selecciones
     */
    private function crearResultados(OrdenLaboratorio $orden, array $selecciones): void
    {
        $referenciaIds = array_keys($selecciones);
        $ordenPorReferencia = array_flip(array_map('strval', $referenciaIds));
        $ordenExamenes = [];
        $variantesRegistradas = [];

        ValorReferencia::query()
            ->with(['nivel', 'variante.examen.tipoMuestra', 'variante.unidadMedida'])
            ->whereIn('id', $referenciaIds)
            ->get()
            ->sortBy(fn (ValorReferencia $referencia): int => $ordenPorReferencia[(string) $referencia->id] ?? PHP_INT_MAX)
            ->each(function (ValorReferencia $referencia) use ($orden, $selecciones, &$ordenExamenes, &$variantesRegistradas): void {
                $variante = $referencia->variante;
                $examen = $variante?->examen;

                if (! $variante || ! $examen) {
                    return;
                }

                if (isset($variantesRegistradas[$variante->id])) {
                    throw ValidationException::withMessages([
                        'selecciones' => "La variante {$variante->nombre} tiene mas de un valor de referencia seleccionado. Elige solo el nivel/sexo que corresponde al paciente.",
                    ]);
                }

                $ordenExamenes[$examen->id] ??= $orden->examenesOrdenados()->create([
                    'examen_id' => $examen->id,
                    'nombre_examen_snapshot' => $examen->nombre,
                    'tipo_muestra_snapshot' => $examen->tipoMuestra?->nombre,
                    'requiere_ayuno_snapshot' => $examen->requiere_ayuno,
                    'tiempo_entrega_horas_snapshot' => $examen->tiempo_entrega_horas,
                    'estado' => 'PENDIENTE',
                ]);

                $ordenExamenes[$examen->id]->resultados()->create([
                    'variante_id' => $variante->id,
                    'valor_referencia_id' => $referencia->id,
                    ...$this->resultadoData($variante->tipo_resultado, $selecciones[$referencia->id]['resultado'] ?? null),
                    'unidad' => $referencia->unidad ?: ($variante->unidadMedida?->simbolo ?: $variante->unidad_manual),
                    'variante_nombre_snapshot' => $variante->nombre,
                    'ref_nivel_nombre' => $referencia->nivel?->nombre,
                    'ref_sexo' => $referencia->sexo,
                    'ref_operador' => $referencia->operador,
                    'ref_valor_min' => $referencia->valor_min,
                    'ref_valor_max' => $referencia->valor_max,
                    'ref_valor_texto' => $referencia->valor_texto,
                    'ref_unidad' => $referencia->unidad,
                    'estado_resultado' => 'SIN_CLASIFICAR',
                ]);

                $variantesRegistradas[$variante->id] = true;
            });
    }

    /**
     * @return array{resultado_numero?: float, resultado_texto?: string}
     */
    private function resultadoData(?string $tipoResultado, mixed $resultado): array
    {
        if (blank($resultado)) {
            return [];
        }

        $resultado = trim((string) $resultado);

        if ($tipoResultado === 'NUMERICO' && is_numeric($resultado)) {
            return ['resultado_numero' => (float) $resultado];
        }

        return ['resultado_texto' => $resultado];
    }
}
